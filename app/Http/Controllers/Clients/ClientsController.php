<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use App\Http\Requests\Clients\StoreClientRequest;
use App\Http\Requests\Clients\UpdateClientRequest;
use App\Http\Resources\Clients\ClientResource;
use App\Models\Client;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class ClientsController extends Controller
{
    public function index(): JsonResponse
    {
        $data = Client::query()->orderBy('id', 'desc')->paginate(25);
        return response()->json([
            'success' => true,
            'data' => ClientResource::collection($data)->resource,
        ]);
    }

    public function store(StoreClientRequest $request): JsonResponse
    {
        try {
            DB::beginTransaction();
            Client::query()->create($request->validated());
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

    public function update($id, UpdateClientRequest $request): JsonResponse
    {
        try {
            DB::beginTransaction();
            Client::query()->where('id', $id)->update($request->validated());
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
