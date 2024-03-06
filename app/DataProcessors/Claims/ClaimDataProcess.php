<?php

namespace App\DataProcessors\Claims;

use App\Models\Claim;
use App\Models\ClaimDetail;
use App\Models\ResultDetail;
use App\Models\SampleDetail;
use Carbon\Carbon;

class ClaimDataProcess
{

    public static function calculate(Claim $claim): Claim
    {
        $result = $claim->result;

        $resultDate = $claim->result_date;

        $startDate = $claim->start_date;

        $endDate = $claim->end_date;

        $totalAmount = 0;
        collect($result->resultDetails)
            ->each(function (ResultDetail $resultDetail) use (&$totalAmount, $resultDate, $startDate, $endDate, $claim) {
                $value = self::calculateValue($resultDetail, $claim, $resultDate, $startDate, $endDate);
                $resultDetail->load(['sampleDetail.sample']);
                ClaimDetail::query()->create([
                    'claim_id' => $claim->id,
                    'key' => $resultDetail->sampleDetail?->sample?->name,
                    'value' => $value
                ]);

                $totalAmount += $value;
            });

        $claim->update(['total_amount' => $totalAmount]);

        return $claim->refresh();
    }

    protected static function getSampleDetail(int $sampleDetailId): array
    {
        $sampleDetail = SampleDetail::query()->find($sampleDetailId);
        return [(int)$sampleDetail->price, (int)$sampleDetail->duration];
    }

    public static function calculateArray($resultDate, $startDate, $endDate, $time_limit): array
    {
        $start_difference = Carbon::parse($resultDate)->diffInDays($startDate);

        $total_duration = Carbon::parse($startDate)->diffInDays($endDate);

        $total_duration -= $start_difference;

        $repetitions = ceil($total_duration / $time_limit);

        $result = array_fill(0, $repetitions, $time_limit);

        $remaining_duration = $total_duration % $time_limit;

        if ($remaining_duration > 0) {
            $result[$repetitions - 1] = $remaining_duration;
        }

        if (count($result) > 3) {
            $sum_values = array_sum(array_slice($result, 2));

            return [
                $result[0],
                $result[1],
                $sum_values,
            ];
        }

        return $result;
    }

    public static function calculateValue(ResultDetail $resultDetail, Claim $claim, string $resultDate, string $startDate, string $endDate): int|float
    {
        [$price, $duration] = self::getSampleDetail($resultDetail->sample_detail_id);

        $consumption = $claim->consumption;

        $durations = self::calculateArray($resultDate, $startDate, $endDate, $duration);

        $value = 0;

        collect($durations)
            ->each(function (int $duration, $index) use (&$value, $price, $consumption) {

                $calculatedValue = $price * $consumption * ($duration / 30);

                if ($index == 0) {
                    $value += $calculatedValue;
                }

                if ($index == 1) {
                    $value += $calculatedValue * 2;
                }

                if ($index > 1) {
                    $value += $calculatedValue * 5;
                }
            });
        return $value;
    }
}
