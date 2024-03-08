<?php

namespace App\Http\Controllers\Manage\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\Manage\Users\StoreUserRequest;
use App\Http\Requests\Manage\Users\UpdateUserRequest;
use App\Http\Resources\Manage\Users\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UsersController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $data = User::query()
            ->when($request->filled('is_active'), fn($query) => $query->where('is_active', $request->boolean('is_active')))
            ->when($request->filled('search'), fn($query) => $query->whereLike(['name', 'email'], $request->string('search')))
            ->paginate(25);
        return response()->json([
            'success' => true,
            'data' => UserResource::collection($data)->resource,
        ]);
    }

    public function show($id): JsonResponse
    {
        $data = User::query()
            ->where('id', $id)
            ->first();
        return response()->json([
            'success' => true,
            'data' => new UserResource($data),
        ]);
    }

    public function store(StoreUserRequest $request): JsonResponse
    {
        try {
            DB::beginTransaction();
            $user = User::query()->create($request->only(['name', 'email', 'is_active', 'password']));

            $user->givePermission(1);

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

    public function update($id, UpdateUserRequest $request): JsonResponse
    {
        try {
            DB::beginTransaction();

            User::query()->where('id', $id)->update($request->only(['name', 'email', 'is_active']));

            if ($request->has('password')) {
                User::query()->where('id', $id)->update(['password' => $request->get('password')]);
            }
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
