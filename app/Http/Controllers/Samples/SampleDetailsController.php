<?php

namespace App\Http\Controllers\Samples;

use App\Http\Controllers\Controller;
use App\Http\Requests\SampleDetails\StoreSampleDetailRequest;
use App\Http\Requests\SampleDetails\UpdateSampleDetailRequest;
use App\Http\Resources\Samples\SampleDetailResource;
use App\Models\SampleDetail;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class SampleDetailsController extends Controller
{
    public function index(): JsonResponse
    {
        $data = SampleDetail::query()
            ->with(['sample'])
            ->orderBy('sample_id', 'desc')
            ->orderBy('id', 'asc')
            ->paginate(25);
        return response()->json([
            'success' => true,
            'data' => SampleDetailResource::collection($data)->resource,
        ]);
    }

    public function show($id): JsonResponse
    {
        $data = SampleDetail::query()->where('id', $id)->with(['sample'])->orderBy('sample_id', 'desc')->first();
        return response()->json([
            'success' => true,
            'data' => new SampleDetailResource($data),
        ]);
    }

    public function store(StoreSampleDetailRequest $request): JsonResponse
    {
        try {
            DB::beginTransaction();
            SampleDetail::query()->create($request->validated());
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

    public function update($id, UpdateSampleDetailRequest $request): JsonResponse
    {
        try {
            DB::beginTransaction();
            SampleDetail::query()->where('id', $id)->update($request->validated());
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
