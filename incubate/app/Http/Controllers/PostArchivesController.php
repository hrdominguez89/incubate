<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\PostsArchives;
use App\Audits;
use Flash;
use Session;
use Auth;
use Redirect;
use Illuminate\Http\Request;

class PostArchivesController extends Controller {

    /**
     * Validate session
     */
    public function __construct() {
        $this->middleware('admin');
    }

    /**
     * Display list resources
     * @return type
     */
    public function lists($id) {
        try {
            $archives = PostsArchives::where('post', $id)->get();
            $json = array();
            foreach ($archives as $rs):
                $json[] = array(
                    'id' => $rs->id,
                    "name" => $rs->name,
                    "name_en" => $rs->name_en,
                    "file_size" => $rs->file_size,
                    "archive" => $rs->archive,
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
    public function store(Request $request) {
        try {
            if ($request->ajax()) {

                PostsArchives::create([
                    'name' => $request['name'],
                    'name_en' => $request['name_en'],
                    'file_size' => $request['file_size'],
                    'archive' => $request['archive'],
                    'post' => $request['post']
                ]);

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
                $archives = PostsArchives::find($id);
                $archives->fill([
                    'name' => $request['name'],
                    'name_en' => $request['name_en'],
                    'file_size' => $request['file_size'],
                    'archive' => $request['archive'],
                    'post' => $request['post']
                ]);
                $archives->save();

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
            PostsArchives::destroy($id);
            return response()->json(["msg" => "updated"]);
        } catch (Exception $ex) {
            return false;
        }
        return false;
    }

}
