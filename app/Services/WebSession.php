<?php

namespace App\Services;

use App\Models\Role;

class WebSession
{
    public function setRoleActive($role)
    {
        $role_active = [];
        $role = Role::select('id', 'name')->where('name', '=', $role)->first();
        if ($role) {
            $role_active = $role->toArray();
        }
        return $role_active;
    }

    public function getRoleActive($role)
    {
        if (session()->has('role_active')) {
            return session()->get('role_active');
        } else {
            $role_active = $this->setRoleActive($role);
            session()->put('role_active', $role_active);
            session()->save();
            return $role_active;
        }
    }

    public function getRoleActivePermissions($role)
    {
        $role_active = $this->setRoleActive($role);
        if (session()->has('role_active')) {
            $role_active = session()->get('role_active');
        }

        $permissions = Role::where('name', $role_active['name'])->first()->permissions()->get()->toArray();
        
        $selected_permissions = [];
        foreach ($permissions as $perm) {
            array_push($selected_permissions, $perm['name']);
        }
        
        return $selected_permissions;
    }

    public function changeRoleActive($role_active)
    {
        session()->forget('role_active');
        session()->save();
        $role_active = $this->setRoleActive($role_active);
        session()->put('role_active', $role_active);
        session()->save();
    }

    public function forgetSession()
    {
        session()->forget(['role_active', 'role_active_permissions']);
        session()->save();
    }
}
