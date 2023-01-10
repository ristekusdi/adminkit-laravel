<?php

namespace App\Http\Controllers;

use App\Facades\WebSession;
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
            try {
                Auth::guard('imissu-web')->validate($impersonate_user_token);
                // forget session from impersonator e.g role active and role active permissions
                WebSession::forgetSession();
                return redirect('/');
            } catch (\Exception $e) {
                return back()->with('error', $e->getMessage());
            }
        } else {
            return back()->with('error', "Maaf, Anda tidak diijinkan melakukan login as.");
        }
    }
}
