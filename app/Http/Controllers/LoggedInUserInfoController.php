<?php

namespace App\Http\Controllers;


use App\Models\Permission;
use App\Models\UserPermission;
use Illuminate\Http\JsonResponse;

class LoggedInUserInfoController
{
    public function __invoke(): ?JsonResponse
    {
        if (!auth()->check()) {
            abort(403);
        }
        $permissions = Permission::query()
            ->whereIn('id', UserPermission::query()->where('user_id', auth()->id())
                ->pluck('permission_id')
                ->toArray())
            ->get();

        return response()->json([
            'userName' => userName(),
            'permissions' => $permissions
        ]);
    }
}
