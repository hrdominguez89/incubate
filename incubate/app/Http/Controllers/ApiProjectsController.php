<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Project;
use App\CategoriesProject;
use App\Http\Requests;

class ApiProjectsController extends Controller {

    /**
     * Validate access
     */
    public function __construct() {
        $this->middleware('AuthApi');
    }

    /*
     * Show all projects
     * @return type
     */

    public function lists($lang) {
        try {


            $projects = Project::orderBy('position', 'asc')->get();
            $json = array();
            foreach ($projects as $rs):


                if ($rs->image != "" && strpos($rs->image, ',') !== false ) {
                    $image = explode(",", $rs->image);
                    $image = $image[1];
                } else {
                    $image = "no-img.png";
                }
                if ($lang == 'es') {

                    $categories = array();

                    if ($rs->categories != "") {
                        for ($i = 1; $i <= substr_count($rs->categories, ','); $i++) {
                            $category = explode(',', $rs->categories);
                            $get_category = CategoriesProject::find($category[$i]);
                            if (isset($get_category) != 0) {
                                $categories[] = array(
                                    "id" => $get_category->id,
                                    'name' => $get_category->name,
                                    'url' => $get_category->url
                                );
                            }
                        }
                    }

                    $json[] = array(
                        "id" => $rs->id,
                        "title" => $rs->title,
                        "content" => $rs->content,
                        "copy" => $rs->resume,
                        "image" => $image,
                        "categories" => $categories,
                        'facebook' => $rs->facebook,
                        'linkedin' => $rs->linkedin,
                        'flickr' => $rs->flickr,
                        'instagram' => $rs->instagram,
                        'twitter' => $rs->twitter,
                        'youtube' => $rs->youtube,
                        'mentor' => $rs->mentor,
                        'website' => $rs->website,
                        'video' => $rs->video,
                        "url" => $rs->url,
                        "created_at" => date("Y-m-d H:i:s", strtotime($rs->created_at)),
                    );
                } else {

                    $categories = array();

                    if ($rs->categories != "") {
                        for ($i = 1; $i <= substr_count($rs->categories, ','); $i++) {
                            $category = explode(',', $rs->categories);
                            $get_category = CategoriesProject::find($category[$i]);
                            if (isset($get_category) != 0) {
                                $categories[] = array(
                                    "id" => $get_category->id,
                                    'name' => $get_category->name_en,
                                    'url' => $get_category->url_en
                                );
                            }
                        }
                    }

                    $json[] = array(
                        "id" => $rs->id,
                        "title" => $rs->title_en,
                        "copy" => $rs->resume_en,
                        "content" => $rs->content_en,
                        "image" => $image,
                        "categories" => $categories,
                        'facebook' => $rs->facebook,
                        'linkedin' => $rs->linkedin,
                        'flickr' => $rs->flickr,
                        'instagram' => $rs->instagram,
                        'twitter' => $rs->twitter,
                        'youtube' => $rs->youtube,
                        'mentor' => $rs->mentor,
                        'website' => $rs->website,
                        'video' => $rs->video,
                        "url" => $rs->url_en,
                        "created_at" => date("Y-m-d H:i:s", strtotime($rs->created_at)),
                    );
                }


            endforeach;
            return response()->json($json);
        } catch (Exception $ex) {
            return false;
        }
        return false;
    }

    /*
     * Show all projects category
     * @return type
     */

    public function lists_category($lang, $id) {
        try {


            $projects = Project::orderBy('position', 'asc')->get();
            $json = array();
            foreach ($projects as $rs):

                if (strpos($rs->categories, "," . $id) !== false) {

                    if ($rs->image != "" && strpos($rs->image, ',') !== false ) {
                        $image = explode(",", $rs->image);
                        $image = $image[1];
                    } else {
                        $image = "no-img.png";
                    }
                    if ($lang == 'es') {

                        $categories = array();

                        if ($rs->categories != "") {
                            for ($i = 1; $i <= substr_count($rs->categories, ','); $i++) {
                                $category = explode(',', $rs->categories);
                                $get_category = CategoriesProject::find($category[$i]);
                                if (isset($get_category) != 0) {
                                    $categories[] = array(
                                        'id' => $get_category->id,
                                        'name' => $get_category->name,
                                        'url' => $get_category->url
                                    );
                                }
                            }
                        }

                        $json[] = array(
                            "id" => $rs->id,
                            "title" => $rs->title,
                            "content" => $rs->content,
                            "copy" => $rs->resume,
                            "image" => $image,
                            "categories" => $categories,
                            'facebook' => $rs->facebook,
                            'linkedin' => $rs->linkedin,
                            'flickr' => $rs->flickr,
                            'instagram' => $rs->instagram,
                            'twitter' => $rs->twitter,
                            'youtube' => $rs->youtube,
                            'mentor' => $rs->mentor,
                            'website' => $rs->website,
                            'video' => $rs->video,
                            "url" => $rs->url,
                            "created_at" => date("Y-m-d H:i:s", strtotime($rs->created_at)),
                        );
                    } else {

                        $categories = array();

                        if ($rs->categories != "") {
                            for ($i = 1; $i <= substr_count($rs->categories, ','); $i++) {
                                $category = explode(',', $rs->categories);
                                $get_category = CategoriesProject::find($category[$i]);
                                if (isset($get_category) != 0) {
                                    $categories[] = array(
                                        'id' => $get_category->id,
                                        'name' => $get_category->name_en,
                                        'url' => $get_category->url_en
                                    );
                                }
                            }
                        }

                        $json[] = array(
                            "id" => $rs->id,
                            "title" => $rs->title_en,
                            "copy" => $rs->resume_en,
                            "content" => $rs->content_en,
                            "image" => $image,
                            "categories" => $categories,
                            'facebook' => $rs->facebook,
                            'linkedin' => $rs->linkedin,
                            'flickr' => $rs->flickr,
                            'instagram' => $rs->instagram,
                            'twitter' => $rs->twitter,
                            'youtube' => $rs->youtube,
                            'mentor' => $rs->mentor,
                            'website' => $rs->website,
                            'video' => $rs->video,
                            "url" => $rs->url_en,
                            "created_at" => date("Y-m-d H:i:s", strtotime($rs->created_at)),
                        );
                    }
                }
            endforeach;
            return response()->json($json);
        } catch (Exception $ex) {
            return false;
        }
        return false;
    }

}
