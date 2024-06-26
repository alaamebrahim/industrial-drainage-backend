<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use App\Http\Requests\Clients\StoreClientRequest;
use App\Http\Requests\Clients\UpdateClientRequest;
use App\Http\Resources\Clients\ClientResource;
use App\Models\Client;
use App\Models\Result;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClientsController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $data = Client::query()
            ->orderBy('id', 'desc')
            ->when($request->filled('is_active'), fn($query) => $query->where('is_active', $request->boolean('is_active')))
            ->when($request->filled('search'), fn($query) => $query->whereLike(['name', 'address'], $request->string('search')))
            ->paginate(25);
        return response()->json([
            'success' => true,
            'data' => ClientResource::collection($data)->resource,
        ]);
    }

    public function show($id): JsonResponse
    {
        $data = Client::query()
            ->where('id', $id)
            ->first();
        return response()->json([
            'success' => true,
            'data' => $data,
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
