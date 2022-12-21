<?php

namespace App\Http\Livewire\Menu;

use App\Models\Menu;
use Livewire\Component;

class Edit extends Component
{
    public $menu_id;
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

    public function mount($id)
    {
        $menu = Menu::where('id', '=', $id)->first();
        if (!$menu) {
            abort(404);
        }

        $this->menu_id = $id;
        $menu_arr = $menu->toArray();
        $this->text = $menu_arr['text'];
        $this->path = $menu_arr['path'];
        $menus = Menu::get()->toArray();
        $this->parent = $this->getRootParent($menus, $menu_arr['parent']);
        $parent = Menu::where('id', '=', $this->parent)->first()->toArray();
        $this->selectedParent = $parent['id'];
        $sub_parents = !empty($this->parent) ? array_merge([array_merge($parent, ['level' => '1'])], $this->buildParentsArray($menus, $this->parent)) : '0';
        $filtered_sub_parents = $this->filteredSubParents($sub_parents, $this->menu_id);
        $this->sub_parents = $filtered_sub_parents;
        $this->sub_parent = $this->getSubParent($this->sub_parents, $menu['parent']);
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
    public function buildParentsArray($menus, $parent = 0, $level = 2)
    {
        $array = [];
        foreach ($menus as $menu) {
            if ($menu['parent'] == $parent) {
                $array[] = array_merge($menu, ['level' => $level]);
                $array = array_merge($array, $this->buildParentsArray($menus, $menu['id'], $level + 1));
            }
        }

        return $array;
    }

    public function filteredSubParents($sub_parents, $menu_id)
    {
        $array = [];
        foreach ($sub_parents as $sub_parent) {
            if ((int) $sub_parent['id'] !== (int) $menu_id) {
                $array[] = $sub_parent;
            }
        }

        return $array;
    }

    public function getSubParent($sub_parents, $parent_id)
    {
        $value = "";
        foreach ($sub_parents as $sub_parent) {
            if ($sub_parent['id'] === $parent_id) {
                $value = "id={$sub_parent['id']}&level={$sub_parent['level']}";
            }
        }
        return $value;
    }

    public function clearForm()
    {
        # code...
    }

    public function render()
    {
        return view('livewire.menu.edit', [
            'parents' => Menu::where('parent', '=', '0')->get(),
        ]);
    }

    public function submit()
    {
        $this->validate();

        parse_str($this->sub_parent, $result);
        
        // If level is 3 then we don't allow it!
        if (isset($result['level']) && (int) $result['level'] === 3) {
            $this->addError('errorMessage', 'Anda tidak diijinkan membuat menu lebih dari level 3!');
        } else {
            $menu = Menu::where('id', '=', $this->menu_id)->first(); 
            $menu->text = $this->text; 
            $menu->path = $this->path; 
            $menu->parent = isset($result['id']) ? $result['id'] : $this->parent; 
            $menu->save();
    
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
