<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Audits;
use App\Event;
use App\Information;
use App\Comment;
use App\Users;
use App\Post;
use App\CategoriesProject;
use App\CategoriesEvent;
use App\CategoriesPost;
use App\Types;
use App\Project;
use App\Faqs;
use App\Rol;
use App\Presentations;
use App\CategoriesJob;
use App\Members;
use App\Person;
use App\Interest;
use App\Dedicated;
use App\State;
use Auth;
use Cache;
use Session;
use Redirect;
use App\Exports\BAExcel;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Requests;

class ExcelController extends Controller {

    /**
     * Validate session
     */
    public function __construct() {
        $this->middleware('admin');
    }

    /**
     * generate excel administrators
     * @return type
     */
    public function administrators($init, $end) {


        if (Auth::guard('admin')->User()->level != '1')
            return redirect::to('/dashboard');

        $this->audit('Descarga reporte de administradores');

        if ($init != '') {
            $init = explode('-', $init);
            $init = $init[2] . "-" . $init[1] . "-" . $init[0];
        }
        if ($end != '') {
            $end = explode('-', $end);
            $end = $end[2] . "-" . $end[1] . "-" . $end[0];
        }

        $fileName = 'administradores_' . $init . '_' . $end . '.xlsx';


        $users = Users::
                when(!empty($init), function ($query) use($init) {
                    return $query->whereDate('created_at', '>=', date("Y-m-d", strtotime($init)));
                })
                ->when(!empty($end), function ($query) use($end) {
                    return $query->whereDate('created_at', '<=', date("Y-m-d", strtotime($end)));
                })
                ->where('level', '2')
                ->orderby('created_at', 'asc')
                ->offset(0)->limit(5000)
                ->get();

        if (count($users) == 0) {
            Session()->flash('no-results', 'No hay resultados');
            return redirect::to('/user');
        }

        $json = array();
        foreach ($users as $rs) {

            $rol = Rol::find($rs->rol);

            $json[] = array(
                        "id" => $rs->id,
                        "name" => $rs->name,
                        "cuit" => $rs->cuit,
                        "rol" => $rol->name,
                        "created_at" => date("Y-m-d H:i", strtotime($rs->created_at))
            );
        }

        return Excel::download(new BAExcel('admins', $json), $fileName);
    }

