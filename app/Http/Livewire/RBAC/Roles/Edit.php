<?php

namespace App\Http\Livewire\RBAC\Roles;

use App\Models\Permission;
use Livewire\Component;
use App\Models\Role;
use Illuminate\Support\Str;

class Edit extends Component
{
    public $role;
    public $selectedGroupPermissions = [];
    public $permissions = [];

    protected $rules = [
        'role.name' => 'required'
    ];

    public function mount(Role $role)
    {
        $this->role = $role;
    }

    public function render()
    {
        return view('livewire.rbac.roles.edit', [
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
                'message' => 'Peran berhasil diperbaharui!'
            ]);
        } else {
            $this->addError('errorMessage', 'Failed edit role!');
        }
    }
}
