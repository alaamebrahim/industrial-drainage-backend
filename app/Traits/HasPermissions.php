<?php

namespace App\Traits;

use App\Models\Permission;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

trait HasPermissions
{
    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(Permission::class, 'user_permissions', 'user_id', 'permission_id');
    }

    public function hasPermissionTo($permission): bool
    {
        return $this->permissions->pluck('name')->flatten()->contains($permission);
    }

    public function givePermission($permission): void
    {
        $this->permissions()->attach($permission);
    }

    public function revokePermission($permission): void
    {
        $this->permissions()->detach($permission);
    }
}
