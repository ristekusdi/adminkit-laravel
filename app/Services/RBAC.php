<?php

namespace App\Services;

use App\Models\Role;
use Illuminate\Support\Facades\DB;

class RBAC
{
    public function sync($user)
    {
        // Note: I'm not sure should we add unud users to table unud_users.
        // If yes, then it will be like third-party that use OAuth2 mechanism like Moodle.
        // Is that will be redundant with our central user data like Keycloak?
        // Then, what's the benefit to store unud users to table unud_users?
        // For now, I will let it like this.
        if (DB::table('unud_users')->where('sso_id', $user['unud_sso_id'])->doesntExist()) {
            DB::table('unud_users')->insert([
                'id' => $user['sub'],
                'name' => $user['family_name'],
                'email' => $user['email'],
                'username' => $user['preferred_username'],
                'identifier' => $user['given_name'],
                'sso_id' => $user['unud_sso_id'],
                'user_type_id' => $user['unud_user_type_id'],
                'created_at' => now()
            ]);
        }

        // Get rbac roles by client_roles
        $roles = collect(Role::select('id')->whereIn('name', $user['client_roles'])->get())->pluck('id')->toArray();
        $user_roles = collect(DB::table('role_user')->select('role_id')->where('sso_id', $user['unud_sso_id'])->get())->pluck('role_id')->toArray();
        
        foreach ($roles as $role) {
            if (!in_array($role, $user_roles)) {
                DB::table('role_user')->insert([
                    'role_id' => $role,
                    'sso_id' => $user['unud_sso_id'],
                ]);
            }
        }
    }
}
