<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Audits;
use Redirect;
use App\Site;
use Auth;
use DB;

class OptionsController extends Controller {

    /**
     * Validate Session
     */
    public function __construct() {
        $this->middleware('admin');
    }

    /**
     * Show options site
     * @return type
     */
    public function index() {
        try {
            return view('admin.options_site');
        } catch (Exception $ex) {
            return false;
        }
        return false;
    }

    /**
     * Show options contact
     * @return type
     */
    public function contact() {
        try {
            return view('admin.option_contact');
        } catch (Exception $ex) {
            return false;
        }
        return false;
    }

    /**
     * Show Seo
     * @return type
     */
    public function seo() {
        try {
            return view('admin.options_seo');
        } catch (Exception $ex) {
            return false;
        }
        return false;
    }

    /**
     * Update options resource
     * @param Request $request
     */
    public function update(Request $request) {
        try {

            if ($request['type'] == 'image') {

                $this->audit('Actualización de imagen del sitio');

                Site::where('id', '1')->update([
                    'image' => $request['image']
                ]);
            }
            if ($request['type'] == 'image-1') {

                $this->audit('Actualización de imagen del sitio');

                Site::where('id', '1')->update([
                    'image_1' => $request['image']
                ]);
            }
            if ($request['type'] == 'image-2') {

                $this->audit('Actualización de imagen del sitio');

                Site::where('id', '1')->update([
                    'image_2' => $request['image']
                ]);
            }
            if ($request['type'] == 'image-3') {

                $this->audit('Actualización de imagen del sitio');

                Site::where('id', '1')->update([
                    'image_3' => $request['image']
                ]);
            }
            if ($request['type'] == 'name') {

                $this->audit('Actualización de nombre del sitio');

                Site::where('id', '1')->update([
                    'name' => $request['name']
                ]);
            }

            if ($request['type'] == 'network') {

                $this->audit('Actualización de redes sociales');

                Site::where('id', '1')->update([
                    'twitter' => $request['twitter'],
                    'youtube' => $request['youtube'],
                    'facebook' => $request['facebook'],
                    'instagram' => $request['instagram']
                ]);
            }

            if ($request['type'] == 'contact') {

                $this->audit('Actualización de información de contacto');

                Site::where('id', '1')->update([
                    'email' => $request['email'],
                    'phone_ciudadano' => $request['phone_ciudadano'],
                    'phone_social' => $request['phone_social'],
                    'phone_same' => $request['phone_same'],
                    'phone_emergencia' => $request['phone_emergencia'],
                ]);
            }

            if ($request['type'] == 'seo') {

                $this->audit('Actualización de datos seo');

                Site::where('id', '1')->update([
                    'description' => $request['description'],
                    'keywords' => $request['keywords'],
                    'description_en' => $request['description_en'],
                    'keywords_en' => $request['keywords_en'],
                ]);
            }
            if ($request['type'] == 'mailchimp') {

                $this->audit('Actualización de datos mailchim');

                Site::where('id', '1')->update([
                    'api_key' => $request['api_key'],
                    'list_mailchimp' => $request['list_mailchimp']
                ]);
            }



            return response()->json(["msg" => "echo"]);
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

}
