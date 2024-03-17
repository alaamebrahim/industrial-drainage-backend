<?php

namespace App\Http\Controllers\Claims;

use App\Data\Claims\UpdateClaimAdjustmentDateData;
use App\DataProcessors\Claims\ClaimDataProcess;
use App\Http\Controllers\Controller;
use App\Http\Requests\Claims\UpdateClaimAdjustmentDatesRequest;
use App\Models\Claim;
use App\Models\ClaimDetail;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UpdateClaimAdjustmentDatesController extends Controller
{
    public function __invoke(UpdateClaimAdjustmentDatesRequest $request): JsonResponse
    {
        try {
            DB::beginTransaction();

            $claim = Claim::query()->find($request->get('claim_id'));

            collect(json_decode($request->get('details'), true))
                ->each(function ($data) {

                    $data = UpdateClaimAdjustmentDateData::from([
                        'adjustment_date' => $data['adjustment_date'],
                        'claim_detail_id' => $data['claim_detail_id'],
                        'claim_id' => $data['claim_id'],
                    ]);

                    Log::info(json_encode($data));

                    $claimDetail = ClaimDetail::query()->find($data->claim_detail_id);

                    $claimDetail->update(['adjustment_date' => $data->adjustment_date]);

                    $claimDetail->resultDetail()->update(['adjustment_date' => $data->adjustment_date]);
                });

            $claim->details()->delete();

            ClaimDataProcess::calculate($claim);

            DB::commit();
        } catch (\Throwable $exception) {
            DB::rollBack();
            errorLog($exception);

            return response()->json([
                'success' => false,
                'message' => 'لم يتم الحفظ',
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'تم الحفظ بنجاح',
        ]);
    }
}
