<?php

namespace App\Http\Controllers;

use App\Documents;
use App\Http\Requests\DocumentUpdateRequest;
use Illuminate\Http\Request;
use App\Audits;
use Flash;
use Session;
use Redirect;
use Auth;
use App\Http\Requests;

class DocumentsController extends Controller {

    /**
     * Validate session
     */
    public function __construct() {
        $this->middleware('admin');
        $this->middleware('role:11');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        try {
            return view('admin.document_list');
        } catch (Exception $ex) {
            return false;
        }
        return false;
    }

    /**
     * Display list resources
     * @return type
     */
    public function lists() {
        try {
            $document = Documents::orderby('id', 'desc')->get();
            $json = array();
            foreach ($document as $rs):

                $json[] = array(
                    'id' => $rs->id,
                    "title_2" => $rs->title,
                    "parse_text" => $this->parseText($rs->title),
                    "title" => substr($rs->title, 0, 37) . '...',
                    "created_at" => date("Y-m-d H:i:s", strtotime($rs->created_at)),
                );
            endforeach;
            return response()->json($json);
        } catch (Exception $ex) {
            return false;
        }
        return false;
    }

    /**
     * Display list photo page
     * @return type
     */
    public function lists_archive(Request $request) {
        $document = Documents::find($request['id']);
        $total = substr_count($document->archive, ',');
        $json = array();
        if ($document->archive != "") {
            for ($i = 1; $i <= substr_count($document->archive, ','); $i++) {
                $archivo = explode(',', $document->archive);
                $json[] = array('nombre' => $archivo[$i]);
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
        return view('admin.document');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DocumentUpdateRequest $request) {
        try {


            if ($request['type'] == "1") {
                $archive = $request['image'];
                $video = '';
            } else {
                $archive = '';
                $video = $request['video'];
            }


            $document = Documents::create([
                        'title' => $request['title'],
                        'title_en' => $request['title_en'],
                        "type" => $request['type'],
                        'archive' => $archive,
                        'video' => $video
            ]);



            $this->audit('Registro de documento ID #' . $document->id);

            Session()->flash('notice', 'Registro Exitoso');
            return redirect::to('/documents');
        } catch (Exception $ex) {
            return false;
        }
        return false;
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
        try {
            $document = Documents::find($id);
            if (isset($document) == 0)
                return redirect::to('/documents');
            return view('admin.document_edit', ['document' => $document]);
        } catch (Exception $ex) {
            return false;
        }
        return false;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(DocumentUpdateRequest $request, $id) {
        try {

            if ($request['type'] == "1") {
                $archive = $request['archive'];
                $video = '';
            } else {
                $archive = '';
                $video = $request['video'];
            }

            $document = Documents::find($id);
            $document->fill([
                'title' => $request['title'],
                'title_en' => $request['title_en'],
                "type" => $request['type'],
                'archive' => $archive,
                'video' => $video
            ]);
            $document->save();
            $this->audit('Actualización de documento ID #' . $id);
            Session()->flash('warning', 'Registro Actualizado');
            return Redirect::to('/documents');
        } catch (Exception $ex) {
            return false;
        }
        return false;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        try {
            Documents::destroy($id);
            $this->audit('Eliminar document ID #' . $id);
            return response()->json(["msg" => "borrado"]);
        } catch (Exception $ex) {
            return false;
        }
        return false;
    }

    /**
     * Delete photo page
     * @param Request $request
     * @return type
     */
    public function delete_archive(Request $request) {
        $document = Documents::find($request['id']);
        $document->fill([
            'archive' => $request['archive'],
        ]);
        $document->save();
        $this->audit('Eliminar archivo de documento ID #' . $request['id']);
        return response()->json(["msg" => "borrado"]);
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
