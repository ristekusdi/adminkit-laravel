<?php

namespace App\Http\Livewire\RBAC\Roles;

use Illuminate\Support\Str;
use App\Models\Permission;
use App\Models\Role;
use Livewire\Component;

class Create extends Component
{
    public Role $role;
    public $selectedGroupPermissions = [];
    public $permissions = [];

    protected $rules = [
        'role.name' => 'required'
    ];

    public function mount()
    {
        $this->role = new Role;
    }

    public function render()
    {
        return view('livewire.rbac.roles.create', [
            'group_permissions' => Permission::getGroupPermissions()
        ]);
    }

    public function clearForm()
    {
        $this->resetValidation();
        $this->role->name = '';
        $this->selectedGroupPermissions = [];
        $this->permissions = [];
    }

    public function updated($key, $value)
    {
        $explode = Str::of($key)->explode('.');
        if ($explode[0] === 'selectedGroupPermissions' && is_string($value)) {
            $permissions_id = Permission::where('group', '=', $value)->pluck('id')->map(fn($id) => (string) $id)->toArray();
            $this->permissions = array_values(array_unique(array_merge_recursive($this->permissions, $permissions_id)));
        } else if ($explode[0] === 'selectedGroupPermissions' && empty($value)) {
            $permissions_id = Permission::where('group', '=', $explode[1])->pluck('id')->map(fn($id) => (string) $id)->toArray();
            $this->permissions = array_merge(array_diff($this->permissions, $permissions_id));
        }
    }

    public function submit()
    {
        $this->validate();
        $this->role->name = trim($this->role->name);
        $this->role->save();
        $this->role->permissions()->sync($this->permissions);

        if ($this->role) {
            $this->dispatchBrowserEvent('notyf:ok', [
                'message' => 'Peran berhasil disimpan!'
            ]);
        } else {
            $this->addError('errorMessage', 'Failed add role!');
        }
    }
}
