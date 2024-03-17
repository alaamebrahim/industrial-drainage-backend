<?php

namespace App\DataProcessors\Claims;

use App\Http\Resources\Results\ResultDetailResource;
use App\Models\Claim;
use App\Models\ClaimDetail;
use App\Models\Client;
use App\Models\Result;
use App\Models\ResultDetail;
use App\Models\Sample;
use App\Models\SampleDetail;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

class ClaimDataProcessOld
{
    public static function calculate(Claim $claim): Claim
    {

        Log::info('---------------------------------------------------------------------------------------------------------------------------------------------------');
        Log::info("Calculation start for claim: $claim->id, start_date is: $claim->start_date, end_date is: $claim->end_date, client name: {$claim->client?->name}");

        $results = Result::query()
            ->orderBy('result_date')
            ->where('client_id', $claim->client_id)
            ->get();

        Log::info("Count of results is: {$results->count()}");

        $totalAmount = 0;

        $results->each(function (Result $result, $index) use ($results, $claim, &$totalAmount) {
            Log::info("**************** Result index:  $index start");

            $totalAmount += self::calculateSingleResult($result, $claim, $results->max('id'));

            Log::info("**************** Result index:  $index end");
        });

        Log::info("Total amount of claim is: $totalAmount");
        Log::info('---------------------------------------------------------------------------------------------------------------------------------------------------');

        $claim->update(['total_amount' => $totalAmount]);

        return $claim->refresh();

    }

    public static function calculateSingleResult(Result $result, Claim $claim, int $lastResultId): float
    {
        $result->load(['resultDetails']);

        $resultDate = $result->result_date;

        $startDate = $claim->start_date;

        $endDate = $claim->end_date;

        $valuesToCheck = [1, 2];

        $arrayToSearch = $result->resultDetails->map(fn ($resultDetail) => $resultDetail->sample_id)->toArray();

        $calculate60PercentageOfCOD = count(array_intersect($valuesToCheck, $arrayToSearch)) === count($valuesToCheck);

        $totalAmount = 0;

        $preparedResultDetails = self::prepareResultDetails($result->id, $claim->client_id, $endDate);
        dd($preparedResultDetails->pluck('sample_detail_id'));
        $preparedResultDetails
            ->each(callback: function (ResultDetailResource $resultDetail) use ($result, &$totalAmount, $resultDate, $startDate, $endDate, $claim, $calculate60PercentageOfCOD, $lastResultId) {
                Log::info("**************** Result detail id:  $resultDetail->id start");

                $startDate = Carbon::parse($resultDate)->lte(Carbon::parse($startDate)) ? $startDate : $resultDate;

                if ($lastResultId == $result->id) {
                    $endDate = $claim->end_date;
                } else {
                    // Error here
                    $endDate = Carbon::parse($resultDetail->result_end_date)->lte(Carbon::parse($endDate)) ? $resultDetail->result_end_date : $endDate;
                }

                Log::info("endDate for resultDetail $resultDetail->id is: $endDate");

                $value = self::calculateClaimDetailItemValue(
                    resultDetail: $resultDetail,
                    claim: $claim,
                    resultDate: $resultDate,
                    startDate: $startDate,
                    endDate: $endDate
                );

                Log::info("value for resultDetail $resultDetail->id is: $value");

                if ($resultDetail->sample_id == 3 && $calculate60PercentageOfCOD) {
                    Log::info("60% for COD is calculated for resultDetail $resultDetail->id");

                    $value = $value * 0.6;
                }

                ClaimDetail::query()->create([
                    'claim_id' => $claim->id,
                    'key' => Sample::query()->find($resultDetail->sample_id)?->name,
                    'value' => $value,
                    'result_detail_id' => $resultDetail->id,
                    'start_date' => $startDate,
                    'end_date' => $endDate,
                ]);

                $totalAmount += $value;
                Log::info("**************** Result detail id:  $resultDetail->id end");
            });

        return $totalAmount;
    }

