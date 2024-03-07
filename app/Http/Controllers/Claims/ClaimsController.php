<?php

namespace App\Http\Controllers\Claims;

use App\DataProcessors\Claims\ClaimDataProcess;
use App\Http\Controllers\Controller;
use App\Http\Requests\Claims\StoreClaimRequest;
use App\Http\Requests\SampleResults\StoreResultRequest;
use App\Http\Requests\SampleResults\UpdateResultRequest;
use App\Http\Resources\Claims\ClaimResource;
use App\Http\Resources\Results\ResultResource;
use App\Models\Claim;
use App\Models\ClaimDetail;
use App\Models\Result;
use App\Models\ResultDetail;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class ClaimsController extends Controller
{
    public function index(): JsonResponse
    {
        $data = Claim::query()
            ->with([
                'client',
                'result',
                'details',
            ])
            ->orderBy('id', 'desc')
            ->paginate(25);
        return response()->json([
            'success' => true,
            'data' => ClaimResource::collection($data)->resource,
        ]);
    }

    public function show($id): JsonResponse
    {
        $data = Claim::query()
            ->with([
                'client',
                'result',
                'details',
            ])
            ->where('id', $id)
            ->first();
        return response()->json([
            'success' => true,
            'data' => new ClaimResource($data),
        ]);
    }

    public function store(StoreClaimRequest $request): JsonResponse
    {
        try {
            DB::beginTransaction();

            $claim = Claim::query()->create($request->validated());

            ClaimDataProcess::calculate($claim);

            DB::commit();
        } catch (\Throwable $exception) {
            DB::rollBack();
            errorLog($exception);
            return response()->json([
                'success' => false,
                'message' => 'لم يتم الحفظ'
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'تم الحفظ بنجاح'
        ]);
    }

    public function destroy($id)
    {

        try {
            DB::beginTransaction();

            ClaimDetail::query()->where('claim_id', $id)->delete();

            Claim::query()->where('id', $id)->delete();

            DB::commit();
        } catch (\Throwable $exception) {
            DB::rollBack();
            errorLog($exception);
            return response()->json([
                'success' => false,
                'message' => 'لم يتم الحفظ'
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'تم الحذف بنجاح'
        ]);
    }
}