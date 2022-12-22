<?php

namespace App\Http\Livewire\RBAC\Roles;

use Livewire\Component;
use App\Models\Role;

class Edit extends Component
{
    public $role;

    protected $rules = [
        'role.name' => 'required'
    ];

    public function mount(Role $role)
    {
        $this->role = $role;
    }

    public function render()
    {
        return view('livewire.rbac.roles.edit');
    }

    public function clearForm()
    {
        $this->resetValidation();
        $this->role->name = '';
    }

    public function submit()
    {
        $this->validate();
        
        $this->role->save();

        if ($this->role) {
            $this->dispatchBrowserEvent('notyf:ok', [
                'message' => 'Peran berhasil diperbaharui!'
            ]);
        } else {
            $this->addError('errorMessage', 'Failed edit role!');
        }
    }
}
