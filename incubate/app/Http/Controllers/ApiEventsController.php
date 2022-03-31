<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Event;
use App\Types;
use Auth;
use App\Http\Requests;

class ApiEventsController extends Controller {

    /**
     * Validate access
     */
    public function __construct() {
        $this->middleware('AuthApi');
    }

    /**
     * Show all event
     * @return type
     */
    public function lists($lang) {
        try {
            $event = Event::
                    where('status_event', '1')
                    ->orderBy('start_date', 'desc')
                    ->get();
            $json = array();
            foreach ($event as $rs):

                if ($rs->image != "" && strpos($rs->image, ',') !== false ) {
                    $image = explode(",", $rs->image);
                    $image = $image[1];
                } else {
                    $image = "no-img.png";
                }
                if ($lang == 'es') {
                    $type = '';
                    $get_type = Types::find($rs->type);
                    if (isset($type) != 0) {
                        $type = $get_type->name;
                    }
                    $json[] = array(
                        "id" => $rs->id,
                        "title" => $rs->title,
                        "url" => $rs->url,
                        "resume" => $rs->resume,
                        "content" => $rs->content,
                        "place" => $rs->place,
                        "date" => date("d", strtotime($rs->start_date)) . ' ' . $this->nameMonth(date("m", strtotime($rs->start_date)), 'es') . ', ' . date("Y", strtotime($rs->start_date)),
                        "type" => $type,
                        "image" => $image,
                    );
                } else {
                    $type = '';
                    $get_type = Types::find($rs->type);
                    if (isset($type) != 0) {
                        $type = $get_type->name_en;
                    }
                    $json[] = array(
                        "id" => $rs->id,
                        "title" => $rs->title_en,
                        "url" => $rs->url_en,
                        "resume" => $rs->resume_en,
                        "content" => $rs->content_en,
                        "place" => $rs->place,
                        "date" => date("d", strtotime($rs->start_date)) . ' ' . $this->nameMonth(date("m", strtotime($rs->start_date)), 'en') . ', ' . date("Y", strtotime($rs->start_date)),
                        "type" => $type,
                        "image" => $image,
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
     * Show event by date and category
     * @return type
     */
    public function lists_date($lang, $id, $date) {
        try {
            $event = Event::whereDate('start_date', '=', date("Y-m-d", strtotime($date)))
                    ->where('status_event', '1')
                    ->orderBy('start_date', 'desc')
                    ->get();
            $json = array();
            foreach ($event as $rs):

                if (strpos($rs->categories, "," . $id) !== false) {
                    if ($rs->image != "" && strpos($rs->image, ',') !== false ) {
                        $image = explode(",", $rs->image);
                        $image = $image[1];
                    } else {
                        $image = "no-img.png";
                    }
                    if ($lang == 'es') {
                        $type = '';
                        $get_type = Types::find($rs->type);
                        if (isset($type) != 0) {
                            $type = $get_type->name;
                        }
                        $json[] = array(
                            "id" => $rs->id,
                            "title" => $rs->title,
                            "url" => $rs->url,
                            "resume" => $rs->resume,
                            "content" => $rs->content,
                            "place" => $rs->place,
                            "date" => $this->nameMonth(date("m", strtotime($rs->start_date)), 'es') . ' ' . date("d", strtotime($rs->start_date)) . ', ' . date("Y", strtotime($rs->start_date)),
                            "type" => $type,
                            "image" => $image,
                        );
                    } else {
                        $type = '';
                        $get_type = Types::find($rs->type);
                        if (isset($type) != 0) {
                            $type = $get_type->name_en;
                        }
                        $json[] = array(
                            "id" => $rs->id,
                            "title" => $rs->title_en,
                            "url" => $rs->url_en,
                            "resume" => $rs->resume_en,
                            "content" => $rs->content_en,
                            "place" => $rs->place,
                            "date" => $this->nameMonth(date("m", strtotime($rs->start_date)), 'en') . ' ' . date("d", strtotime($rs->start_date)) . ', ' . date("Y", strtotime($rs->start_date)),
                            "type" => $type,
                            "image" => $image
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

    /**
     * Show event category
     * @return type
     */
    public function lists_category($lang, $id) {
        try {
            $event = Event::
                    where('status_event', '1')
                    ->orderBy('start_date', 'desc')
                    ->get();
            $json = array();
            foreach ($event as $rs):
                if (strpos($rs->categories, "," . $id) !== false) {
                    if ($rs->image != "" && strpos($rs->image, ',') !== false ) {
                        $image = explode(",", $rs->image);
                        $image = $image[1];
                    } else {
                        $image = "no-img.png";
                    }
                    if ($lang == 'es') {
                        $type = '';
                        $get_type = Types::find($rs->type);
                        if (isset($type) != 0) {
                            $type = $get_type->name;
                        }
                        $json[] = array(
                            "id" => $rs->id,
                            "title" => $rs->title,
                            "url" => $rs->url,
                            "resume" => $rs->resume,
                            "content" => $rs->content,
                            "place" => $rs->place,
                            "date" => $this->nameMonth(date("m", strtotime($rs->start_date)), 'es') . ' ' . date("d", strtotime($rs->start_date)) . ', ' . date("Y", strtotime($rs->start_date)),
                            "type" => $type,
                            "image" => $image
                        );
                    } else {
                        $type = '';
                        $get_type = Types::find($rs->type);
                        if (isset($type) != 0) {
                            $type = $get_type->name_en;
                        }
                        $json[] = array(
                            "id" => $rs->id,
                            "title" => $rs->title_en,
                            "url" => $rs->url_en,
                            "resume" => $rs->resume_en,
                            "content" => $rs->content_en,
                            "place" => $rs->place,
                            "date" => $this->nameMonth(date("m", strtotime($rs->start_date)), 'en') . ' ' . date("d", strtotime($rs->start_date)) . ', ' . date("Y", strtotime($rs->start_date)),
                            "type" => $type,
                            "image" => $image
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

}
