<?php

namespace App\Http\Controllers\Results;

use App\Http\Controllers\Controller;
use App\Http\Requests\SampleResults\StoreResultRequest;
use App\Http\Requests\SampleResults\UpdateResultRequest;
use App\Http\Resources\Results\ResultResource;
use App\Models\Result;
use App\Models\ResultDetail;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class ResultsController extends Controller
{
    public function index(): JsonResponse
    {
        $data = Result::query()
            ->with([
                'client',
                'resultDetails.sample',
                'resultDetails.sampleDetail',
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

    public function store(StoreResultRequest $request): JsonResponse
    {
        try {
            DB::beginTransaction();

            $sampleResult = Result::query()->create($request->only(['client_id', 'result_date']));

            $items = json_decode($request->get('items'), true);

            collect($items)
                ->each(function (array $item) use ($sampleResult) {
                    ResultDetail::query()
                        ->create([
                            'result_id' => $sampleResult->id,
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
