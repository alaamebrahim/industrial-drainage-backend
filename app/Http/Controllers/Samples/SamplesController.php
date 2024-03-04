<?php

namespace App\Http\Controllers\Samples;

use App\Http\Controllers\Controller;
use App\Http\Requests\Samples\StoreSampleRequest;
use App\Http\Requests\Samples\UpdateSampleRequest;
use App\Http\Resources\Samples\SampleResource;
use App\Models\Sample;
use App\Models\SampleResult;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class SamplesController extends Controller
{
    public function index(): JsonResponse
    {
        $data = Sample::query()->orderBy('id', 'desc')->paginate(25);
        return response()->json([
            'success' => true,
            'data' => SampleResource::collection($data)->resource,
        ]);
    }

    public function show($id): JsonResponse
    {
        $data = Sample::query()
            ->where('id', $id)
            ->first();
        return response()->json([
            'success' => true,
            'data' => $data,
        ]);
    }

    public function store(StoreSampleRequest $request): JsonResponse
    {
        try {
            DB::beginTransaction();
            Sample::query()->create($request->validated());
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

    public function update($id, UpdateSampleRequest $request): JsonResponse
    {
        try {
            DB::beginTransaction();
            Sample::query()->where('id', $id)->update($request->validated());
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
