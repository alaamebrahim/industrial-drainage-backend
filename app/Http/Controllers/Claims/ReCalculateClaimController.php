<?php

namespace App\Http\Controllers\Claims;

use App\DataProcessors\Claims\ClaimDataProcess;
use App\Http\Controllers\Controller;
use App\Models\Claim;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReCalculateClaimController extends Controller
{
    public function __invoke(Request $request): JsonResponse
    {
        try {
            DB::beginTransaction();

            $claim = Claim::query()->find($request->get('claim_id'));

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
