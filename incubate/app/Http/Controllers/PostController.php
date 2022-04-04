<?php

namespace App\Http\Controllers;

use App\Post;
use App\Http\Requests\PostCreateRequest;
use App\Http\Requests\PostUpdateRequest;
use Illuminate\Http\Request;
use App\Audits;
use App\PostsArchives;
use App\CategoriesPost;
use Flash;
use Session;
use Redirect;
use Auth;
use App\Http\Requests;

class PostController extends Controller {

    /**
     * Validate session
     */
    public function __construct() {
        $this->middleware('admin');
        $this->middleware('role:27');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        return view('admin.post_list');
    }

    /**
     * Display list resources
     * @return type
     */
    public function lists() {
        $post = Post::orderBy('created_at', 'desc')->get();
        $json = array();
        foreach ($post as $rs):

            $categories = '';

            if ($rs->categories != "") {
                for ($i = 1; $i <= substr_count($rs->categories, ','); $i++) {
                    $category = explode(',', $rs->categories);
                    $get_category = CategoriesPost::find($category[$i]);
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
                "title_2" => $rs->title,
                "parse_text" => $this->parseText($rs->title),
                "title" => substr($rs->title, 0, 37) . '...',
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
        $information = Post::find($request['id']);
        $total = substr_count($information->image, ',');
        $json = array();
        if ($information->image != "") {
            for ($i = 1; $i <= substr_count($information->image, ','); $i++) {
                $imagen = explode(',', $information->image);
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
        $categories = CategoriesPost::where('status', '1')->orderBy('position', 'asc')->get();
        PostsArchives::where('post', '0')->delete();
        return view('admin.post', ['categories' => $categories]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostCreateRequest $request) {

        $posts = Post::orderBy('position', 'asc')->offset(0)->limit(100)->get();

        foreach ($posts as $rs):

            $position = $rs->position + 1;
            $post = Post::find($rs->id);
            $post->fill([
                'position' => $position,
            ]);
            $post->save();

        endforeach;

        $categories = '';

        if (isset($request['categories'])) {
            for ($i = 0; $i < count($request['categories']); $i++) {
                $categories .= ',' . $request['categories'][$i];
            }
        }


        $post = Post::create([
                    'position' => '0',
                    'title' => $request['title'],
                    'url' => $request['title'],
                    'resume' => $request['resume'],
                    'content' => $request['content'],
                    'title_en' => $request['title_en'],
                    'url_en' => $request['title_en'],
                    'resume_en' => $request['resume_en'],
                    'content_en' => $request['content_en'],
                    'categories' => $categories,
                    'image' => $request['image'],
                    'video' => $request['video']
        ]);


        PostsArchives::where('post', '0')->update([
            'post' => $post->id
        ]);

        $this->audit('Registro de novedad ID #' . $post->id);
        Session()->flash('notice', 'Registro Exitoso');
        return redirect::to('/post');
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
        $post = Post::find($id);
        if (isset($post) == 0)
            return redirect::to('/post');
        $categories = CategoriesPost::where('status', '1')->orderBy('position', 'asc')->get();

        return view('admin.post_edit', ['post' => $post, 'categories' => $categories]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PostUpdateRequest $request, $id) {


        $categories = '';

        if (isset($request['categories'])) {
            for ($i = 0; $i < count($request['categories']); $i++) {
                $categories .= ',' . $request['categories'][$i];
            }
        }


        $post = Post::find($id);
        $post->fill([
            'title' => $request['title'],
            'url' => $request['title'],
            'resume' => $request['resume'],
            'content' => $request['content'],
            'title_en' => $request['title_en'],
            'url_en' => $request['title_en'],
            'resume_en' => $request['resume_en'],
            'content_en' => $request['content_en'],
            'categories' => $categories,
            'image' => $request['image'],
            'video' => $request['video']
        ]);
        $post->save();
        $this->audit('Actualización novedad ID #' . $id);
        Session()->flash('warning', 'Registro Actualizado');
        return Redirect::to('/post');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        Post::destroy($id);
        $this->audit('Eliminar novedad ID #' . $id);
        return response()->json(["msg" => "borrado"]);
    }

    /**
     * Delete photo page
     * @param Request $request
     * @return type
     */
    public function delete_photo(Request $request) {
        $post = Post::find($request['id']);
        $post->fill([
            'image' => $request['image'],
        ]);
        $post->save();
        $this->audit('Eliminar imagen de novedad ID #' . $request['id']);
        return response()->json(["msg" => "borrado"]);
    }

    /**
     * Move items post
     * @param Request $request
     * @return boolean
     */
    public function move_post(Request $request) {
        try {
            foreach ($request['item'] as $key => $value) {
                $post = Post::find($value);
                $post->fill([
                    'position' => $key
                ]);
                $post->save();
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
