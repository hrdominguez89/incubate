<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Mailchimp;
use Mailchimp_Lists;
use App\Http\Requests;

class ApiMailchimpController extends Controller {

    /**
     * Validate access
     */
    public function __construct() {
        $this->middleware('AuthApi');
    }

    public function store(Request $request) {
        if ($request->ajax()) {
            $request->validate([
                'email' => 'required|email'
            ]);
            $isHuman = $this->validate_captcha_google($request['captcha']);
            if ($request['captcha'] == '' && env('ACTIVATE_CAPTCHA') == "1") {
                return response()->json(["response" => "no-catpcha"]);
            }
            if ($isHuman) {
                return response()->json(["msg" => "Contacto Enviado"]);
            }
        }
    }

    public function validate_captcha_google($token) {
        try {
            if (env('ACTIVATE_CAPTCHA') != "1") {
                return true;
            }
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "https://www.google.com/recaptcha/api/siteverify");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(array('secret' => env('CAPTCHA_KEY_SECRET'), 'response' => $token)));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($ch);
            curl_close($ch);
            $arrResponse = json_decode($response, true);
            if ($arrResponse["success"] == '1' && $arrResponse["action"] == 'homepage' && $arrResponse["score"] >= 0.5) {
                return true;
            } else {
                return false;
            }
        } catch (Exception $ex) {
            return false;
        }
        return false;
    }

}
