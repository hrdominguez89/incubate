<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoriesProjectRequest;
use App\Http\Controllers\Controller;
use App\CategoriesProject;
use App\Audits;
use Flash;
use Session;
use Auth;
use Redirect;
use Illuminate\Http\Request;

class CategoriesProjectController extends Controller {

    /**
     * Validate session
     */
    public function __construct() {
        $this->middleware('admin');
        $this->middleware('role:25');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        try {
            return view('admin.categories_project');
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
            $categories = CategoriesProject::where('status', '1')->orderBy('position', 'asc')->get();
            $json = array();
            foreach ($categories as $rs):
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
    public function store(CategoriesProjectRequest $request) {
        try {
            if ($request->ajax()) {

                $count_categories = CategoriesProject::where('name', $request['name'])->where('status', '1')->count();

                if ($count_categories == 0) {

                    $categories = CategoriesProject::orderBy('position', 'asc')->offset(0)->limit(100)->get();

                    foreach ($categories as $rs):

                        $position = $rs->position + 1;
                        $category = CategoriesProject::find($rs->id);
                        $category->fill([
                            'position' => $position,
                        ]);
                        $category->save();

                    endforeach;

                    $CategoriesProject = CategoriesProject::create([
                                'position' => '0',
                                'name' => $request['name'],
                                'url' => $request['name'],
                                'name_en' => $request['name_en'],
                                'url_en' => $request['name_en'],
                                'status' => '1'
                    ]);


                    $this->audit('Registro de categor??a de proyecto ID #' . $CategoriesProject->id);
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
                $categories = CategoriesProject::find($id);
                $categories->fill([
                    'name' => $request['name'],
                    'url' => $request['name'],
                    'name_en' => $request['name_en'],
                    'url_en' => $request['name_en'],
                ]);
                $categories->save();
                $this->audit('Actualizaci??n categor??a de proyecto ID #' . $id);
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
            $categories = CategoriesProject::find($id);
            $categories->fill([
                'status' => '0'
            ]);
            $categories->save();
            $this->audit('Eliminar categor??a de proyecto ID #' . $id);
            return response()->json(["msg" => "updated"]);
        } catch (Exception $ex) {
            return false;
        }
        return false;
    }

    /**
     * Move items Categoriess
     * @param Request $request
     * @return boolean
     */
    public function move_categories(Request $request) {
        try {
            foreach ($request['item'] as $key => $value) {
                $categories = CategoriesProject::find($value);
                $categories->fill([
                    'position' => $key
                ]);
                $categories->save();
            }
            $this->audit('Ordenar categor??as');
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
        $find = array('??', '??', '??', '??', '??', '??');
        $repl = array('a', 'e', 'i', 'o', 'u', 'n');
        $value = str_replace($find, $repl, $value);
        return $value;
    }

}
