<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Menu extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public function scopeWithPermission($query)
    {
        return $query->select('menus.id', 'menus.text', 'menus.path', 'menus.icon',
        'menus.parent', 'menus.order', 'permissions.name as perm_name')
        ->join('permissions', 'permissions.menu_id', '=', 'menus.id', 'left')
        ->groupBy('menus.id');
    }
}
