<?php

namespace App\Models\SSO\Web;

use App\Facades\WebSession;
use Illuminate\Support\Facades\DB;
use RistekUSDI\SSO\Laravel\Models\Web\User as Model;

class User extends Model
{
    protected $appends = ['role_active', 'role_active_permissions'];

    public function getRoleActiveAttribute()
    {
        return WebSession::getRoleActive($this->getAttribute('client_roles')['0']);
    }

    public function getRoleActivePermissionsAttribute()
    {
        return WebSession::getRoleActivePermissions($this->getAttribute('client_roles')['0']);
    }

    public function changeRoleActive($role_active)
    {
        WebSession::changeRoleActive($role_active);
    }

    public function roles()
    {
        $roles = DB::table('roles')->select('id', 'name')
            ->join('role_user', 'roles.id', '=', 'role_user.role_id')
            ->where('role_user.sso_id', '=', $this->getAttribute('unud_sso_id'))
            ->get();
        return collect($roles)->map(function ($role) {
            return json_decode(json_encode($role), true);
        })->toArray();
    }
}
