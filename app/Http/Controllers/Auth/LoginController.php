<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\Permission;
use App\Models\UserPermission;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function __invoke(LoginRequest $request): JsonResponse
    {
        if (Auth::attempt(['name' => $request->get('username'), 'password' => $request->get('password'), 'is_active' => true])) {

            $user = Auth::user();

            $permissions = Permission::query()->whereIn('id', UserPermission::query()->where('user_id', $user->id)->pluck('permission_id')->toArray())->get();

            $user->tokens()->delete();

            $user->setAttribute('permissions', $permissions);

            $token = $user->createToken($user->name, $permissions->pluck('name')->toArray());

            return response()->json(['token' => $token->plainTextToken]);
        }

        return response()->json(['success' => false, 'message' => 'بيانات الدخول غير صحيحة'], 403);

    }
}
