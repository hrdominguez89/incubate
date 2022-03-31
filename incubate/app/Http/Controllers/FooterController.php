<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Footer;
use App\Audits;
use Flash;
use Session;
use Redirect;
use Auth;
use Illuminate\Http\Request;

class FooterController extends Controller {

    /**
     * Validate session
     */
    public function __construct() {
        $this->middleware('admin');
        $this->middleware('role:9');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {

        try {
            return view('admin.footer');
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
            $menu = Footer::orderBy('position', 'asc')->get();
            return response()->json($menu);
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
    public function store(Request $request) {
        try {

            $menus = Footer::orderBy('position', 'asc')->offset(0)->limit(100)->get();

            foreach ($menus as $rs):

                $position = $rs->position + 1;
                $menu = Footer::find($rs->id);
                $menu->fill([
                    'position' => $position,
                ]);
                $menu->save();

            endforeach;

            $menu = Footer::create([
                        'position' => '0',
                        'type' => $request['type'],
                        'url' => $request['url'],
                        'title' => $request['title'],
                        'url_en' => $request['url_en'],
                        'title_en' => $request['title_en'],
                        'status' => '1'
            ]);


            $this->audit('Registro de item de menú ID #' . $menu->id);

            Session()->flash('notice', 'Registro Exitoso');
            return response()->json([
                        "msg" => "creado"
            ]);
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
            $menu = Footer::find($id);

            if (isset($menu) == 0)
                return Redirect::to('menu');
            return view('admin.footer_edit', ['menu' => $menu]);
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
    public function update(Request $request, $id) {
        try {

            $menu = Footer::find($id);
            $menu->fill([
                'type' => $request['type'],
                'url' => $request['url'],
                'title' => $request['title'],
                'url_en' => $request['url_en'],
                'title_en' => $request['title_en']
            ]);
            $menu->save();
            $this->audit('Actualización de item de menú ID #' . $id);

            Session()->flash('warning', 'Registro Actualizado');
            return response()->json([
                        "msg" => "creado"
            ]);
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
    public function up_status(Request $request) {
        try {

            if ($request['status'] == '1') {
                $this->audit('Activar  item de menú ID #' . $request['id']);
            } else {
                $this->audit('Desactivar  item de menú ID #' . $request['id']);
            }
            $menu = Footer::find($request['id']);
            $menu->fill([
                'status' => $request['status']
            ]);
            $menu->save();
            return response()->json(["msg" => "borrado"]);
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

        Footer::destroy($id);
        $this->audit('Eliminar menu ID #' . $id);
        return response()->json(["msg" => "borrado"]);
    }

    /**
     * Move items menu
     * @param Request $request
     * @return boolean
     */
    public function move_menu(Request $request) {
        try {
            foreach ($request['item'] as $key => $value) {
                $menu = Footer::find($value);
                $menu->fill([
                    'position' => $key
                ]);
                $menu->save();
            }
            $this->audit('Ordenar items del menú');
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