    /**
     * generate excel events
     * @return type
     */
    public function events($init, $end) {

        if (Auth::guard('admin')->User()->level != '1')
            return redirect::to('/dashboard');

        $this->audit('Descarga reporte de eventos');

        if ($init != '') {
            $init = explode('-', $init);
            $init = $init[2] . "-" . $init[1] . "-" . $init[0];
        }
        if ($end != '') {
            $end = explode('-', $end);
            $end = $end[2] . "-" . $end[1] . "-" . $end[0];
        }

        $fileName = 'agenda_' . $init . '_' . $end . '.xlsx';

        $events = Event::
                when(!empty($init), function ($query) use($init) {
                    return $query->whereDate('created_at', '>=', date("Y-m-d", strtotime($init)));
                })
                ->when(!empty($end), function ($query) use($end) {
                    return $query->whereDate('created_at', '<=', date("Y-m-d", strtotime($end)));
                })
                ->orderby('created_at', 'asc')
                ->offset(0)->limit(5000)
                ->get();

        if (count($events) == 0) {
            Session()->flash('no-results', 'No hay resultados');
            return redirect::to('/event');
        }


        $json = array();
        foreach ($events as $rs) {

            $type = '';

            $get_type = Types::find($rs->type);
            if (isset($type) != 0) {
                $type = $get_type->name;
            }

            $categories = '';

            if ($rs->categories != "") {
                for ($i = 1; $i <= substr_count($rs->categories, ','); $i++) {
                    $category = explode(',', $rs->categories);
                    $get_category = CategoriesEvent::find($category[$i]);
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
                'title' => $rs->title,
                'resume' => $this->clean_text($rs->resume),
                'title_en' => $rs->title_en,
                'resume_en' => $this->clean_text($rs->resume_en),
                'type' => $type,
                'category' => $categories,
                'place' => $rs->place,
                'start_date' => date("Y-m-d H:i", strtotime($rs->start_date)),
                'end_date' => date("Y-m-d H:i", strtotime($rs->end_date)),
                'created_at' => date("Y-m-d H:i", strtotime($rs->created_at))
            );
        }
        return Excel::download(new BAExcel('events', $json), $fileName);
    }

    /**
     * generate excel informations
     * @return type
     */
    public function informations($init, $end) {

        if (Auth::guard('admin')->User()->level != '1')
            return redirect::to('/dashboard');

        $this->audit('Descarga reporte de información útil');

        if ($init != '') {
            $init = explode('-', $init);
            $init = $init[2] . "-" . $init[1] . "-" . $init[0];
        }
        if ($end != '') {
            $end = explode('-', $end);
            $end = $end[2] . "-" . $end[1] . "-" . $end[0];
        }

        $fileName = 'que_es_incubate_' . $init . '_' . $end . '.xlsx';

        $informations = Information::
                when(!empty($init), function ($query) use($init) {
                    return $query->whereDate('created_at', '>=', date("Y-m-d", strtotime($init)));
                })
                ->when(!empty($end), function ($query) use($end) {
                    return $query->whereDate('created_at', '<=', date("Y-m-d", strtotime($end)));
                })
                ->orderby('created_at', 'asc')
                ->offset(0)->limit(5000)
                ->get();


        if (count($informations) == 0) {
            Session()->flash('no-results', 'No hay resultados');
            return redirect::to('/information');
        }


        $json = array();
        foreach ($informations as $rs) {

            $json[] = array(
                'id' => $rs->id,
                'title' => $rs->title,
                'content' => $this->clean_text($rs->content),
                'title_en' => $rs->title_en,
                'content_en' => $this->clean_text($rs->content_en),
                'boton_name' => $rs->boton_name,
                'created_at' => date("Y-m-d H:i", strtotime($rs->created_at))
            );
        }
        return Excel::download(new BAExcel('informations', $json), $fileName);
    }

    /**
     * generate excel projects
     * @return type
     */
    public function projects($init, $end) {

        if (Auth::guard('admin')->User()->level != '1')
            return redirect::to('/dashboard');

        $this->audit('Descarga reporte de proyectos');

        if ($init != '') {
            $init = explode('-', $init);
            $init = $init[2] . "-" . $init[1] . "-" . $init[0];
        }
        if ($end != '') {
            $end = explode('-', $end);
            $end = $end[2] . "-" . $end[1] . "-" . $end[0];
        }

        $fileName = 'proyectos_' . $init . '_' . $end . '.xlsx';

        $projects = Project::
                when(!empty($init), function ($query) use($init) {
                    return $query->whereDate('created_at', '>=', date("Y-m-d", strtotime($init)));
                })
                ->when(!empty($end), function ($query) use($end) {
                    return $query->whereDate('created_at', '<=', date("Y-m-d", strtotime($end)));
                })
                ->orderby('created_at', 'asc')
                ->offset(0)->limit(5000)
                ->get();


        if (count($projects) == 0) {
            Session()->flash('no-results', 'No hay resultados');
            return redirect::to('/project');
        }


        $json = array();
        foreach ($projects as $rs) {

            $categories = '';

            if ($rs->categories != "") {
                for ($i = 1; $i <= substr_count($rs->categories, ','); $i++) {
                    $category = explode(',', $rs->categories);
                    $get_category = CategoriesProject::find($category[$i]);
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
                'title' => $rs->title,
                'resume' => $this->clean_text($rs->resume),
                'title_en' => $rs->title_en,
                'resume_en' => $this->clean_text($rs->resume_en),
                'category' => $categories,
                'facebook' => $rs->facebook,
                'linkedin' => $rs->linkedin,
                'flickr' => $rs->flickr,
                'instagram' => $rs->instagram,
                'twitter' => $rs->twitter,
                'youtube' => $rs->youtube,
                'mentor' => $rs->mentor,
                'website' => $rs->website,
                'created_at' => date("Y-m-d H:i", strtotime($rs->created_at))
            );
        }
        return Excel::download(new BAExcel('projects', $json), $fileName);
    }

    /**
     * generate excel novedades
     * @return type
     */
    public function posts($init, $end) {

        if (Auth::guard('admin')->User()->level != '1')
            return redirect::to('/dashboard');

        $this->audit('Descarga reporte de novedades');

        if ($init != '') {
            $init = explode('-', $init);
            $init = $init[2] . "-" . $init[1] . "-" . $init[0];
        }
        if ($end != '') {
            $end = explode('-', $end);
            $end = $end[2] . "-" . $end[1] . "-" . $end[0];
        }

        $fileName = 'noticias_' . $init . '_' . $end . '.xlsx';


        $posts = Post::
                when(!empty($init), function ($query) use($init) {
                    return $query->whereDate('created_at', '>=', date("Y-m-d", strtotime($init)));
                })
                ->when(!empty($end), function ($query) use($end) {
                    return $query->whereDate('created_at', '<=', date("Y-m-d", strtotime($end)));
                })
                ->orderby('created_at', 'asc')
                ->offset(0)->limit(5000)
                ->get();


        if (count($posts) == 0) {
            Session()->flash('no-results', 'No hay resultados');
            return redirect::to('/post');
        }


        $json = array();
        foreach ($posts as $rs) {

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
                'title' => $rs->title,
                'resume' => $this->clean_text($rs->resume),
                'title_en' => $rs->title_en,
                'resume_en' => $this->clean_text($rs->resume_en),
                'category' => $categories,
                'created_at' => date("Y-m-d H:i", strtotime($rs->created_at))
            );
        }
        return Excel::download(new BAExcel('posts', $json), $fileName);
    }

    /**
     * Generate excel faq
     * @return type
     */
    public function faq($init, $end) {

        if (Auth::guard('admin')->User()->level != '1')
            return redirect::to('/dashboard');

        $this->audit('Descarga reporte de preguntas frecuentes');

        if ($init != '') {
            $init = explode('-', $init);
            $init = $init[2] . "-" . $init[1] . "-" . $init[0];
        }
        if ($end != '') {
            $end = explode('-', $end);
            $end = $end[2] . "-" . $end[1] . "-" . $end[0];
        }

        $fileName = 'faq_' . $init . '_' . $end . '.xlsx';
        $faq = Faqs::
                when(!empty($init), function ($query) use($init) {
                    return $query->whereDate('created_at', '>=', date("Y-m-d", strtotime($init)));
                })
                ->when(!empty($end), function ($query) use($end) {
                    return $query->whereDate('created_at', '<=', date("Y-m-d", strtotime($end)));
                })
                ->orderby('created_at', 'asc')
                ->offset(0)->limit(5000)
                ->get();

        if (count($faq) == 0) {
            Session()->flash('no-results', 'No hay resultados');
            return redirect::to('/faq');
        }
        $json = array();
        foreach ($faq as $rs) {



            $json[] = array(
                "id" => $rs->id,
                "title" => $rs->title,
                "content" => $this->clean_text($rs->content),
                "title_en" => $rs->title,
                "content_en" => $this->clean_text($rs->content),
                "created_at" => date("Y-m-d H:i", strtotime($rs->created_at))
            );
        }

        return Excel::download(new BAExcel('faqs', $json), $fileName);
    }

    /**
     * generate excel activities search
     * @param string $id_user
     * @param type $init
     * @param type $end
     * @return type
     */
    public function activities($id_user, $init = 0, $end = 0) {

        if (Auth::guard('admin')->User()->level != '1')
            return redirect::to('/dashboard');

        if ($init == "0") {
            $init = '';
        }
        if ($end == "0") {
            $end = '';
        }

        $this->audit('Descarga reporte de auditoria');
        if ($id_user == 0)
            $id_user = '';
        if ($init != '') {
            $init = explode('-', $init);
            $init = $init[2] . "-" . $init[1] . "-" . $init[0];
        }
        if ($end != '') {
            $end = explode('-', $end);
            $end = $end[2] . "-" . $end[1] . "-" . $end[0];
        }
        $fileName = 'auditoria_' . $init . '_' . $end . '.xlsx';
        $activities = Audits::
                        when(!empty($id_user), function ($query) use($id_user) {

                            return $query->where('id_user', $id_user);
                        })
                        ->when(!empty($init), function ($query) use($init) {
                            return $query->whereDate('created_at', '>=', date("Y-m-d", strtotime($init)));
                        })
                        ->when(!empty($end), function ($query) use($end) {
                            return $query->whereDate('created_at', '<=', date("Y-m-d", strtotime($end)));
                        })
                        ->offset(0)->limit(5000)
                        ->orderby('created_at', 'asc')->get();

        if (count($activities) == 0) {
            Session()->flash('no-results', 'No hay resultados');
            return redirect::to('/audits');
        }
        $json = array();
        foreach ($activities as $rs) {
            $user = Users::where('id', $rs->id_user)->first();
            if (isset($user)) {
                $json[] = array(
                    "id" => $rs->id,
                    "name" => $user->name,
                    "cuit" => $user->cuit,
                    "ip" => $rs->ip,
                    "activity" => $rs->activity,
                    "created_at" => date("Y-m-d H:i", strtotime($rs->created_at))
                );
            }
        }
        return Excel::download(new BAExcel('audits', $json), $fileName);
    }

    /**
     * Format text
     * @param type $text
     * @return boolean
     */
    public function clean_text($text) {
        try {
            $content = strip_tags($text, '');
            $content = str_replace('</br>', ' ', $content);
            $content = str_replace('&aacute;', 'á', $content);
            $content = str_replace('&eacute;', 'é', $content);
            $content = str_replace('&iacute;', 'í', $content);
            $content = str_replace('&oacute;', 'ó', $content);
            $content = str_replace('&uacute;', 'ú', $content);
            $content = str_replace('&ntilde;', 'ñ', $content);
            $content = str_replace('&nbsp;', ' ', $content);
            $content = str_replace('&iquest;', '¿', $content);
            $content = str_replace('&ldquo;', '“', $content);
            $content = str_replace('&rdquo;', '”', $content);
            $content = trim($content);

            return $content;
        } catch (Exception $ex) {
            return false;
        }
        return false;
    }

    /**
     * generate excel messages
     * @return type
     */
    public function messages($init, $end) {


        if (Auth::guard('admin')->User()->level != '1')
            return redirect::to('/dashboard');


        if ($init != '') {
            $init = explode('-', $init);
            $init = $init[2] . "-" . $init[1] . "-" . $init[0];
        }
        if ($end != '') {
            $end = explode('-', $end);
            $end = $end[2] . "-" . $end[1] . "-" . $end[0];
        }

        $fileName = 'mensajes_' . $init . '_' . $end . '.xlsx';

        $messages = Comment::
                when(!empty($init), function ($query) use($init) {
                    return $query->whereDate('created_at', '>=', date("Y-m-d", strtotime($init)));
                })
                ->when(!empty($end), function ($query) use($end) {
                    return $query->whereDate('created_at', '<=', date("Y-m-d", strtotime($end)));
                })
                ->orderby('created_at', 'asc')
                ->offset(0)->limit(5000)
                ->get();

        if (count($messages) == 0) {
            Session()->flash('no-results', 'No hay resultados');
            return redirect::to('/dashboard');
        }


        $json = array();
        foreach ($messages as $rs) {



            $json[] = array(
                'id' => $rs->id,
                'name' => $rs->name,
                'last_name' => $rs->last_name,
                'email' => $rs->email,
                'message' => $rs->message,
                'created_at' => date("Y-m-d H:i", strtotime($rs->created_at))
            );
        }
        return Excel::download(new BAExcel('messages', $json), $fileName);
    }

    /**
     * Generate excel presentations
     * @return type
     */
    public function presentations($init, $end) {

        if (Auth::guard('admin')->User()->level != '1')
            return redirect::to('/dashboard');

        $this->audit('Descarga reporte de presentacion de proyectos');

        if ($init != '') {
            $init = explode('-', $init);
            $init = $init[2] . "-" . $init[1] . "-" . $init[0];
        }
        if ($end != '') {
            $end = explode('-', $end);
            $end = $end[2] . "-" . $end[1] . "-" . $end[0];
        }


        $fileName = 'presentaciones_' . $init . '_' . $end . '.xlsx';


        $presentations = Presentations::
                when(!empty($init), function ($query) use($init) {
                    return $query->whereDate('created_at', '>=', date("Y-m-d", strtotime($init)));
                })
                ->when(!empty($end), function ($query) use($end) {
                    return $query->whereDate('created_at', '<=', date("Y-m-d", strtotime($end)));
                })
                ->orderby('created_at', 'asc')
                ->offset(0)->limit(5000)
                ->get();

        if (count($presentations) == 0) {
            Session()->flash('no-results', 'No hay resultados');
            return redirect::to('/presentations');
        }


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
                'dni' => $rs->dni,
                'email' => $rs->email,
                'phone' => $this->format_phone($rs->phone),
                'person' => $person,
                'project_name' => $rs->project_name,
                'description' => $this->clean_text($rs->description),
                'website' => $rs->website,
                'category' => $category,
                'members' => $members,
                'dedicated' => $dedicated,
                'state' => $state,
                'interest' => $interest,
                'created_at' => date("Y-m-d H:i", strtotime($rs->created_at))
            );
        }
        return Excel::download(new BAExcel('presentations', $json), $fileName);
    }

    /**
     * Audit user
     * @return type
     */
    public function audit($activity) {
        try {
            Audits::create([
                'activity' => $activity,
                'ip' => $this->getIp(),
                'id_user' => Auth::guard('admin')->User()->id
            ]);
        } catch (Exception $ex) {
            return false;
        }
        return false;
    }

    /**
     * Get Ip User
     * @return type
     */
    public function getIp() {
        try {
            if (!empty($_SERVER['HTTP_CLIENT_IP'])) {   //check ip from share internet
                $ip = $_SERVER['HTTP_CLIENT_IP'];
            } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {   //to check ip is pass from proxy
                $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
            } else {
                $ip = $_SERVER['REMOTE_ADDR'];
            }
            return $ip;
        } catch (Exception $ex) {
            return false;
        }
        return false;
    }

    /**
     * Format phone
     * @param type $phone
     * @return boolean|string
     */
    public function format_phone($phone) {
        try {
            if (!isset($phone{3})) {
                return $phone;
            }
            $phone = preg_replace("/[^0-9]/", "", $phone);
            $length = strlen($phone);
            switch ($length) {
                case 7:
                    return preg_replace("/([0-9]{3})([0-9]{4})/", "$1-$2", $phone);
                    break;
                case 8:
                    return preg_replace("/([0-9]{4})([0-9]{4})/", "$1-$2", $phone);
                    break;
                case 9:
                    return preg_replace("/([0-9]{2})([0-9]{3})([0-9]{4})/", "$1 $2-$3", $phone);
                    break;
                case 10:
                    return preg_replace("/([0-9]{3})([0-9]{3})([0-9]{4})/", "$1 $2-$3", $phone);
                    break;
                case 11:
                    return preg_replace("/([0-9]{1})([0-9]{2})([0-9]{4})([0-9]{4})/", "$1 $2 $3-$4", $phone);
                    break;
                default:
                    return $phone;
                    break;
            }
        } catch (Exception $ex) {
            return false;
        }
        return false;
    }

}
