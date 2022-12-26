<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Permission extends Model
{
    use HasFactory, SoftDeletes;

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public static function getGroupPermissions()
    {
        $permissions = self::select('id', 'name', 'group')->get()->toArray();
        $group_permissions = [];
        foreach ($permissions as $perm) {
            $group_permissions[$perm['group']][] = $perm;
        }
        return $group_permissions;
    }
}
