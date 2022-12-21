<?php

namespace App\Http\Livewire\Menu;

use App\Models\Menu;
use Livewire\Component;

class Create extends Component
{
    public $text;
    public $path;
    public $parent;
    public $sub_parent;
    public $level = 0;
    
    // Dropdown
    public $sub_parents = [];

    public $selectedParent = null;

    protected $rules = [
        'text' => 'required',
        'path' => 'required',
    ];

    public function render()
    {
        return view('livewire.menu.create', [
            'parents' => Menu::where('parent', '=', '0')->get(),
        ]);
    }

    public function updatedParent($value)
    {
        if (!empty($value)) {
            $menus = Menu::get()->toArray();
            $this->selectedParent = $value;
            $sub_parents_arr = $this->buildSubParentsArray($menus, $value);
            $parent = Menu::where('id', '=', $this->selectedParent)->first()->toArray();
            $this->sub_parents = array_merge([array_merge($parent, ['level' => '1'])], $sub_parents_arr);
        } else {
            $this->selectedParent = 0;
            $this->sub_parents = [];
        }
    }

    /**
     * $level is a level of nested menu.
     * Example:
     * - Login as (level 1)
     * - RBAC (level 1)
     *   - Users (level 2)
     *   - Roles (level 2)
     *   - Permissions (level 2)
     * 
     * In this app, maximum level of nested menu is level 3.
     * More than that is not allowed!
     * Example:
     * - Login as (level 1)
     * - RBAC (level 1)
     *   - Users (level 2)
     *   - Roles (level 2)
     *     - Roles (level 3)
     *     - Role Type (level 3)
     *   - Permissions (level 2)
     */
    public function buildSubParentsArray($menus, $parent = 0, $level = 2)
    {
        $array = [];
        foreach ($menus as $menu) {
            if ($menu['parent'] == $parent) {
                $array[] = array_merge($menu, ['level' => $level]);
                $array = array_merge($array, $this->buildSubParentsArray($menus, $menu['id'], $level + 1));
            }
        }

        return $array;
    }

    public function clearForm()
    {
        $this->resetValidation();
        $this->text = '';
        $this->path = '';
        $this->parent = '';
        $this->sub_parent = '';
        $this->level = 0;
    
        // Dropdown
        $this->sub_parents = [];
        $this->selectedParent = null;
    }

    public function submit()
    {
        $this->validate();

        parse_str($this->sub_parent, $result);
        
        // If level is 3 then we don't allow it!
        if (isset($result['level']) && (int) $result['level'] === 3) {
            $this->addError('errorMessage', 'Anda tidak diijinkan membuat menu lebih dari level 3!');
        } else {
            $menu = Menu::create([
                'text' => $this->text,
                'path' => $this->path,
                'parent' => isset($result['id']) ? $result['id'] : 0,
            ]);
    
            if ($menu) {
                $this->dispatchBrowserEvent('notyf:ok', [
                    'message' => 'Berhasil disimpan!'
                ]);

                $this->clearForm();
            } else {
                $this->dispatchBrowserEvent('notyf:error', [
                    'message' => 'Gagal disimpan!'
                ]);
            }
        }
    }
}
