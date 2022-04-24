<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mentors;
use App\CategoriesMentors;
use App\Http\Requests;

class ApiMentorsController extends Controller {

    /**
     * Validate access
     */
    public function __construct() {
        $this->middleware('AuthApi');
    }

    /**
     * Show all news
     * @return type
     */
    public function lists($lang) {
        try {
            $mentors = $mentor = Mentors::orderBy('name', 'asc')->get();
            $json = array();
            foreach ($mentors as $rs):

                if ($rs->image != "" && strpos($rs->image, ',') !== false ) {
                    $image = explode(",", $rs->image);
                    $image = $image[1];
                } else {
                    $image = "no-img.png";
                }
                if ($lang == 'es') {

                    $json[] = array(
                        "id" => $rs->id,
                        "name" => $rs->name,
                        "content" => $rs->content,
                        "instagram" => $rs->instagram,
                        "linkedin" => $rs->linkedin,
                        "image" => $image,
                        "created_at" => date("Y-m-d H:i:s", strtotime($rs->created_at)),
                    );
                } else {


                    $json[] = array(
                        "id" => $rs->id,
                        "name" => $rs->name,
                        "content_en" => $rs->content_en,
                        "instagram" => $rs->instagram,
                        "linkedin" => $rs->linkedin,
                        "image" => $image,
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

    /**
     * Show all news category
     * @return type
     */
    public function lists_category($lang, $id) {
        try {
            $mentors = $mentor = Mentors::orderBy('name', 'asc')->get();
            $json = array();
            foreach ($mentors as $rs):

                if (strpos($rs->categories, "," . $id) !== false) {

                    if ($rs->image != "" && strpos($rs->image, ',') !== false ) {
                        $image = explode(",", $rs->image);
                        $image = $image[1];
                    } else {
                        $image = "no-img.png";
                    }
                    if ($lang == 'es') {

                        $json[] = array(
                            "id" => $rs->id,
                            "name" => $rs->name,
                            "content" => $rs->content,
                            "instagram" => $rs->instagram,
                            "linkedin" => $rs->linkedin,
                            "image" => $image,
                            "created_at" => date("Y-m-d H:i:s", strtotime($rs->created_at)),
                        );
                    } else {


                        $json[] = array(
                            "id" => $rs->id,
                            "name" => $rs->name,
                            "content_en" => $rs->content_en,
                            "instagram" => $rs->instagram,
                            "linkedin" => $rs->linkedin,
                            "image" => $image,
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
