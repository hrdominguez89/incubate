<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Mail\BAMail;
use App\Http\Controllers\Controller;
use App\Users;
use App\Audits;
use App\Rol;
use Mail;
use Flash;
use Auth;
use Session;
use Redirect;
use Illuminate\Http\Request;

class UserController extends Controller {

    /**
     * Validate session
     */
    public function __construct() {

        $this->middleware('admin');
        $this->middleware('role:2');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        try {
            return view('admin.user_list');
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
            $user = Users::where('level', '2')->orderby('id', 'desc')->get();
            $json = array();
            foreach ($user as $rs):

                $rol = Rol::find($rs->rol);
                $json[] = array(
                    "id" => $rs->id,
                    "parse_text" => $this->parseText($rs->name),
                    "name" => $rs->name,
                    "cuit" => $rs->cuit,
                    "rol" => $rol->name,
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
        try {
            $rol = Rol::pluck('name', 'id');
            return view('admin.user', compact('rol'));
        } catch (Exception $ex) {
            return false;
        }
        return false;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserCreateRequest $request) {
        try {


            $user = Users::create([
                        'name' => $request['name'],
                        'rol' => $request['rol'],
                        'cuit' => $request['cuit'],
                        'password' => $request['cuit'],
                        'level' => '2'
            ]);


            $this->audit('Registro de administrador ID #' . $user->id);


            Session()->flash('notice', 'Registro Exitoso');
            return redirect::to('/user');
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
            $user = Users::find($id);
            if (isset($user) == 0)
                return redirect::to('/user');
            $rol = Rol::pluck('name', 'id');
            return view('admin.user_edit', ['user' => $user], compact('rol'));
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
    public function update(UserUpdateRequest $request, $id) {
        try {
            $user = Users::find($id);
            $user->fill([
                'name' => $request['name'],
                'rol' => $request['rol'],
                'level' => '2',
                'cuit' => $request['cuit'],
                'password' => $request['cuit']
            ]);
            $user->save();

            $this->audit('Actualización de datos de administrador ID #' . $id);


            Session()->flash('warning', 'Registro Actualizado');
            return redirect::to('/user');
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
            Audits::where('id_user', $id)->delete();
            Users::destroy($id);
            $this->audit('Eliminar administrador ID #' . $id);
            return response()->json(["msg" => "borrado"]);
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
     * Get cuit
     * @param type $length
     * @param type $uc
     * @param type $n
     * @param type $sc
     * @return boolean
     */
    public function getcuit($length = 10, $uc = TRUE, $n = TRUE, $sc = FALSE) {
        try {
            $source = 'abcdefghijklmnopqrstuvwxyz';
            if ($uc == 1)
                $source .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
            if ($n == 1)
                $source .= '1234567890';
            if ($sc == 1)
                $source .= '-@#~$%()=^*+[]{}-_';
            if ($length > 0) {
                $rstr = "";
                $source = str_split($source, 1);
                for ($i = 1; $i <= $length; $i++) {
                    mt_srand((double) microtime() * 1000000);
                    $num = mt_rand(1, count($source));
                    $rstr .= $source[$num - 1];
                }
            }
            return $rstr;
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
