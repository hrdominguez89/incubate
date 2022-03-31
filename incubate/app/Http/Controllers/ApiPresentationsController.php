<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Presentations;
use DB;
use Mail;
use App\Mail\BAMail;
use App\Http\Requests;

class ApiPresentationsController extends Controller {

    public function store(Request $request) {
        try {
            $request->validate([
                'name' => 'required',
                'last_name' => 'required',
                'email' => 'required',
                "dni" => 'required',
                "phone" => 'required',
                "project_name" => 'required',
                "state" => 'required',
                "dedicated" => 'required',
                "members" => 'required',
                "person" => 'required',
                'description' => 'required',
                'archive' => 'mimes:jpeg,png,jpg,gif,doc,pdf|required|file|max:1024'
            ]);
            $isHuman = $this->validate_captcha_google($request['captcha']);
            if ($request['captcha'] == '' && env('ACTIVATE_CAPTCHA') == "1") {
                return response()->json(["response" => "no-catpcha"]);
            }
            if ($isHuman) {
                $path = $_SERVER['DOCUMENT_ROOT'] . "/images/";
                $archive = '';
                $interest = '';
                $category = '';
                if (!empty($request['interest'])) {
                    foreach ($request['interest'] as $selected) {
                        $interest .= $selected . ',';
                    }
                }
                if (!empty($request['category'])) {
                    foreach ($request['category'] as $selected) {
                        $category .= $selected . ',';
                    }
                }

                if (isset($_FILES["archive"]["name"])) {
                    $filename = $_FILES["archive"]["name"];
                    $source = $_FILES["archive"]["tmp_name"];
                    $upload = $path . $filename;
                    move_uploaded_file($source, $upload);
                    $type = strtolower(strrchr($filename, "."));
                    $pic_new = time() . $type;
                    $upload_new = $path . $pic_new;
                    rename($upload, $upload_new);
                    $archive .= $pic_new . ',';
                }

                Presentations::create([
                    'name' => $request['name'],
                    'last_name' => $request['last_name'],
                    'email' => $request['email'],
                    "dni" => $request['dni'],
                    "phone" => $request['phone'],
                    "project_name" => $request['project_name'],
                    "website" => $request['website'],
                    "category" => $category,
                    "state" => $request['state'],
                    "dedicated" => $request['dedicated'],
                    "members" => $request['members'],
                    "interest" => $interest,
                    "person" => $request['person'],
                    "video" => $request['video'],
                    'description' => $request['description'],
                    "documents" => $archive
                ]);
                $content = 'Hola, Administrador Incubate.<br/>
                <br/>
                Le informamos a través de este correo electrónico que tiene una nueva presentación de proyecto por revisar. Los datos que hemos recibido son los siguientes:<br />
                <br />
                <strong>Nombre y Apellido:</strong>  ' . $request['name'] . '' . $request['last_name'] . '<br/>
                <strong>Correo electrónico:</strong>  ' . $request['email'] . '<br/>
                <strong>Teléfono:</strong>  ' . $request['phone'] . '<br/>
                <strong>Nombre del emprendimiento:</strong>  ' . $request['project_name'] . '<br/>';
                $title = "Nueva Presentación";
                $site = DB::table('site')->where('id', '1')->first();
                Mail::to($site->email, $site->name)->send(new BAMail($title, $content));
                return response()->json(["msg" => "Contacto Enviado"]);
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
