<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Presentations;
use App\CategoriesJob;
use App\State;
use App\Interest;
use App\Members;
use App\Dedicated;
use App\Person;
use Flash;
use Session;
use Redirect;
use App\Http\Requests;

class PresentationsController extends Controller {

    public function __construct() {
        $this->middleware('admin', ['only' => ['index', 'create', 'store', 'show', 'edit', 'update', 'destroy']]);
        $this->middleware('role:16');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        try {
            return view('admin.presentation_lists');
        } catch (Exception $ex) {
            return false;
        }
        return false;
    }

    /** Show the pages list ** */
    public function listing() {
        $presentations = Presentations::orderby('created_at', 'desc')->get();
        $json = array();
        foreach ($presentations as $rs) {



            $category = '';

            for ($i = 0; $i <= substr_count($rs->category, ','); $i++) {
                $category_es = explode(',', $rs->category);
                $get_category = CategoriesJob::find($category_es[$i]);

                if (isset($get_category) != 0) {
                    $category .= $get_category->name . ' ';
                }
            }

            $members = '';
            $get_members = Members::find($rs->members);
            if (isset($get_members) != 0) {
                $members = $get_members->name;
            }

            $person = '';
            $get_person = Person::find($rs->person);
            if (isset($get_person) != 0) {
                $person = $get_person->name;
            }

            $dedicated = '';
            $get_dedicated = Dedicated::find($rs->dedicated);
            if (isset($get_dedicated) != 0) {
                $dedicated = $get_dedicated->name;
            }

            $interest = '';

            for ($i = 0; $i <= substr_count($rs->interest, ','); $i++) {
                $interes = explode(',', $rs->interest);
                $get_interest = Interest::find($interes[$i]);
                if (isset($get_interest) != 0) {
                    $interest .= $get_interest->name . ' ';
                }
            }


            $state = '';
            $get_state = State::find($rs->state);
            if (isset($get_state) != 0) {
                $state = $get_state->name;
            }


            $json[] = array(
                'id' => $rs->id,
                'name' => $rs->name,
                'last_name' => $rs->last_name,
                'email' => $rs->email,
                "project_name" => $rs->project_name,
                "category" => $category,
                "state" => $state,
                "dedicated" => $dedicated,
                "members" => $members,
                "interest" => $interest,
                "person" => $person,
                "created_at" => date("Y-m-d H:i:s", strtotime($rs->created_at))
            );
        }
        return response()->json($json);
    }

//Listar Fotos de la pagina
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {

        $presentation = Presentations::find($id);
        if (isset($presentation) == 0)
            return redirect::to('/presentations');

        return view('admin.presentations_detail', ['presentation' => $presentation]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        
    }

}
