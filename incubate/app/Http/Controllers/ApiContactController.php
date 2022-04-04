<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Comment;
use DB;
use Mail;
use App\Mail\BAMail;
use App\Http\Requests;

class ApiContactController extends Controller {

    /**
     * Validate access
     */
    public function __construct() {
        $this->middleware('AuthApi');
    }

    public function store(Request $request) {
        try {
            $request->validate([
                'name' => 'required',
                'email' => 'required|email',
                'message' => 'required',
            ]);
            $isHuman = $this->validate_captcha_google($request['captcha']);
            if ($request['captcha'] == '' && env('ACTIVATE_CAPTCHA') == "1") {
                return response()->json(["response" => "no-catpcha"]);
            }
            if ($isHuman) {
                if ($request->ajax()) {
                    $name = $request['name'];
                    $email = $request['email'];
                    $message = $request['message'];
                    Comment::create([
                        'name' => $name,
                        'last_name' => '',
                        'email' => $email,
                        'message' => $message,
                    ]);
                    $content = 'Hola, Administrador Incubate.<br/>
                <br/>
                Le informamos a través de este correo electrónico que tiene una nueva consulta por revisar. Los datos que hemos recibido son los siguientes:<br />
                <br />
                <strong>Nombre y Apellido:</strong>  ' . $name . '<br/>
                <strong>Correo electrónico:</strong>  ' . $email . '<br/>
                <strong>Mensaje:</strong>  ' . $message . '<br/>';
                    $title = "Nueva Consulta";
                    $site = DB::table('site')->where('id', '1')->first();
                    Mail::to($site->email, $site->name)->send(new BAMail($title, $content));
                    return response()->json(["msg" => "Contacto Enviado"]);
                }
            }
        } catch (Exception $ex) {
            return false;
        }
        return false;
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
