<?php

namespace App\Http\Controllers;

use App\Http\Requests\MembersRequest;
use App\Http\Controllers\Controller;
use App\Members;
use App\Audits;
use Flash;
use Session;
use Auth;
use Redirect;
use Illuminate\Http\Request;

class MembersController extends Controller {

    /**
     * Validate session
     */
    public function __construct() {
        $this->middleware('admin');
        $this->middleware('role:18');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        try {
            return view('admin.members');
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
            $member = Members::where('status', '1')->orderBy('position', 'asc')->get();
            $json = array();
            foreach ($member as $rs):
                $json[] = array(
                    'id' => $rs->id,
                    "parse_name" => $this->parseText($rs->name),
                    "name" => $rs->name,
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
    public function store(MembersRequest $request) {
        try {
            if ($request->ajax()) {

                $count_member = Members::where('name', $request['name'])->where('status', '1')->count();

                if ($count_member == 0) {

                    $members = Members::orderBy('position', 'asc')->offset(0)->limit(100)->get();

                    foreach ($members as $rs):

                        $position = $rs->position + 1;
                        $member = Members::find($rs->id);
                        $member->fill([
                            'position' => $position,
                        ]);
                        $member->save();

                    endforeach;

                    $member = Members::create([
                                'position' => '0',
                                'name' => $request['name'],
                                'url' => $request['name'],
                                'status' => '1'
                    ]);



                    $this->audit('Registro de miembro  ID #' . $member->id);
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
                $member = Members::find($id);
                $member->fill([
                    'name' => $request['name'],
                    'url' => $request['name']
                ]);
                $member->save();
                $this->audit('Actualización miembro   ID #' . $id);
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
            $member = Members::find($id);
            $member->fill([
                'status' => '0'
            ]);
            $member->save();
            $this->audit('Eliminar miembro  ID #' . $id);
            return response()->json(["msg" => "updated"]);
        } catch (Exception $ex) {
            return false;
        }
        return false;
    }

    /**
     * Move items Memberss
     * @param Request $request
     * @return boolean
     */
    public function move_members(Request $request) {
        try {
            foreach ($request['item'] as $key => $value) {
                $member = Members::find($value);
                $member->fill([
                    'position' => $key
                ]);
                $member->save();
            }
            $this->audit('Ordenar miembros');
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
