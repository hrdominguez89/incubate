<?php

namespace App\Http\Middleware;

use Redirect;
use Closure;
use Auth;

class AuthMiBA {

    public function handle($request, Closure $next) {



        if (isset($_GET['error'])) {
            if ($request->session()->has('error_oic')) {
                $request->session()->forget('error_oic');
            }
            if ($request->session()->has('miba')) {
                $request->session()->forget('miba');
            }

            return Redirect::to('iniciar-sesion');
        }

        if (isset($_GET['code'])) {

            if ($request->session()->has('error_oic')) {
                $request->session()->forget('error_oic');
            }
            if ($request->session()->has('miba')) {
                $request->session()->forget('miba');
            }

            if ($request->session()->has('code_oic')) {

                if ($_GET['code'] == $request->session()->get('code_oic')) {

                    $request->session()->put('error_oic','1');
                    return Redirect::to('iniciar-sesion');
                }
            }

            $request->session()->put('code_oic', $_GET['code']);
        }


        $request->session()->put('miba','1');

        return $next($request);
    }

}
