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
        $this->permissions = $role->permissions()->pluck('id')->toArray();
        $group_permissions = Permission::getGroupPermissions();
        
        $selectedGroupPermissions = [];
        foreach ($group_permissions as $key => $group_perm) {
            $perm_ids = array_column($group_perm, 'id');
            $comparator = [];
            foreach ($this->permissions as $perm_id) {
                if (in_array($perm_id, $perm_ids)) {
                    array_push($comparator, $perm_id);
                }
            }

            if ($comparator === $perm_ids) {
                array_push($selectedGroupPermissions, $key);
            }
        }
        
        foreach ($selectedGroupPermissions as $key => $value) {
            $this->selectedGroupPermissions[$value] = $value;
        }
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
