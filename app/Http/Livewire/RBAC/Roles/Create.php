<?php

namespace App\Http\Livewire\RBAC\Roles;

use App\Models\Role;
use Livewire\Component;

class Create extends Component
{
    public Role $role;

    protected $rules = [
        'role.name' => 'required'
    ];

    public function mount()
    {
        $this->role = new Role;
    }

    public function render()
    {
        return view('livewire.rbac.roles.create');
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
                'message' => 'Peran berhasil disimpan!'
            ]);
        } else {
            $this->addError('errorMessage', 'Failed add role!');
        }
    }
}
