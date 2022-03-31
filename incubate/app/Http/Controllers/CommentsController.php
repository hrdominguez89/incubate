<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Comment;
use Flash;
use Session;
use Redirect;
use App\Http\Requests;

class CommentsController extends Controller {

    public function __construct() {
        $this->middleware('admin', ['only' => ['index', 'create', 'store', 'show', 'edit', 'update', 'destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        
    }

    /** Show the pages list ** */
    public function listing() {
        $comment = Comment::orderby('created_at', 'desc')->get();
        $json = array();
        foreach ($comment as $rs) {
            $json[] = array(
                'id' => $rs->id,
                'name' => $rs->name,
                'last_name' => $rs->last_name,
                'email' => $rs->email,
                "message" => $rs->message,
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
//
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        Comment::destroy($id);
        return response()->json(["mensaje" => "borrado"]);
    }

    public function list_comment($post) {
        $comments = Comment::where('post', $post)->get();
        return response()->json($comments);
    }

}
