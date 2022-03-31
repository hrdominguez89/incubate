<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CategoriesProject;
use App\Http\Requests;

class ApiCategoriesProjectsController extends Controller {

    /**
     * Validate access
     */
    public function __construct() {
        $this->middleware('AuthApi');
    }

    /**
     * Show categories
     * @return type
     */
    public function lists($lang) {
        try {
            $categories = CategoriesProject::where('status', '1')->orderBy('position', 'asc')->get();
            $json = array();
            foreach ($categories as $rs):

                if ($lang == 'es') {
                    $json[] = array(
                        "id" => $rs->id,
                        "name" => $rs->name,
                        "url" => $rs->url,
                    );
                } else {
                    $json[] = array(
                        "id" => $rs->id,
                        "name" => $rs->name_en,
                        "url" => $rs->url_en,
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