    public static function prepareResultDetails(?int $resultId, int $clientId, $endDate): Collection
    {
        $client = Client::query()->where('id', $clientId)->first();

        $results = $client->results->load(['client', 'resultDetails.sample', 'resultDetails.result', 'resultDetails.sampleDetail']);

        $resultDetails = ResultDetail::query()
            ->with(['result' => function ($query) {
                $query->select('id', 'result_date', 'client_id');
            }, 'sample', 'sampleDetail'])
            ->whereIn('result_id', $results->pluck('id')->toArray())
            ->orderBy('sample_id')
            ->get();

        $resultDetails = $resultDetails->map(function ($detail) use ($endDate) {
            $resultDate = $detail->result->result_date;

            $nextResultDate = Result::query()
                ->where('client_id', $detail->result->client_id)
                ->whereDate('result_date', '>', $resultDate)
                ->first()?->result_date;

            // If there are newer result details, find the date before the newest result_date
            if ($nextResultDate) {
                $resultEndDate = date('Y-m-d', strtotime('-1 day', strtotime($nextResultDate)));
            } else {
                // If there are no newer result details, set result_end_date to the day before the current result_date
                $resultEndDate = date('Y-m-d', strtotime('-1 day', strtotime($endDate)));
            }

            // Set the result_end_date for the current detail
            $detail->result_end_date = $resultEndDate;

            Log::info('Final resultDetails is: '.json_encode($detail));

            return $detail;
        })->filter(fn ($resultDetail) => $resultId == null || $resultDetail->result_id == $resultId && Carbon::parse($resultDetail->result?->result_date)->lte($endDate));

        return ResultDetailResource::collection($resultDetails)->collection;
    }

    public static function calculateClaimDetailItemValue(ResultDetailResource $resultDetail, Claim $claim, string $resultDate, string $startDate, string $endDate): int|float
    {
        [$price, $duration] = self::getSampleDetail($resultDetail->sample_detail_id);

        $consumption = $claim->consumption;

        $durations = self::calculateArray(
            resultDate: $resultDate,
            startDate: $startDate,
            endDate: $endDate,
            time_limit: $duration
        );

        Log::info("Durations for $resultDetail->id is: ".json_encode($durations)." startDate is $startDate and endDate is $endDate and time_limit is $duration");

        $value = 0;

        collect($durations)
            ->each(function (int $duration, $index) use (&$value, $price, $consumption) {

                $calculatedValue = $price * $consumption * ($duration / 30);

                if ($index == 0) {
                    $value += $calculatedValue;
                    Log::info("calculatedValue is $calculatedValue while duration is $duration and consumption is $consumption and price is $price, so equation is: $price * $consumption * ($duration / 30)");

                }

                if ($index == 1) {
                    $value += $calculatedValue * 2;
                    $logValue = $calculatedValue * 2;
                    Log::info("calculatedValue is $logValue while duration is $duration and consumption is $consumption and price is $price, so equation is: $price * 2 * $consumption * ($duration / 30)");

                }

                if ($index > 1) {
                    $value += $calculatedValue * 5;
                    $logValue = $calculatedValue * 5;
                    Log::info("calculatedValue is $logValue while duration is $duration and consumption is $consumption and price is $price, so equation is: $price * 5 * $consumption * ($duration / 30)");

                }
            });

        return $value;
    }

    protected static function getSampleDetail(int $sampleDetailId): array
    {
        $sampleDetail = SampleDetail::query()->find($sampleDetailId);

        return [(float) $sampleDetail->price, (int) $sampleDetail->duration];
    }

    public static function calculateArray($resultDate, $startDate, $endDate, $time_limit): array
    {
        $start_difference = Carbon::parse($resultDate)->startOfDay()->diffInDays(Carbon::parse($startDate)->endOfDay());

        Log::info("time_limit is: $time_limit");

        Log::info("start_difference is: $start_difference");

        $total_duration = Carbon::parse($startDate)->startOfDay()->diffInDays(Carbon::parse($endDate)->endOfDay());

        Log::info("total_duration is: $total_duration");

        if ($time_limit == 0) {
            return [
                $total_duration,
            ];
        }

        $repetitions = floor(($total_duration + $start_difference) / $time_limit);

        Log::info("repetitions is: $repetitions");

        $result = array_fill(0, $repetitions, $time_limit);

        Log::info('result is: '.json_encode($result));

        $remaining_duration = ($total_duration + $start_difference) - array_sum($result);

        if ($remaining_duration < 0) {
            $result[$repetitions - 1] = $result[$repetitions - 1] - $remaining_duration;
        }

        if ($remaining_duration > 0) {
            $result[$repetitions] = $remaining_duration;
        }

        if (count($result) > 3) {
            $sum_values = array_sum(array_slice($result, 2));

            $result = [
                $result[0],
                $result[1],
                $sum_values,
            ];
        }

        if ($start_difference == 0) {
            return $result;
        }

        return collect($result)
            ->map(function ($resultItem, $index) use (&$start_difference) {
                if ($start_difference <= 0) {
                    return $resultItem;
                }

                if ($start_difference >= $resultItem) {
                    $start_difference -= $resultItem;

                    return 0;
                }

                $finalResultItem = $resultItem - $start_difference;

                $start_difference -= $resultItem;

                if ($start_difference < 0) {
                    $start_difference = 0;
                }

                return $finalResultItem;

            })->toArray();
    }
}
