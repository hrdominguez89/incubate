<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\CategoriesPost;
use App\Http\Requests;

class ApiNewsController extends Controller {

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
            $news = Post::orderBy('created_at', 'desc')->get();
            $json = array();
            foreach ($news as $rs):

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
                            $get_category = CategoriesPost::find($category[$i]);
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
                        "copy" => $rs->resume,
                        "content" => $rs->content,
                        "video" => $rs->video,
                        "image" => $image,
                        "categories" => $categories,
                        "url" => $rs->url,
                        "date_format" => $this->nameDay(date("w", strtotime($rs->created_at)), 'es') . ' ' . date("d", strtotime($rs->created_at)) . ' de ' . $this->nameMonth(date("m", strtotime($rs->created_at)), 'es') . ' del ' . date("Y", strtotime($rs->created_at)),
                        "created_at" => date("Y-m-d H:i:s", strtotime($rs->created_at)),
                    );
                } else {

                    $categories = array();

                    if ($rs->categories != "") {
                        for ($i = 1; $i <= substr_count($rs->categories, ','); $i++) {
                            $category = explode(',', $rs->categories);
                            $get_category = CategoriesPost::find($category[$i]);
                            if (isset($get_category) != 0) {
                                $categories[] = array(
                                    'id' => $get_category->id,
                                    'name' => $get_category->name_en,
                                    'url' => $get_category->url_en);
                            }
                        }
                    }


                    $json[] = array(
                        "id" => $rs->id,
                        "title" => $rs->title_en,
                        "copy" => $rs->resume_en,
                        "content" => $rs->content_en,
                        "video" => $rs->video,
                        "image" => $image,
                        "categories" => $categories,
                        "url" => $rs->url_en,
                        "date_format" => $this->nameDay(date("w", strtotime($rs->created_at)), 'en') . ' ' . $this->nameMonth(date("m", strtotime($rs->created_at)), 'en') . ' ' . date("d", strtotime($rs->created_at)) . ', ' . date("Y", strtotime($rs->created_at)),
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
            $news = Post::orderBy('created_at', 'desc')->get();
            $json = array();
            foreach ($news as $rs):

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
                                $get_category = CategoriesPost::find($category[$i]);
                                if (isset($get_category) != 0 && $category[$i] == $id) {
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
                            "copy" => $rs->resume,
                            "image" => $image,
                            "content" => $rs->content,
                            "video" => $rs->video,
                            "categories" => $categories,
                            "url" => $rs->url,
                            "date" => $this->nameMonth(date("m", strtotime($rs->created_at)), 'es') . ' ' . date("d", strtotime($rs->created_at)) . ', ' . date("Y", strtotime($rs->created_at)),
                            "created_at" => date("Y-m-d H:i:s", strtotime($rs->created_at)),
                        );
                    } else {

                        $categories = array();

                        if ($rs->categories != "") {
                            for ($i = 1; $i <= substr_count($rs->categories, ','); $i++) {
                                $category = explode(',', $rs->categories);
                                $get_category = CategoriesPost::find($category[$i]);
                                if (isset($get_category) != 0 && $category[$i] == $id) {
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
                            "image" => $image,
                            "content" => $rs->content_en,
                            "video" => $rs->video,
                            "categories" => $categories,
                            "url" => $rs->url_en,
                            "date_format" => $this->nameDay(date("w", strtotime($rs->created_at)), 'en') . ' ' . $this->nameMonth(date("m", strtotime($rs->created_at)), 'en') . ' ' . date("d", strtotime($rs->created_at)) . ', ' . date("Y", strtotime($rs->created_at)),
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

    public function nameMonth($month, $lang) {


        switch ($month) {
            case 1:
                $month = ($lang == 'es') ? 'Enero' : 'January';
                break;

            case 2:
                $month = ($lang == 'es') ? 'Febrero' : 'February';
                break;

            case 3:
                $month = ($lang == 'es') ? 'Marzo' : 'March';
                break;

            case 4:
                $month = ($lang == 'es') ? 'Abril' : 'April';
                break;

            case 5:
                $month = ($lang == 'es') ? 'Mayo' : 'May';
                break;

            case 6:
                $month = ($lang == 'es') ? 'Junio' : 'June';
                break;

            case 7:
                $month = ($lang == 'es') ? 'Julio' : 'July';
                break;

            case 8:
                $month = ($lang == 'es') ? 'Agosto' : 'August';
                break;

            case 9:
                $month = ($lang == 'es') ? 'Septiembre' : 'September';
                break;

            case 10:
                $month = ($lang == 'es') ? 'Octubre' : 'October';
                break;

            case 11:
                $month = ($lang == 'es') ? 'Noviembre' : 'November';
                break;

            case 12:
                $month = ($lang == 'es') ? 'Diciembre' : 'December';
                break;
        }

        return $month;
    }

    public function nameDay($day, $lang) {

        switch ($day) {
            case 0:
                $day = ($lang == 'es') ? 'Domingo' : 'Sunday';
                break;
            case 1:
                $day = ($lang == 'es') ? 'Lunes' : 'Monday';
                break;
            case 2:
                $day = ($lang == 'es') ? 'Martes' : 'Tuesday';
                break;
            case 3:
                $day = ($lang == 'es') ? 'Miércoles' : 'Wednesday';
                break;
            case 4:
                $day = ($lang == 'es') ? 'Jueves' : 'Thursday';
                break;
            case 5:
                $day = ($lang == 'es') ? 'Viernes' : 'Friday';
                break;
            case 6:
                $day = ($lang == 'es') ? 'Sábado' : 'Saturday';
                break;
        }
        return $day;
    }

}
