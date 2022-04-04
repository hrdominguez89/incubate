<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Faqs;
use App\Http\Requests;

class ApiFaqController extends Controller {

    /**
     * Validate access
     */
    public function __construct() {
        $this->middleware('AuthApi');
    }

    /**
     * Show faq
     * @return type
     */
    public function lists($lang) {
        try {
            $faq = Faqs::where('status', '1')->orderBy('position', 'asc')->get();
            $json = array();
            foreach ($faq as $rs):

                if ($lang == 'es') {
                    $json[] = array(
                        "id" => $rs->id,
                        "title" => $rs->title,
                        "content" => $rs->content,
                    );
                } else {
                    $json[] = array(
                        "id" => $rs->id,
                        "title" => $rs->title_en,
                        "content" => $rs->content_en,
                    );
                }
            endforeach;
            return response()->json($json);
        } catch (Exception $ex) {
            return false;
        }
        return false;
    }

}
