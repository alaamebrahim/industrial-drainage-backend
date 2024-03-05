<?php

namespace App\Http\Controllers\SampleResults;

use App\Http\Controllers\Controller;
use App\Http\Requests\SampleResults\StoreSampleResultRequest;
use App\Http\Requests\SampleResults\UpdateSampleResultRequest;
use App\Http\Resources\SampleResults\SampleResultResource;
use App\Models\SampleResult;
use App\Models\SampleResultDetail;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class SampleResultsController extends Controller
{
    public function index(): JsonResponse
    {
        $data = SampleResult::query()
            ->with([
                'client',
                'resultDetails.sample',
                'resultDetails.sampleDetail',
            ])
            ->orderBy('id', 'desc')
            ->paginate(25);
        return response()->json([
            'success' => true,
            'data' => SampleResultResource::collection($data)->resource,
        ]);
    }

    public function show($id): JsonResponse
    {
        $data = SampleResult::query()
            ->where('id', $id)
            ->select(['id', 'client_id', 'sample_result_date'])
            ->with([
                'resultDetails.sample',
                'resultDetails.sampleDetail',
            ])
            ->first();
        return response()->json([
            'success' => true,
            'data' => new SampleResultResource($data),
        ]);
    }

    public function store(StoreSampleResultRequest $request): JsonResponse
    {
        try {
            DB::beginTransaction();

            $sampleResult = SampleResult::query()->create($request->only(['client_id', 'sample_result_date']));

            $items = json_decode($request->get('items'), true);

            collect($items)
                ->each(function (array $item) use ($sampleResult) {
                    SampleResultDetail::query()
                        ->create([
                            'sample_result_id' => $sampleResult->id,
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

    public function update($id, UpdateSampleResultRequest $request): JsonResponse
    {
        try {
            DB::beginTransaction();

            SampleResult::query()->where('id', $id)->update($request->only(['client_id', 'sample_result_date']));

            SampleResult::query()->where('id', $id)->first()?->resultDetails()->delete();

            $items = json_decode($request->get('items'), true);

            collect($items)
                ->each(function (array $item) use ($id) {
                    SampleResultDetail::query()
                        ->create([
                            'sample_result_id' => $id,
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
