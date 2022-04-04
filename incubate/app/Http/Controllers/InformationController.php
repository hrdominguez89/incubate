<?php

namespace App\Http\Controllers;

use App\Information;
use App\Http\Requests\InformationCreateRequest;
use App\Http\Requests\InformationUpdateRequest;
use Illuminate\Http\Request;
use App\Audits;
use Flash;
use Session;
use Redirect;
use Auth;
use App\Http\Requests;

class InformationController extends Controller {

    /**
     * Validate session
     */
    public function __construct() {
        $this->middleware('admin');
        $this->middleware('role:14');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        return view('admin.information_list');
    }

    /**
     * Display list resources
     * @return type
     */
    public function lists() {
        $information = Information::orderBy('position', 'asc')->get();
        $json = array();
        foreach ($information as $rs):

            $json[] = array(
                'id' => $rs->id,
                "title_2" => $rs->title,
                "parse_text" => $this->parseText($rs->title),
                "title" => substr($rs->title, 0, 37) . '...',
                "category" => $rs->boton_name,
                "created_at" => date("Y-m-d H:i:s", strtotime($rs->created_at)),
            );
        endforeach;
        return response()->json($json);
    }

    /**
     * Display list photo page
     * @return type
     */
    public function lists_photo(Request $request) {
        $information = Information::find($request['id']);
        $total = substr_count($information->image, ',');
        $json = array();
        if ($information->image != "") {
            for ($i = 1; $i <= substr_count($information->image, ','); $i++) {
                $imagen = explode(',', $information->image);
                $json[] = array('nombre' => $imagen[$i]);
            }
        }
        return response()->json($json);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        return view('admin.information');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(InformationCreateRequest $request) {

        $informations = Information::orderBy('position', 'asc')->offset(0)->limit(100)->get();

        foreach ($informations as $rs):

            $position = $rs->position + 1;
            $information = Information::find($rs->id);
            $information->fill([
                'position' => $position,
            ]);
            $information->save();

        endforeach;

        if ($request['type'] == "1") {
            $image = $request['image'];
            $video = '';
        } else {
            $image = '';
            $video = $request['video'];
        }


        $information = Information::create([
                    'position' => '0',
                    'title' => $request['title'],
                    'subtitle' => $request['subtitle'],
                    'boton_name' => $request['boton_name'],
                    'boton_name_en' => $request['boton_name_en'],
                    'url' => $request['title'],
                    'content' => $request['content'],
                    'title_en' => $request['title_en'],
                    'subtitle_en' => $request['subtitle_en'],
                    'url_en' => $request['title_en'],
                    'content_en' => $request['content_en'],
                    'image' => $image,
                    'type' => $request['type'],
                    'video' => $video
        ]);


        $this->audit('Registro de información ID #' . $information->id);
        Session()->flash('notice', 'Registro Exitoso');
        return redirect::to('/information');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $information = Information::find($id);
        if (isset($information) == 0)
            return redirect::to('/information');


        return view('admin.information_edit', ['information' => $information]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(InformationUpdateRequest $request, $id) {

        if ($request['type'] == "1") {
            $image = $request['image'];
            $video = '';
        } else {
            $image = '';
            $video = $request['video'];
        }


        $information = Information::find($id);
        $information->fill([
            'title' => $request['title'],
            'subtitle' => $request['subtitle'],
            'boton_name' => $request['boton_name'],
            'boton_name_en' => $request['boton_name_en'],
            'url' => $request['title'],
            'content' => $request['content'],
            'title_en' => $request['title_en'],
            'subtitle_en' => $request['subtitle_en'],
            'url_en' => $request['title_en'],
            'content_en' => $request['content_en'],
            'image' => $image,
            'type' => $request['type'],
            'video' => $video
        ]);
        $information->save();
        $this->audit('Actualización información ID #' . $id);
        Session()->flash('warning', 'Registro Actualizado');
        return Redirect::to('/information');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        Information::destroy($id);
        $this->audit('Eliminar información ID #' . $id);
        return response()->json(["msg" => "borrado"]);
    }

    /**
     * Delete photo page
     * @param Request $request
     * @return type
     */
    public function delete_photo(Request $request) {
        $information = Information::find($request['id']);
        $information->fill([
            'image' => $request['image'],
        ]);
        $information->save();
        $this->audit('Eliminar imagen de información ID #' . $request['id']);
        return response()->json(["msg" => "borrado"]);
    }

    /**
     * Move items information
     * @param Request $request
     * @return boolean
     */
    public function move_information(Request $request) {
        try {
            foreach ($request['item'] as $key => $value) {
                $information = Information::find($value);
                $information->fill([
                    'position' => $key
                ]);
                $information->save();
            }
            $this->audit('Ordenar informaciones');
            return response()->json(["msg" => "movido"]);
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
        Audits::create([
            'activity' => $activity,
            'ip' => $this->getIp(),
            'id_user' => Auth::guard('admin')->User()->id
        ]);
    }

    /**
     * Get Ip User
     * @return type
     */
    public function getIp() {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {   //check ip from share internet
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {   //to check ip is pass from proxy
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }

    /**
     * Parse text
     * @return type
     */
    public function parseText($value) {
        $find = array('á', 'é', 'í', 'ó', 'ú', 'ñ');
        $repl = array('a', 'e', 'i', 'o', 'u', 'n');
        $value = str_replace($find, $repl, $value);
        return $value;
    }

}
