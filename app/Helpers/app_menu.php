<?php

use App\Models\Menu;

if (! function_exists('load_app_menu')) {
    function load_app_menu()
    {
        $arr_menus = Menu::withPermission()->orderBy('order')->get()->toArray();

        $menus = build_tree($arr_menus);
        update_level_items($menus);
        
        return build_app_menu($menus);
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

if (! function_exists('build_app_menu')) {
    function build_app_menu($items, $is_nested = false, $id = '')
    {
        $menu = '<ul '.set_sidebar_id($id).' '.set_sidebar_class($items, $is_nested).'>';

        foreach ($items as $item) {
            if (isset($item['header'])) {
                $menu .= '<li class="sidebar-header">'.$item['header'].'</li>';
            } else {
                if (is_part_of_root_menu($item['id'], $items)) {
                    $menu .= '<li '.set_sidebar_item_class($item, $is_nested).'>
                        <a '.set_sidebar_link_class($item).' '.set_data_bs_attr($item).' '.set_href($item['path']).' '.set_aria_expanded($item).'>
                            '.set_sidebar_link_text($item).'
                        </a>
                        '.(isset($item['children']) ? build_app_menu($item['children'], $is_nested = true, $id = $item['text']) : '').'
                    </li>';
                }
            }
        }
        $menu .= '</ul>';
        return $menu;
    }
}

if (! function_exists('is_part_of_root_menu')) {
    function is_part_of_root_menu($menu_id, $menus)
    {
        $result = explode(',', substr(arr_child_of_root_menu($menu_id, $menus), 1));
        if (in_array('y', $result)) {
            return true;
        } else {
            return false;
        }
    }
}

if (! function_exists('arr_child_of_root_menu')) {
    function arr_child_of_root_menu($menu_id = 0, $menus = [], $level = 1)
    {
        $flag = '';
        foreach ($menus as $menu) {
            if ($menu['id'] == $menu_id) {
                if (isset($menu['children'])) {
                    $perm_names = array_column_recursive($menu['children'], 'perm_name');
                    if (auth('imissu-web')->user()->hasPermission($perm_names)) {
                        $flag .= ',y';
                    } else {
                        $flag .= ',n';
                    }
                } else {
                    if (auth('imissu-web')->user()->hasPermission($menu['perm_name'])) {
                        $flag .= ',y';
                    } else {
                        $flag .= ',n';
                    }
                }
            } else if ($menu['parent'] == $menu_id) {
                if (isset($menu['children'])) {
                    $perm_names = array_column_recursive($menu['children'], 'perm_name');
                    if (auth('imissu-web')->user()->hasPermission($perm_names)) {
                        $flag .= ',y';
                    } else {
                        $flag .= ',n';
                    }
                } else {
                    if (auth('imissu-web')->user()->hasPermission($menu['perm_name'])) {
                        $flag .= ',y';
                    } else {
                        $flag .= ',n';
                    }
                }
            }
        }
        return $flag;
    }
}

if (! function_exists('set_sidebar_id')) {
    function set_sidebar_id($id)
    {
        return ($id != '') ? 'id="'.preg_replace('/\s+/', '-', strtolower(str_replace('.', '', $id))).'"' : '';
    }
}

if (! function_exists('set_sidebar_class')) {
    function set_sidebar_class($items, $is_nested)
    {
        if (!$is_nested) {
            return 'class="sidebar-nav"';
        }
        
        $is_active_link = is_active_link_from_children($items);
        if ($is_active_link) {
            return 'class="sidebar-dropdown list-unstyled collapse show"';
        } else {
            return 'class="sidebar-dropdown list-unstyled collapse"';
        }
    }
}

if (! function_exists('set_sidebar_item_class')) {
    function set_sidebar_item_class($item, $is_nested)
    {
        if (isset($item['children']) && (int) $item['level'] === 1) {
            $is_active_link = is_active_link_from_children($item['children']);
            if ($is_active_link) {
                return 'class="sidebar-item active"';
            } else {
                return 'class="sidebar-item"';
            }
        } else {
            if (strpos(request()->path(), $item['path']) !== false) {
                return 'class="sidebar-item active"';
            } else {
                return 'class="sidebar-item"';
            }
        }
    }
}

if (! function_exists('is_active_link_from_children')) {
    function is_active_link_from_children($items)
    {
        $result = false;
        $links = array();
        array_walk_recursive($items, function ($value, $key) use (&$links) {
            if ($key == 'path') {
                $links[] = $value;
            }
        });

        foreach ($links as $link) {
            if (strpos(request()->path(), $link) !== false) {
                $result = true;
            }
        }

        return $result;
    }
}

if (! function_exists('set_sidebar_link_class')) {
    function set_sidebar_link_class($item)
    {
        if (isset($item['children'])) {
            $is_active_link = is_active_link_from_children($item['children']);
            if ($is_active_link) {
                return 'class="sidebar-link"';
            } else {
                return 'class="sidebar-link collapsed"';
            }
        } else {
            return 'class="sidebar-link"';
        }
    }
}

if (! function_exists('set_href')) {
    function set_href($link)
    {
        return 'href="'.url($link).'"';
    }
}

if (! function_exists('set_data_bs_attr')) {
    function set_data_bs_attr($item)
    {
        return isset($item['children']) ? 'data-bs-target="#'.preg_replace('/\s+/', '-', strtolower(str_replace('.', '', $item['text']))).'" data-bs-toggle="collapse"' : '';
    }
}

if (! function_exists('set_aria_expanded')) {
    function set_aria_expanded($item)
    {
        $aria = '';
        if (isset($item['children'])) {
            $is_active_link = is_active_link_from_children($item['children']);
            if ($is_active_link) {
                $aria = 'aria-expanded="true"';
            }
        }

        return $aria;
    }
}

if (! function_exists('set_sidebar_link_text')) {
    function set_sidebar_link_text($item)
    {
        return isset($item['icon']) 
            ? '<i class="align-middle" data-feather="'.$item['icon'].'"></i> <span class="align-middle">'.$item['text'].'</span>'
            : $item['text'];
    }
}