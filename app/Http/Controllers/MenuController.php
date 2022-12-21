<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MenuController extends Controller
{
    public function index()
    {
        return view('menus');
    }

    public function refresh(Request $request)
    {
        $order_cases = [];
        $parent_cases = [];
        $ids = [];
        foreach ($request->items as $item) {
            $order_cases[] = "WHEN {$item['id']} THEN {$item['order']}";
            if (isset($item['parent'])) {
                $parent_cases[] = "WHEN {$item['id']} THEN {$item['parent']}";   
            } else {
                $parent_cases[] = "WHEN {$item['id']} THEN 0";
            }

            $ids[] = $item['id'];
        }

        $ids = implode(',', $ids);
        $order_cases = implode(' ', $order_cases);
        $parent_cases = implode(' ', $parent_cases);
        
        if (!empty($ids)) {
            $parent_query = (!empty($parent_cases)) ? " ,`parent` = CASE `id` {$parent_cases} END " : "";
            DB::update("UPDATE menus SET `order` = CASE `id` {$order_cases} END {$parent_query} WHERE `id` IN ({$ids})");
            return response()->json([
                'message' => 'Success sort menu'
            ], 204);
        } else {
            return response()->json([
                'message' => 'Failed sort menu'
            ], 422);
        }
    }

    public function delete(Request $request)
    {
        $menu = Menu::where('id', '=', $request->id)->delete();
        return response()->json([
            'message' => 'Success sort menu'
        ], 200);
    }
}
