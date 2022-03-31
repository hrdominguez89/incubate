<?php

namespace App\Http\Controllers;

use App\Mentors;
use App\Http\Requests\MentorsCreateRequest;
use App\Http\Requests\MentorsUpdateRequest;
use Illuminate\Http\Request;
use App\Audits;
use App\CategoriesMentors;
use Flash;
use Session;
use Redirect;
use Auth;
use App\Http\Requests;

class MentorsController extends Controller {

    /**
     * Validate session
     */
    public function __construct() {
        $this->middleware('admin');
        $this->middleware('role:39');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        return view('admin.mentor_list');
    }

    /**
     * Display list resources
     * @return type
     */
    public function lists() {
        $mentor = Mentors::orderBy('position', 'asc')->get();
        $json = array();
        foreach ($mentor as $rs):

            $categories = '';

            if ($rs->categories != "") {
                for ($i = 1; $i <= substr_count($rs->categories, ','); $i++) {
                    $category = explode(',', $rs->categories);
                    $get_category = CategoriesMentors::find($category[$i]);
                    if (isset($get_category) != 0) {
                        $categories .= $get_category->name;
                    }
                    if ($i != substr_count($rs->categories, ',')) {
                        $categories .= ", ";
                    }
                }
            }

            $json[] = array(
                'id' => $rs->id,
                "parse_text" => $this->parseText($rs->name),
                "name_2" => $rs->name,
                "name" => substr($rs->name, 0, 37) . '...',
                'categories' => mb_substr($categories, 0, 100) . '',
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
        $mentor = Mentors::find($request['id']);
        $total = substr_count($mentor->image, ',');
        $json = array();
        if ($mentor->image != "") {
            for ($i = 1; $i <= substr_count($mentor->image, ','); $i++) {
                $imagen = explode(',', $mentor->image);
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
        $categories = CategoriesMentors::where('status', '1')->orderBy('position', 'asc')->get();
        return view('admin.mentor', ['categories' => $categories]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MentorsCreateRequest $request) {


        $mentors = Mentors::orderBy('position', 'asc')->offset(0)->limit(100)->get();

        foreach ($mentors as $rs):

            $position = $rs->position + 1;
            $mentor = Mentors::find($rs->id);
            $mentor->fill([
                'position' => $position,
            ]);
            $mentor->save();

        endforeach;


        $categories = '';

        if (isset($request['categories'])) {
            for ($i = 0; $i < count($request['categories']); $i++) {
                $categories .= ',' . $request['categories'][$i];
            }
        }


        $mentor = Mentors::create([
                    'name' => $request['name_mentor'],
                    'content' => $request['content'],
                    'content_en' => $request['content_en'],
                    'categories' => $categories,
                    'linkedin' => $request['linkedin'],
                    'instagram' => $request['instagram'],
                    'image' => $request['image']
        ]);


        $this->audit('Registro de mentor ID #' . $mentor->id);
        Session()->flash('notice', 'Registro Exitoso');
        return redirect::to('/mentor');
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
        $mentor = Mentors::find($id);
        if (isset($mentor) == 0)
            return redirect::to('/mentor');
        $categories = CategoriesMentors::where('status', '1')->orderBy('position', 'asc')->get();

        return view('admin.mentor_edit', ['mentor' => $mentor, 'categories' => $categories]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(MentorsUpdateRequest $request, $id) {


        $categories = '';

        if (isset($request['categories'])) {
            for ($i = 0; $i < count($request['categories']); $i++) {
                $categories .= ',' . $request['categories'][$i];
            }
        }


        $mentor = Mentors::find($id);
        $mentor->fill([
            'name' => $request['name_mentor'],
            'content' => $request['content'],
            'content_en' => $request['content_en'],
            'categories' => $categories,
            'linkedin' => $request['linkedin'],
            'instagram' => $request['instagram'],
            'image' => $request['image']
        ]);
        $mentor->save();
        $this->audit('Actualización mentor ID #' . $id);
        Session()->flash('warning', 'Registro Actualizado');
        return Redirect::to('/mentor');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        Mentors::destroy($id);
        $this->audit('Eliminar mentor ID #' . $id);
        return response()->json(["msg" => "borrado"]);
    }

    /**
     * Delete photo page
     * @param Request $request
     * @return type
     */
    public function delete_photo(Request $request) {
        $mentor = Mentors::find($request['id']);
        $mentor->fill([
            'image' => $request['image'],
        ]);
        $mentor->save();
        $this->audit('Eliminar imagen de mentor ID #' . $request['id']);
        return response()->json(["msg" => "borrado"]);
    }

    /**
     * Move items information
     * @param Request $request
     * @return boolean
     */
    public function move_mentor(Request $request) {
        try {
            foreach ($request['item'] as $key => $value) {
                $mentor = Mentors::find($value);
                $mentor->fill([
                    'position' => $key
                ]);
                $mentor->save();
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
