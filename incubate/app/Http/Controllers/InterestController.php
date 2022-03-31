<?php

namespace App\Http\Controllers;

use App\Http\Requests\InterestRequest;
use App\Http\Controllers\Controller;
use App\Interest;
use App\Audits;
use Flash;
use Session;
use Auth;
use Redirect;
use Illuminate\Http\Request;

class InterestController extends Controller {

    /**
     * Validate session
     */
    public function __construct() {
        $this->middleware('admin');
        $this->middleware('role:21');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        try {
            return view('admin.interest');
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
            $interest = Interest::where('status', '1')->orderBy('position', 'asc')->get();
            $json = array();
            foreach ($interest as $rs):
                $json[] = array(
                    'id' => $rs->id,
                    "name" => $rs->name,
                    "parse_text" => $this->parseText($rs->name),
                    "name_en" => $rs->name_en,
                    "name_res" => substr($rs->name, 0, 40),
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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
//
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(InterestRequest $request) {
        try {
            if ($request->ajax()) {

                $count_interest = Interest::where('name', $request['name'])->where('status', '1')->count();

                if ($count_interest == 0) {

                    $interests = Interest::orderBy('position', 'asc')->offset(0)->limit(100)->get();

                    foreach ($interests as $rs):

                        $position = $rs->position + 1;
                        $interest = Interest::find($rs->id);
                        $interest->fill([
                            'position' => $position,
                        ]);
                        $interest->save();

                    endforeach;

                    $interest = Interest::create([
                                'position' => '0',
                                'name' => $request['name'],
                                'url' => $request['name'],
                                'name_en' => $request['name_en'],
                                'url_en' => $request['name_en'],
                                'status' => '1'
                    ]);



                    $this->audit('Registro de interes  ID #' . $interest->id);
                }

                return response()->json(["msg" => "created"]);
            }
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
//
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        try {
            if ($request->ajax()) {
                $interest = Interest::find($id);
                $interest->fill([
                    'name' => $request['name'],
                    'url' => $request['name'],
                    'name_en' => $request['name_en'],
                    'url_en' => $request['name_en'],
                ]);
                $interest->save();
                $this->audit('Actualización interes  ID #' . $id);
                return response()->json(["msg" => "updated"]);
            }
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
            $interest = Interest::find($id);
            $interest->fill([
                'status' => '0'
            ]);
            $interest->save();
            $this->audit('Eliminar interes ID #' . $id);
            return response()->json(["msg" => "updated"]);
        } catch (Exception $ex) {
            return false;
        }
        return false;
    }

    /**
     * Move items Interest
     * @param Request $request
     * @return boolean
     */
    public function move_interests(Request $request) {
        try {
            foreach ($request['item'] as $key => $value) {
                $interest = Interest::find($value);
                $interest->fill([
                    'position' => $key
                ]);
                $interest->save();
            }
            $this->audit('Ordenar intereses');
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
