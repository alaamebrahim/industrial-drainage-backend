<?php

namespace App\Http\Controllers\Claims;

use App\DataProcessors\Claims\ClaimDataProcess;
use App\Http\Controllers\Controller;
use App\Http\Requests\Claims\StoreClaimRequest;
use App\Http\Requests\SampleResults\StoreResultRequest;
use App\Http\Requests\SampleResults\UpdateResultRequest;
use App\Http\Resources\Results\ResultResource;
use App\Models\Claim;
use App\Models\Result;
use App\Models\ResultDetail;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class ClaimsController extends Controller
{
    public function index(): JsonResponse
    {
        ClaimDataProcess::calculate(Claim::query()->first());
        dd('');
        $data = Claim::query()
            ->with([
                'client',
                'result',
            ])
            ->orderBy('id', 'desc')
            ->paginate(25);
        return response()->json([
            'success' => true,
            'data' => ResultResource::collection($data)->resource,
        ]);
    }

    public function show($id): JsonResponse
    {
        $data = Result::query()
            ->where('id', $id)
            ->select(['id', 'client_id', 'result_date'])
            ->with([
                'resultDetails.sample',
                'resultDetails.sampleDetail',
            ])
            ->first();
        return response()->json([
            'success' => true,
            'data' => new ResultResource($data),
        ]);
    }

    public function store(StoreClaimRequest $request): JsonResponse
    {
        try {
            DB::beginTransaction();

//            $claim = Claim::query()->create($request->validated());

            ClaimDataProcess::calculate(Claim::query()->first());
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

    public function update($id, UpdateResultRequest $request): JsonResponse
    {
        try {
            DB::beginTransaction();

            Result::query()->where('id', $id)->update($request->only(['client_id', 'result_date']));

            Result::query()->where('id', $id)->first()?->resultDetails()->delete();

            $items = json_decode($request->get('items'), true);

            collect($items)
                ->each(function (array $item) use ($id) {
                    ResultDetail::query()
                        ->create([
                            'result_id' => $id,
                            'sample_id' => $item['sample_id'],
                            'sample_detail_id' => $item['sample_detail_id'],
                            'value' => $item['value'],
                        ]);
                });


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
}
