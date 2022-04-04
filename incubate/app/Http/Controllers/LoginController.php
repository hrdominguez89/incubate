<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Mail\BAMail;
use App\Users;
use App\Audits;
use Session;
use Redirect;
use Auth;
use DB;
use Mail;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Storage;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LoginController extends Controller {

    public function __construct() {
        $this->middleware('AuthOpen', ['only' => ['callback']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        try {

            /**
             * Validate Session and redirect
             */
            if (Auth::guard('admin')->guest()) {
                /**
                 * Show view Login
                 */
                return view('admin.login');
            } else {
                /**
                 * Redirect 
                 */
                return Redirect::to('dashboard');
            }
        } catch (Exception $ex) {
            return false;
        }
        return false;
    }


    /**
     * Display sigin up
     * @return type
     */
    public function store(Request $request) {

        try {
            if (Auth::guard('admin')->guest()) {

                if (!Session::has('error_oid')) {

                    if (!Session::has('login_oid')) {

                        $url = env('OID_AUTH');
                        $url .= '?client_id=' . env('OID_CLIENT_ID');
                        $url .= '&redirect_uri=' . env('APP_URL') . '/verifylogin';
                        $url .= '&response_type=code&state=1';

                        return Redirect::to($url);
                    } else {

                        Session::forget('error_oid');
                        return view('errors.error_exception');
                    }
                } else {

                    Session::forget('error_oid');
                    return view('errors.error_exception');
                }
            } else {
                return Redirect::to('dashboard');
            }
        } catch (Exception $ex) {
            return false;
        }
        return false;
    }

    /**
     * Display sigin up
     * @return type
     */
    public function login(Request $request) {

        try {
            if (Auth::guard('admin')->guest()) {

                if (!Session::has('error_oid')) {

                    if (!Session::has('login_oid')) {

                        $url = env('OID_AUTH');
                        $url .= '?client_id=' . env('OID_CLIENT_ID');
                        $url .= '&redirect_uri=' . env('APP_URL') . '/verifylogin';
                        $url .= '&response_type=code&state=1';

                        return Redirect::to($url);
                    } else {

                        Session::forget('error_oid');
                        return view('errors.error_exception');
                    }
                } else {

                    Session::forget('error_oid');
                    return view('errors.error_exception');
                }
            } else {
                return Redirect::to('dashboard');
            }
        } catch (Exception $ex) {
            return false;
        }
        return false;
    }

    /**
     * callback open id
     * @param Request $request
     * @param TokenStorage $storage
     * @return boolean
     * @throws TokenStorageException
     */
    public function callback(Request $request) {


        if (!Auth::guard('admin')->guest()) {
            Auth::guard('admin')->logout();
        }

        $code = $request->get('code');
        $http = new Client();

        try {

/*
Agregado pipi

*/

                // $cuit = '27302760735';
                // //cuit original 20261444772
                // //hash original $2a$12$vtmsPNft9a1QCwGWv/BpVeI2msj.qWJCTvK9HzaJBr3AHSFmALwIW

                // $password = 'Prueba123';

                // $user = Users::where('cuit', $cuit)->first();

                // if (isset($user) == 0) {
                //     $request->session()->put('error_oid', '1');
                //     return view('errors.error_status');
                // }
                // if (Auth::guard('admin')->attempt(['cuit' => $cuit, 'password' => $password])) {
                //     return Redirect::to('dashboard');
                // }



/*

fin agregado pipi
*/

            $response = $http->post(env('OID_TOKEN'), [
                'form_params' => [
                    'grant_type' => 'authorization_code',
                    'client_id' => env('OID_CLIENT_ID'),
                    'client_secret' => env('OID_CLIENT_SECRET'),
                    'redirect_uri' => env('APP_URL') . '/verifylogin',
                    'code' => $code,
                ],
            ]);


            $response = json_decode($response->getBody());

            if (isset($response->user_id)) {

                $cuit = $response->user_id;
                $password = $response->user_id;

                $user = Users::where('cuit', $cuit)->first();

                if (isset($user) == 0) {
                    $request->session()->put('error_oid', '1');
                    return view('errors.error_status');
                }
                if (Auth::guard('admin')->attempt(['cuit' => $cuit, 'password' => $password])) {
                    return Redirect::to('dashboard');
                }
            } else {

                $request->session()->put('error_oid', '1');
                return view('errors.error_auth');
            }

            echo print_r($response);
        } catch (Exception $ex) {
            return false;
        }
        return false;
    }

    /**
     * logout 
     * @return type
     */
    public function logout() {
        try {
            if (!Auth::guard('admin')->guest()) {
                Auth::guard('admin')->logout();
            }
            return Redirect::to('cms');
        } catch (Exception $ex) {
            return false;
        }
        return false;
    }

    /**
     * Audit user
     * @return type
     */
    public function audit($activity) {
        try {
            Audits::create([
                'activity' => $activity,
                'ip' => $this->getIp(),
                'id_user' => Auth::guard('admin')->User()->id
            ]);
        } catch (Exception $ex) {
            return false;
        }
        return false;
    }

    /**
     * Get Ip User
     * @return type
     */
    public function getIp() {
        try {
            if (!empty($_SERVER['HTTP_CLIENT_IP'])) {   //check ip from share internet
                $ip = $_SERVER['HTTP_CLIENT_IP'];
            } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {   //to check ip is pass from proxy
                $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
            } else {
                $ip = $_SERVER['REMOTE_ADDR'];
            }
            return $ip;
        } catch (Exception $ex) {
            return false;
        }
        return false;
    }

    /**
     * Decode inputs forms.
     *
     * @param  $text
     * @return $strReturn
     */
    public function descript_code($text) {
        try {
            $key = "0123456789abcdef";
            $iv = "abcdef9876543210";
            $method = 'AES-128-CBC';
            $strData = base64_decode($text);
            $strReturn = openssl_decrypt($strData, $method, $key, OPENSSL_RAW_DATA, $iv);
            return $strReturn;
        } catch (Exception $ex) {
            return false;
        }
        return false;
    }

    public function getPassword($length = 10, $uc = TRUE, $n = TRUE, $sc = FALSE) {
        try {
            $source = 'abcdefghijklmnopqrstuvwxyz';
            if ($uc == 1)
                $source .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
            if ($n == 1)
                $source .= '1234567890';
            if ($sc == 1)
                $source .= '-@#~$%()=^*+[]{}-_';
            if ($length > 0) {
                $rstr = "";
                $source = str_split($source, 1);
                for ($i = 1; $i <= $length; $i++) {
                    mt_srand((double) microtime() * 1000000);
                    $num = mt_rand(1, count($source));
                    $rstr .= $source[$num - 1];
                }
            }
            return $rstr;
        } catch (Exception $ex) {
            return false;
        }
        return false;
    }

}
