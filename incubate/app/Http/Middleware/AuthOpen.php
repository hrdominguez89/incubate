<?php

namespace App\Http\Middleware;

use Redirect;
use Closure;
use Auth;

class AuthOpen {

    public function handle($request, Closure $next) {



        if (isset($_GET['error'])) {
            if ($request->session()->has('error_oid')) {
                $request->session()->forget('error_oid');
            }
            if ($request->session()->has('login_oid')) {
                $request->session()->forget('login_oid');
            }
            if (!Auth::guard('admin')->guest()) {
                Auth::guard('admin')->logout();
            }

            return Redirect::to('cms');
        }

        if (isset($_GET['code'])) {

            if ($request->session()->has('error_oid')) {
                $request->session()->forget('error_oid');
            }
            if ($request->session()->has('login_oid')) {
                $request->session()->forget('login_oid');
            }
            if (!Auth::guard('admin')->guest()) {
                Auth::guard('admin')->logout();
            }

            if ($request->session()->has('code_oid')) {

                if ($_GET['code'] == $request->session()->get('code_oid')) {

                    $request->session()->put('error_oid','1');
                    return Redirect::to('cms');
                }
            }

            $request->session()->put('code_oid', $_GET['code']);
        }


        $request->session()->put('login_oid','1');

        return $next($request);
    }

}
