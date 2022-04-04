<?php

namespace App\Http\Controllers;

use App\Project;
use App\Http\Requests\ProjectCreateRequest;
use App\Http\Requests\ProjectUpdateRequest;
use Illuminate\Http\Request;
use App\Audits;
use App\ProjectsArchives;
use App\CategoriesProject;
use Flash;
use Session;
use Redirect;
use Auth;
use App\Http\Requests;

class ProjectController extends Controller {

    /**
     * Validate session
     */
    public function __construct() {
        $this->middleware('admin');
        $this->middleware('role:24');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        return view('admin.project_list');
    }

    /**
     * Display list resources
     * @return type
     */
    public function lists() {
        $project = Project::orderBy('position', 'asc')->get();
        $json = array();
        foreach ($project as $rs):

            $categories='';

            if ($rs->categories != "") {
                for ($i = 1; $i <= substr_count($rs->categories, ','); $i++) {
                    $category = explode(',', $rs->categories);
                    $get_category = CategoriesProject::find($category[$i]);
                    if(isset($get_category)!=0){
                        $categories .= $get_category->name;
                    }
                    if ($i != substr_count($rs->categories, ',')) {
                        $categories .= ", ";
                    }
                }
            }

            $json[] = array(
                'id' => $rs->id,
                "parse_text" => $this->parseText($rs->title),
                "title_2" => $rs->title,
                "title" => substr($rs->title, 0, 37) . '...',
                'categories'=>mb_substr($categories, 0, 100) .'',
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
        $project = Project::find($request['id']);
        $total = substr_count($project->image, ',');
        $json=array();
        if ($project->image != "") {
            for ($i = 1; $i <= substr_count($project->image, ','); $i++) {
                $imagen = explode(',', $project->image);
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
        ProjectsArchives::where('project','0')->delete();
        $categories = CategoriesProject::where('status', '1')->orderBy('position', 'asc')->get();
        return view('admin.project',['categories'=>$categories]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProjectCreateRequest $request) {


        $projects = Project::orderBy('position', 'asc')->offset(0)->limit(100)->get();

        foreach ($projects as $rs):

            $position=$rs->position+1;
            $project = Project::find($rs->id);
            $project->fill([
                'position' => $position,
            ]);
            $project->save();

        endforeach;


        $categories = '';

        if (isset($request['categories'])) {
            for ($i = 0; $i < count($request['categories']); $i++) {
                $categories .= ',' . $request['categories'][$i];
            }
        }

        
          $project =Project::create([
            'title' => $request['title'],
            'url' => $request['title'],
            'content' => $request['content'],
            'resume'=>$request['resume'],
            'email'=>$request['email'],
            'title_en' => $request['title'],
            'url_en' => $request['title_en'],
            'resume_en'=>$request['resume_en'],
            'content_en' => $request['content_en'],
            'categories' => $categories,
            'facebook' => $request['facebook'],
            'linkedin' => $request['linkedin'],
            'flickr' => $request['flickr'],
            'instagram' => $request['instagram'],
            'twitter' => $request['twitter'],
            'youtube' => $request['youtube'],
            'mentor' => $request['mentor'],
            'website' => $request['website'],
            'image' => $request['image'],
            'video' => $request['video'],
            
        ]);
        

         ProjectsArchives::where('project', '0')->update([
                    'project' => $project->id
                ]);

        $this->audit('Registro de proyecto ID #' . $project->id);
        Session()->flash('notice', 'Registro Exitoso');
        return redirect::to('/project');
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
        $project = Project::find($id);
        if (isset($project) == 0)
            return redirect::to('/project');
        $categories = CategoriesProject::where('status', '1')->orderBy('position', 'asc')->get();

        return view('admin.project_edit',['project' => $project,'categories'=>$categories]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProjectUpdateRequest $request, $id) {
        

        $categories = '';

        if (isset($request['categories'])) {
            for ($i = 0; $i < count($request['categories']); $i++) {
                $categories .= ',' . $request['categories'][$i];
            }
        }
        

        $project = Project::find($id);
        $project->fill([
            'title' => $request['title'],
            'url' => $request['title'],
            'content' => $request['content'],
            'resume'=>$request['resume'],
            'email'=>$request['email'],
            'title_en' => $request['title_en'],
            'url_en' => $request['title_en'],
            'resume_en'=>$request['resume_en'],
            'content_en' => $request['content_en'],
            'categories' => $categories,
            'facebook' => $request['facebook'],
            'linkedin' => $request['linkedin'],
            'flickr' => $request['flickr'],
            'instagram' => $request['instagram'],
            'twitter' => $request['twitter'],
            'youtube' => $request['youtube'],
            'mentor' => $request['mentor'],
            'website' => $request['website'],
            'image' => $request['image'],
            'video' => $request['video']
        ]);
        $project->save();
        $this->audit('Actualización proyecto ID #' . $id);
        Session()->flash('warning', 'Registro Actualizado');
        return Redirect::to('/project');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        Project::destroy($id);
        $this->audit('Eliminar proyecto ID #' . $id);
        return response()->json(["msg" => "borrado"]);
    }

    /**
     * Delete photo page
     * @param Request $request
     * @return type
     */
    public function delete_photo(Request $request) {
        $project = Project::find($request['id']);
        $project->fill([
            'image' => $request['image'],
        ]);
        $project->save();
        $this->audit('Eliminar imagen de proyecto ID #' . $request['id']);
        return response()->json(["msg" => "borrado"]);
    }


    /**
     * Move items information
     * @param Request $request
     * @return boolean
     */
    public function move_project(Request $request) {
        try {
            foreach ($request['item'] as $key => $value) {
                $project = Project::find($value);
                $project->fill([
                    'position' => $key
                ]);
                $project->save();
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
