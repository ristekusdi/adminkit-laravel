<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use RistekUSDI\RBAC\Connector\Connector;

class RBACUsersController extends Controller
{
    public function index(Request $request)
    {
        $users = (new Connector())->getUsers(array(
            'search' => $request->search
        ));

        return response()->json(['users' => $users]);
    }
}
