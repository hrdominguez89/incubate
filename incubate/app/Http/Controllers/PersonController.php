<?php

namespace App\Http\Controllers;

use App\Http\Requests\PersonRequest;
use App\Http\Controllers\Controller;
use App\Person;
use App\Audits;
use Flash;
use Session;
use Auth;
use Redirect;
use Illuminate\Http\Request;

class PersonController extends Controller {

    /**
     * Validate session
     */
    public function __construct() {
        $this->middleware('admin');
        $this->middleware('role:22');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        try {
            return view('admin.person');
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
            $person = Person::where('status', '1')->orderBy('position', 'asc')->get();
            $json = array();
            foreach ($person as $rs):
                $json[] = array(
                    'id' => $rs->id,
                    "parse_name" => $this->parseText($rs->name),
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
    public function store(PersonRequest $request) {
        try {
            if ($request->ajax()) {

                $count_member = Person::where('name', $request['name'])->where('status', '1')->count();

                if ($count_member == 0) {

                    $persons = Person::orderBy('position', 'asc')->offset(0)->limit(100)->get();

                    foreach ($persons as $rs):

                        $position = $rs->position + 1;
                        $person = Person::find($rs->id);
                        $person->fill([
                            'position' => $position,
                        ]);
                        $person->save();

                    endforeach;

                    $person = Person::create([
                                'position' => '0',
                                'name' => $request['name'],
                                'url' => $request['name'],
                                'name_en' => $request['name_en'],
                                'url_en' => $request['name_en'],
                                'status' => '1'
                    ]);



                    $this->audit('Registro de persona  ID #' . $person->id);
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
                $person = Person::find($id);
                $person->fill([
                    'name' => $request['name'],
                    'url' => $request['name'],
                    'name_en' => $request['name_en'],
                    'url_en' => $request['name_en'],
                ]);
                $person->save();
                $this->audit('Actualización persona   ID #' . $id);
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
            $person = Person::find($id);
            $person->fill([
                'status' => '0'
            ]);
            $person->save();
            $this->audit('Eliminar persona  ID #' . $id);
            return response()->json(["msg" => "updated"]);
        } catch (Exception $ex) {
            return false;
        }
        return false;
    }

    /**
     * Move items Persons
     * @param Request $request
     * @return boolean
     */
    public function move_persons(Request $request) {
        try {
            foreach ($request['item'] as $key => $value) {
                $person = Person::find($value);
                $person->fill([
                    'position' => $key
                ]);
                $person->save();
            }
            $this->audit('Ordenar personaes');
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
