<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RistekUSDI\SSO\Laravel\Facades\IMISSUWeb;

class LoginAsController extends Controller
{
    public function index()
    {
        return view('loginas');
    }

    public function submit(Request $request)
    {
        $credentials = session('_sso_token');
        $username = $request->username;

        $impersonate_user_token = IMISSUWeb::impersonateRequest($username, $credentials);

        if (!empty($impersonate_user_token)) {
            Auth::guard('imissu-web')->validate($impersonate_user_token);
            return redirect('/');
        } else {
            return back()->with('error', "Maaf, Anda tidak diijinkan melakukan login as.");
        }
    }
}
