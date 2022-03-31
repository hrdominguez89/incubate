<?php

namespace App\Http\Controllers;

use App\Http\Requests\DedicatedRequest;
use App\Http\Controllers\Controller;
use App\Dedicated;
use App\Audits;
use Flash;
use Session;
use Auth;
use Redirect;
use Illuminate\Http\Request;

class DedicatedController extends Controller {

    /**
     * Validate session
     */
    public function __construct() {
        $this->middleware('admin');
        $this->middleware('role:19');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        try {
            return view('admin.dedicated');
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
            $dedicated = Dedicated::where('status', '1')->orderBy('position', 'asc')->get();
            $json = array();
            foreach ($dedicated as $rs):
                $json[] = array(
                    'id' => $rs->id,
                    "name" => $rs->name,
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
    public function store(DedicatedRequest $request) {
        try {
            if ($request->ajax()) {

                $count_dedicated = Dedicated::where('name', $request['name'])->where('status', '1')->count();

                if ($count_dedicated == 0) {

                    $dedicateds = Dedicated::orderBy('position', 'asc')->offset(0)->limit(100)->get();

                    foreach ($dedicateds as $rs):

                        $position = $rs->position + 1;
                        $dedicated = Dedicated::find($rs->id);
                        $dedicated->fill([
                            'position' => $position,
                        ]);
                        $dedicated->save();

                    endforeach;

                    $dedicated = Dedicated::create([
                                'position' => '0',
                                'name' => $request['name'],
                                'url' => $request['name'],
                                'name_en' => $request['name_en'],
                                'url_en' => $request['name_en'],
                                'status' => '1'
                    ]);


                    $this->audit('Registro de dedicación  ID #' . $dedicated->id);
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
                $dedicated = Dedicated::find($id);
                $dedicated->fill([
                    'name' => $request['name'],
                    'url' => $request['name'],
                    'name_en' => $request['name_en'],
                    'url_en' => $request['name_en'],
                ]);
                $dedicated->save();
                $this->audit('Actualización dedicación   ID #' . $id);
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
            $dedicated = Dedicated::find($id);
            $dedicated->fill([
                'status' => '0'
            ]);
            $dedicated->save();
            $this->audit('Eliminar dedicación  ID #' . $id);
            return response()->json(["msg" => "updated"]);
        } catch (Exception $ex) {
            return false;
        }
        return false;
    }

    /**
     * Move items Dedicateds
     * @param Request $request
     * @return boolean
     */
    public function move_dedicated(Request $request) {
        try {
            foreach ($request['item'] as $key => $value) {
                $dedicated = Dedicated::find($value);
                $dedicated->fill([
                    'position' => $key
                ]);
                $dedicated->save();
            }
            $this->audit('Ordenar dedicaciónes');
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

}
