<?php

use App\Models\Menu;

if (! function_exists('load_sortable_menu')) {
    function load_sortable_menu()
    {
        $arr_menus = Menu::orderBy('order')->get()->toArray();

        $menu = build_tree($arr_menus);
        update_level_items($menu);
        
        return build_sortable_menu($menu);
    }
}

if (! function_exists('is_active_path')) {
    function is_active_path($path)
    {
        return request()->is($path) ? true : false;
    }
}

if (! function_exists('build_tree')) {
    function build_tree($elements, $parent = 0)
    {
        $branch = array();
        foreach ($elements as $element) {
            if ($element['parent'] == $parent) {
                $children = build_tree($elements, $element['id']);
                if ($children) {
                    $element['children'] = $children;
                }
                $branch[] = $element;
            }
        }

        return $branch;
    }
}

if (! function_exists('update_level_items')) {
    function update_level_items(&$items, $level = 1)
    {
        foreach ($items as &$item) {
            if (array_key_exists('children', $item) && is_array($item['children'])) {
                $item['level'] = $level;
                update_level_items($item['children'], $level + 1);
            }
        }
    }
}

if (! function_exists('build_sortable_menu')) {
    function build_sortable_menu($items, $is_nested = false, $id = '')
    {
        $menu = '<ul class="list-group" '.set_sortable_attr($items, $is_nested).'>';

        foreach ($items as $item) {
            $menu .= '<li class="list-group-item" data-id="'.$item['id'].'">
                    '.$item['text'].'
                    '.(isset($item['children']) ? build_sortable_menu($item['children'], $is_nested = true, $id = $item['text']) : '').'
                </li>';
        }
        $menu .= '</ul>';
        return $menu;
    }
}

if (! function_exists('set_sortable_attr')) {
    function set_sortable_attr($items, $is_nested)
    {
        if (!$is_nested) {
            return 'id="draggable"';
        }

        return 'data-id="'.$items[0]['parent'].'"';
    }
}