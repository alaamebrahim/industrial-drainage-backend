<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\Users\StoreUserRequest;
use App\Http\Requests\Users\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class UsersController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => User::query()->orderBy('id')->get(),
        ]);
    }

    public function store(StoreUserRequest $request)
    {
        try {
            User::query()->create([...$request->only(['email', 'enabled', 'password', 'username']), ...['full_name' => $request->get('fullName')]]);
        } catch (\Throwable $exception) {
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

    public function update(UpdateUserRequest $request): JsonResponse
    {
        try {
            $data = [
                ...$request->only(['email', 'enabled', 'username']),
                ...['full_name' => $request->get('fullName')],
            ];

            if ($request->has('password')) {
                $data['password'] = $request->get('password');
            }
            User::query()
                ->where('id', $request->get('id'))
                ->update($data);
        } catch (\Throwable $exception) {
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
