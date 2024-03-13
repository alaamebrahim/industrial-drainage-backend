<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\Permission;
use App\Models\UserPermission;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class RefreshAccessTokenController extends Controller
{
    public function __invoke($request): JsonResponse
    {
        $user = Auth::user();

        $permissions = Permission::query()->whereIn('id', UserPermission::query()->where('user_id', $user->id)->pluck('permission_id')->toArray())->get();

        $user->tokens()->delete();

        $user->setAttribute('permissions', $permissions);

        $token = $user->createToken($user->name, $permissions->pluck('name')->toArray());

        return response()->json([
            'access_token' => $token->plainTextToken,
            'expires' => config('sanctum.expiration'),
            'refresh_token' => $token->plainTextToken,
        ]);

    }
}
