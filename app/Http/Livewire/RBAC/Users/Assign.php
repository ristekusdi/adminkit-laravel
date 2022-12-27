<?php

namespace App\Http\Livewire\RBAC\Users;

use App\Models\Role;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use RistekUSDI\RBAC\Connector\Connector;

class Assign extends Component
{
    public $user;
    public $name;
    public $username;
    public $identifier;
    public $user_id;
    public $unud_sso_id;
    public $selectedRoles;

    public function mount($username)
    {
        $this->user = (new Connector)->showUser($username);
        $this->identifier = $this->user['firstName'];
        $this->name = $this->user['lastName'];
        $this->username = $this->user['username'];
        $this->user_id = $this->user['id'];
        $this->unud_sso_id = isset($this->user['attributes']['unud_sso_id']) ? $this->user['attributes']['unud_sso_id']['0'] : 0;
        $assigned_user_client_roles = (new Connector)->getAssignedUserClientRoles($this->user_id, config('sso.client_id'));
        $selectedRoles = [];
        foreach ($assigned_user_client_roles as $user_client_role) {
            array_push($selectedRoles, $user_client_role['name']);
        }
        $this->selectedRoles = $selectedRoles;
    }

    public function clearForm()
    {
        // TODO: reset field selectedRoles
    }

    public function render()
    {
        $roles = collect(Role::get())->pluck('name')->toArray();
        $client_roles = (new Connector)->getClientRoles(config('sso.client_id'), $roles);
        return view('livewire.rbac.users.assign', [
            'roles' => $client_roles
        ]);
    }

    public function submit()
    {
        DB::table('role_user')->where('sso_id', '=', $this->unud_sso_id)->delete();

        // $this->validate();
        $roles = collect(Role::get())->toArray();
        foreach ($roles as $role) {
            if (in_array($role['name'], $this->selectedRoles)) {
                DB::table('role_user')->insert([
                    'role_id' => $role['id'],
                    'sso_id' => $this->unud_sso_id,
                ]);
            }
        }

        $response = (new Connector())->syncAssignedUserClientRoles($this->user_id, config('sso.client_id'), $this->selectedRoles);

        if ($response['code'] === 200) {
            $this->dispatchBrowserEvent('notyf:ok', [
                'message' => $response['body']['message']
            ]);
        } else {
            $this->dispatchBrowserEvent('notyf:error', [
                'message' => $response['body']['message']
            ]);
        }
    }
}
