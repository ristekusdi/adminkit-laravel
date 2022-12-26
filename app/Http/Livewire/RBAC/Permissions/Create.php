<?php

namespace App\Http\Livewire\RBAC\Permissions;

use App\Models\Menu;
use App\Models\Permission;
use Livewire\Component;

class Create extends Component
{
    public Permission $permission;

    protected $rules = [
        'permission.name' => 'required',
        'permission.menu_id' => 'required',
        'permission.group' => 'required',
    ];

    public function mount()
    {
        $this->permission = new Permission;
    }

    public function clearForm()
    {
        $this->resetValidation();
        $this->permission->name = '';
        $this->permission->menu_id = '';
        $this->permission->group = '';
    }

    public function render()
    {
        return view('livewire.rbac.permissions.create', [
            'menus' => Menu::where('path', '!=', '#')->get()
        ]);
    }

    public function updated($key, $value)
    {
        if ($key === 'permission.menu_id') {
            $menu = Menu::where('id', '=', $value)->first();
            $group_name = $menu->text;
            if ((int) $menu['parent'] !== 0) {
                $menus = Menu::get()->toArray();
                $root_parent = $this->getRootParent($menus, $menu['parent']);
                $root_menu = Menu::where('id', '=', $root_parent)->first();
                $group_name = "{$root_menu->text} {$group_name}";
            }
            $this->permission->group = $group_name;
        }
    }

    public function submit()
    {
        $this->validate();
        
        $this->permission->save();

        if ($this->permission) {
            $this->dispatchBrowserEvent('notyf:ok', [
                'message' => 'Permission berhasil disimpan!'
            ]);
        } else {
            $this->addError('errorMessage', 'Failed add role!');
        }
    }

    public function getRootParent($menus, $parent_id = 0)
    {
        $id = $parent_id;
        
        foreach ($menus as $menu) {
            if ($menu['id'] == $parent_id) {
                if ((int) $menu['parent'] !== 0) {
                    $id = $this->getRootParent($menus, $menu['parent']);
                } else {
                    $id = $menu['id'];
                }
            }
        }

        return $id;
    }
}
