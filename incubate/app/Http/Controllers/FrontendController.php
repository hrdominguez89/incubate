<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Visits;
use App\Comment;
use App\Menu;
use App\Faq;
use App\Post;
use App\Documents;
use App\CategoriesInformation;
use App\CategoriesEvent;
use App\Presentations;
use App\Event;
use App\Project;
use App\CategoriesPost;
use App\CategoriesProject;
use App\Information;
use App\Widgets;
use App\CategoriesJob;
use App\CategoriesMentors;
use App\Members;
use App\Person;
use App\Interest;
use App\Dedicated;
use App\State;
use App\Faqs;
use Route;
use Redirect;
use DB;
use Session;
use Auth;
use URL;
use Mobile_Detect;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\JsonResponse;
use App\Http\Requests;

class FrontendController extends Controller {

    public function __construct() {
        $this->middleware('AuthMiBA', ['only' => ['callback']]);
        $this->middleware('XssSanitizer');
    }

    /**
     * Display index
     * @return type
     */
    public function index() {
        try {
            $url = explode("/", $_SERVER["REQUEST_URI"]);
            if (isset($url[1])) {
                if ($url[1] != 'en' || $url[1] == 'es') {
                    $lang = 'es';
                    $subtitle = " - Inicio";
                    $this->visits('Inicio');
                } else {
                    $lang = 'en';
                    $subtitle = "- Home";
                    $this->visits('Home');
                }
            } else {
                $lang = 'es';
                $subtitle = " - Inicio";
                $this->visits('Inicio');
            }
            $url_en = 'en';
            $url_es = 'es';
            $informations = Information::orderBy('position', 'asc')->get();
            $etapas = Widgets::where('category', '1')->orderBy('position', 'asc')->get();
            $beneficios = Widgets::where('category', '2')->orderBy('position', 'asc')->get();
            return view('frontend.home', ['subtitle' => $subtitle, 'lang' => $lang, 'url_en' => $url_en, 'url_es' => $url_es, 'informations' => $informations, 'etapas' => $etapas, 'beneficios' => $beneficios]);
        } catch (Exception $ex) {
            return false;
        }
        return false;
    }

    /**
     * Display sigin up
     * @return type
     */
    public function login(Request $request) {
        try {


            // if (!Session::has('miba')) {

            //     if (!Session::has('error_oic')) {

            //         $url = env('MIBA_AUTH');
            //         $url .= '?client_id=' . env('MIBA_CLIENT_ID');
            //         $url .= '&redirect_uri=' . env('APP_URL') . '/callback';
            //         $url .= '&response_type=code&scope=openid+profile+email+address+extra';
            //         return Redirect::to($url);
            //     } else {

            //         Session::forget('error_oic');
            //         Session::forget('miba');
            //         return view('errors.error_auth');
            //     }
            // } else {

                $get_menu = Menu::find(6);
                if (isset($get_menu) != 0) {

                    return Redirect::to($get_menu->url);
                }
            // }
        } catch (Exception $ex) {
            return false;
        }
        return false;
    }

    /**
     * Display logout
     * @return type
     */
    public function logout(Request $request) {
        try {
            // if (Session::has('miba')) {
            //     Session::forget('miba');
            // }
            // if (Session::has('error_oic')) {
            //     Session::forget('error_oic');
            // }
            // $url = env('MIBA_LOGOUT') . '' . env('APP_URL') + "/iniciar-sesion";
            // return Redirect::to($url);

            //agregado pipi
            $get_menu = Menu::find(6);
                if (isset($get_menu) != 0) {

                    return Redirect::to($get_menu->url);
                }
            //Fin agregado pipi
        } catch (Exception $ex) {
            return false;
        }
        return false;
    }

    /**
     * callback open id
     * @param Request $request
     * @param TokenStorage $storage
     * @return boolean
     * @throws TokenStorageException
     */
    public function callback(Request $request) {
        try {


            $code = $request->get('code');
            $http = new Client();


            $response = $http->post(env('MIBA_TOKEN'), [
                'form_params' => [
                    'grant_type' => 'authorization_code',
                    'client_id' => env('MIBA_CLIENT_ID'),
                    'client_secret' => env('MIBA_CLIENT_SECRET'),
                    'redirect_uri' => env('APP_URL') . '/callback',
                    'code' => $code,
                ],
            ]);


            $response = json_decode($response->getBody());


            if (isset($response->access_token)) {

                $profile = $http->request('GET', env('MIBA_PROFILE'), [
                    'headers' => [
                        'Authorization' => 'Bearer ' . $response->access_token,
                        'Accept' => 'application/json',
                    ],
                ]);

                $results = json_decode($profile->getBody());

                if (isset($results->name)) {

                    $name = '';
                    $last_name = '';
                    $dni = '';
                    $phone = '';

                    if (isset($results->first_name)) {

                        $name = $results->first_name;
                    }
                    if (isset($results->last_name)) {

                        $last_name = $results->last_name;
                    }
                    if (isset($results->document_number)) {

                        $dni = $results->document_number;
                    }
                    if (isset($results->phone)) {

                        $phone = $results->phone;
                    }

                    $request->session()->put('name', $name);
                    $request->session()->put('last_name', $last_name);
                    $request->session()->put('dni', $dni);
                    $request->session()->put('phone', $phone);

                    $get_menu = Menu::find(6);
                    if (isset($get_menu) != 0) {

                        return Redirect::to($get_menu->url);
                    }
                } else {

                    $request->session()->put('error_oic', '1');
                    return view('errors.error_auth');
                }
            } else {

                $request->session()->put('error_oic', '1');
                return view('errors.error_auth');
            }
        } catch (Exception $ex) {
            return false;
        }
    }

    /**
     * Display projects
     * @return type
     */
    public function projects() {
        try {
            $url = explode("/", $_SERVER["REQUEST_URI"]);
            if (isset($url[1])) {
                if ($url[1] != 'en' || $url[1] == 'es') {
                    $lang = 'es';
                    $menu = 'Proyectos';
                    $get_menu = Menu::find(1);
                    if (isset($get_menu) != 0) {
                        $menu = $get_menu->title;
                    }
                    $subtitle = " - " . $menu;
                } else {
                    $menu = 'Projects';
                    $get_menu = Menu::find(1);
                    if (isset($get_menu) != 0) {
                        $menu = $get_menu->title_en;
                    }
                    $lang = 'en';
                    $subtitle = "- " . $menu;
                }
            } else {
                $lang = 'es';
                $menu = 'Proyectos';
                $get_menu = Menu::find(1);
                if (isset($get_menu) != 0) {
                    $menu = $get_menu->title;
                }
                $subtitle = " - " . $menu;
            }
            $this->visits($menu);
            $url_en = $get_menu->url_en;
            $url_es = $get_menu->url;
            $categories = CategoriesProject::where('status', '1')->orderBy('position', 'asc')->get();
            $documents = Documents::orderby('id', 'desc')->get();
            $faqs = Faqs::orderBy('position', 'asc')->get();
            return view('frontend.projects', ['subtitle' => $subtitle, 'tab' => $menu, 'lang' => $lang, 'url_en' => $url_en, 'url_es' => $url_es, 'categories' => $categories, 'documents' => $documents, 'faqs' => $faqs]);
        } catch (Exception $ex) {
            return false;
        }
        return false;
    }

    /**
     * Display categories projects
     * @return type
     */
    public function categories_projects() {
        try {
            $url = explode("/", $_SERVER["REQUEST_URI"]);
            if (isset($url[1])) {
                if ($url[1] != 'en' || $url[1] == 'es') {
                    $get_category = CategoriesProject::where('url', $url[3])->first();
                    if (isset($get_category) != 0) {
                        $category = $get_category->name;
                    } else {
                        return view('errors/404');
                    }
                    $lang = 'es';
                    $menu = 'Proyectos';
                    $get_menu = Menu::find(1);
                    if (isset($get_menu) != 0) {
                        $menu = $get_menu->title;
                        $url_tab = url($get_menu->url);
                    }
                    $subtitle = " - " . $menu . " - " . $category;
                } else {
                    $get_category = CategoriesProject::where('url_en', $url[3])->first();
                    if (isset($get_category) != 0) {
                        $category = $get_category->name_en;
                    } else {
                        return view('errors/404');
                    }
                    $menu = 'Projects';
                    $get_menu = Menu::find(1);
                    if (isset($get_menu) != 0) {
                        $menu = $get_menu->title_en;
                        $url_tab = url($get_menu->url_en);
                    }
                    $lang = 'en';
                    $subtitle = " - " . $menu . " - " . $category;
                }
            } else {
                $lang = 'es';
                $get_category = CategoriesProject::where('url', $url[3])->first();
                if (isset($get_category) != 0) {
                    $category = $get_category->name;
                } else {
                    return view('errors/404');
                }
                $menu = 'Proyectos';
                $get_menu = Menu::find(1);
                if (isset($get_menu) != 0) {
                    $menu = $get_menu->title;
                    $url_tab = url($get_menu->url);
                }
                $subtitle = " - " . $menu . " - " . $category;
            }
            $this->visits($menu . '-' . $category);
            $url_en = 'en/projects/' . $get_category->url_en;
            $url_es = 'es/proyectos/' . $get_category->url;
            $categories = CategoriesProject::where('status', '1')->orderBy('position', 'asc')->get();
            $documents = Documents::orderby('id', 'desc')->get();
            $faqs = Faqs::orderBy('position', 'asc')->get();
            return view('frontend.projects_category', ['subtitle' => $subtitle, 'url_tab' => $url_tab, 'tab' => $menu, 'lang' => $lang, 'url_en' => $url_en, 'url_es' => $url_es, 'category' => $get_category, 'categories' => $categories, 'documents' => $documents, 'faqs' => $faqs]);
        } catch (Exception $ex) {
            return false;
        }
        return false;
    }

    /**
     * Display detail projects
     * @return type
     */
    public function view_projects() {
        try {
            $url = explode("/", $_SERVER["REQUEST_URI"]);
            if (isset($url[1])) {
                if ($url[1] != 'en' || $url[1] == 'es') {
                    $get_project = Project::where('url', $url[3])->first();
                    if (isset($get_project) != 0) {
                        $project = $get_project->title;
                        $title_ogg = $get_project->title;
                        $content_ogg = $get_project->resume;
                    } else {
                        return view('errors/404');
                    }
                    $lang = 'es';
                    $menu = 'Proyectos';
                    $get_menu = Menu::find(1);
                    if (isset($get_menu) != 0) {
                        $menu = $get_menu->title;
                        $url_tab = url($get_menu->url);
                    }
                    $subtitle = " - " . $menu . " - " . $project;
                } else {
                    $get_project = Project::where('url_en', $url[3])->first();
                    if (isset($get_project) != 0) {
                        $project = $get_project->title_en;
                        $title_ogg = $get_project->title_en;
                        $content_ogg = $get_project->resume_en;
                    } else {
                        return view('errors/404');
                    }
                    $menu = 'Projects';
                    $get_menu = Menu::find(1);
                    if (isset($get_menu) != 0) {
                        $menu = $get_menu->title_en;
                        $url_tab = url($get_menu->url_en);
                    }
                    $lang = 'en';
                    $subtitle = " - " . $menu . " - " . $project;
                }
            } else {
                $lang = 'es';
                $get_project = Project::where('url', $url[3])->first();
                if (isset($get_project) != 0) {
                    $project = $get_project->title;
                    $title_ogg = $get_project->title;
                    $content_ogg = $get_project->resume;
                } else {
                    return view('errors/404');
                }
                $menu = 'Proyectos';
                $get_menu = Menu::find(1);
                if (isset($get_menu) != 0) {
                    $menu = $get_menu->title;
                    $url_tab = url($get_menu->url);
                }
                $subtitle = " - " . $menu . " - " . $project;
            }
            $this->visits($menu . '-' . $project);
            $url_en = 'en/projects/' . $get_project->url_en;
            $url_es = 'es/proyectos/' . $get_project->url;
            return view('frontend.view_project', ['subtitle' => $subtitle, 'tab' => $menu, 'url_tab' => $url_tab, 'lang' => $lang, 'url_en' => $url_en, 'url_es' => $url_es, 'project' => $get_project, 'title_ogg' => $title_ogg, 'content_ogg' => $content_ogg]);
        } catch (Exception $ex) {
            return false;
        }
        return false;
    }

    /**
     * Display diary
     * @return type
     */
    public function diary() {
        try {
            $url = explode("/", $_SERVER["REQUEST_URI"]);
            if (isset($url[1])) {
                if ($url[1] != 'en' || $url[1] == 'es') {
                    $lang = 'es';
                    $menu = 'Agenda';
                    $get_menu = Menu::find(3);
                    if (isset($get_menu) != 0) {
                        $menu = $get_menu->title;
                    }
                    $subtitle = " - " . $menu;
                } else {
                    $menu = 'Diary';
                    $get_menu = Menu::find(3);
                    if (isset($get_menu) != 0) {
                        $menu = $get_menu->title_en;
                    }
                    $lang = 'en';
                    $subtitle = "- " . $menu;
                }
            } else {
                $lang = 'es';
                $menu = 'Agenda';
                $get_menu = Menu::find(3);
                if (isset($get_menu) != 0) {
                    $menu = $get_menu->title;
                }
                $subtitle = " - " . $menu;
            }
            $this->visits($menu);
            $url_en = $get_menu->url_en;
            $url_es = $get_menu->url;
            $categories = CategoriesEvent::where('status', '1')->orderBy('position', 'asc')->get();
            $i = 0;
            foreach ($categories as $rs) {
                $i = $i + 1;
                if ($i == 1) {
                    $id_category = "," . $rs->id;
                }
            }
            $dates = Event::select(DB::raw('DATE(start_date) as date'))->where('categories', 'like', '%' . $id_category . '%')->offset(0)->limit(10)->groupBy('date')->orderBy('position', 'asc')->get();

            return view('frontend.diary', ['subtitle' => $subtitle, 'tab' => $menu, 'lang' => $lang, 'url_en' => $url_en, 'url_es' => $url_es, 'categories' => $categories, 'dates' => $dates]);
        } catch (Exception $ex) {
            return false;
        }
        return false;
    }

    /**
     * Display categories diary
     * @return type
     */
    public function categories_diary() {
        try {
            $url = explode("/", $_SERVER["REQUEST_URI"]);
            if (isset($url[1])) {
                if ($url[1] != 'en' || $url[1] == 'es') {
                    $get_category = CategoriesEvent::where('url', $url[3])->first();
                    if (isset($get_category) != 0) {
                        $category = $get_category->name;
                    } else {
                        return view('errors/404');
                    }
                    $lang = 'es';
                    $menu = 'Agenda';
                    $get_menu = Menu::find(3);
                    if (isset($get_menu) != 0) {
                        $menu = $get_menu->title;
                        $url_tab = url($get_menu->url);
                    }
                    $subtitle = " - " . $menu . " - " . $category;
                } else {
                    $get_category = CategoriesEvent::where('url_en', $url[3])->first();
                    if (isset($get_category) != 0) {
                        $category = $get_category->name_en;
                    } else {
                        return view('errors/404');
                    }
                    $menu = 'Diary';
                    $get_menu = Menu::find(3);
                    if (isset($get_menu) != 0) {
                        $menu = $get_menu->title_en;
                        $url_tab = url($get_menu->url_en);
                    }
                    $lang = 'en';
                    $subtitle = " - " . $menu . " - " . $category;
                }
            } else {
                $lang = 'es';
                $get_category = CategoriesEvent::where('url', $url[3])->first();
                if (isset($get_category) != 0) {
                    $category = $get_category->name;
                } else {
                    return view('errors/404');
                }
                $menu = 'Agenda';
                $get_menu = Menu::find(3);
                if (isset($get_menu) != 0) {
                    $menu = $get_menu->title;
                    $url_tab = url($get_menu->url);
                }
                $subtitle = " - " . $menu . " - " . $category;
            }
            $this->visits($menu . '-' . $category);
            $url_en = 'en/agenda/' . $get_category->url_en;
            $url_es = 'es/diary/' . $get_category->url;
            $categories = CategoriesEvent::where('status', '1')->orderBy('position', 'asc')->get();
            $id_category = ',' . $get_category->id;
            $dates = Event::select(DB::raw('DATE(start_date) as date'))->offset(0)->limit(10)->groupBy('date')->orderBy('position', 'asc')->get();
            return view('frontend.diary_category', ['subtitle' => $subtitle, 'tab' => $menu, 'url_tab' => $url_tab, 'lang' => $lang, 'url_en' => $url_en, 'url_es' => $url_es, 'category' => $get_category, 'categories' => $categories, 'dates' => $dates]);
        } catch (Exception $ex) {
            return false;
        }
        return false;
    }

    /**
     * Display detail diary
     * @return type
     */
    public function view_diary() {
        try {
            $url = explode("/", $_SERVER["REQUEST_URI"]);
            if (isset($url[1])) {
                if ($url[1] != 'en' || $url[1] == 'es') {
                    $get_diary = Event::where('url', $url[3])->first();
                    if (isset($get_diary) != 0) {
                        $diary = $get_diary->title;
                        $title_ogg = $get_diary->title;
                        $content_ogg = $get_diary->resume;
                    } else {
                        return view('errors/404');
                    }
                    $lang = 'es';
                    $menu = 'Agenda';
                    $get_menu = Menu::find(3);
                    if (isset($get_menu) != 0) {
                        $menu = $get_menu->title;
                        $url_tab = url($get_menu->url);
                    }
                    $subtitle = " - " . $menu . " - " . $diary;
                } else {
                    $get_diary = Event::where('url_en', $url[3])->first();
                    if (isset($get_diary) != 0) {
                        $diary = $get_diary->title_en;
                        $title_ogg = $get_diary->title_en;
                        $content_ogg = $get_diary->resume_en;
                    } else {
                        return view('errors/404');
                    }
                    $menu = 'Diary';
                    $get_menu = Menu::find(3);
                    if (isset($get_menu) != 0) {
                        $menu = $get_menu->title_en;
                        $url_tab = url($get_menu->url_en);
                    }
                    $lang = 'en';
                    $subtitle = " - " . $menu . " - " . $diary;
                }
            } else {
                $lang = 'es';
                $get_diary = Event::where('url', $url[3])->first();
                if (isset($get_diary) != 0) {
                    $diary = $get_diary->title;
                    $title_ogg = $get_diary->title;
                    $content_ogg = $get_diary->resume;
                } else {
                    return view('errors/404');
                }
                $menu = 'Agenda';
                $get_menu = Menu::find(3);
                if (isset($get_menu) != 0) {
                    $menu = $get_menu->title;
                    $url_tab = url($get_menu->url);
                }
                $subtitle = " - " . $menu . " - " . $diary;
            }
            $this->visits($menu . '-' . $diary);
            $url_en = 'en/diary/' . $get_diary->url_en;
            $url_es = 'es/agenda/' . $get_diary->url;
            return view('frontend.view_diary', ['subtitle' => $subtitle, 'url_tab' => $url_tab, 'tab' => $menu, 'lang' => $lang, 'url_en' => $url_en, 'url_es' => $url_es, 'diary' => $get_diary, 'title_ogg' => $title_ogg, 'content_ogg' => $content_ogg]);
        } catch (Exception $ex) {
            return false;
        }
        return false;
    }

    /**
     * Display news
     * @return type
     */
    public function news() {
        try {
            $url = explode("/", $_SERVER["REQUEST_URI"]);
            if (isset($url[1])) {
                if ($url[1] != 'en' || $url[1] == 'es') {
                    $lang = 'es';
                    $menu = 'Noticias';
                    $get_menu = Menu::find(2);
                    if (isset($get_menu) != 0) {
                        $menu = $get_menu->title;
                    }
                    $subtitle = " - " . $menu;
                } else {
                    $menu = 'News';
                    $get_menu = Menu::find(2);
                    if (isset($get_menu) != 0) {
                        $menu = $get_menu->title_en;
                    }
                    $lang = 'en';
                    $subtitle = "- " . $menu;
                }
            } else {
                $lang = 'es';
                $menu = 'Noticias';
                $get_menu = Menu::find(2);
                if (isset($get_menu) != 0) {
                    $menu = $get_menu->title;
                }
                $subtitle = " - " . $menu;
            }
            $this->visits($menu);
            $url_en = $get_menu->url_en;
            $url_es = $get_menu->url;
            return view('frontend.news', ['subtitle' => $subtitle, 'tab' => $menu, 'lang' => $lang, 'url_en' => $url_en, 'url_es' => $url_es]);
        } catch (Exception $ex) {
            return false;
        }
        return false;
    }

    /**
     * Display categories news
     * @return type
     */
    public function categories_news() {
        try {
            $url = explode("/", $_SERVER["REQUEST_URI"]);
            if (isset($url[1])) {
                if ($url[1] != 'en' || $url[1] == 'es') {
                    $get_category = CategoriesPost::where('url', $url[3])->first();
                    if (isset($get_category) != 0) {
                        $category = $get_category->name;
                    } else {
                        return view('errors/404');
                    }
                    $lang = 'es';
                    $menu = 'Noticias';
                    $get_menu = Menu::find(2);
                    if (isset($get_menu) != 0) {
                        $menu = $get_menu->title;
                        $url_tab = url($get_menu->url);
                    }
                    $subtitle = " - " . $menu . " - " . $category;
                } else {
                    $get_category = CategoriesPost::where('url_en', $url[3])->first();
                    if (isset($get_category) != 0) {
                        $category = $get_category->name_en;
                    } else {
                        return view('errors/404');
                    }
                    $menu = 'News';
                    $get_menu = Menu::find(2);
                    if (isset($get_menu) != 0) {
                        $menu = $get_menu->title_en;
                        $url_tab = url($get_menu->url_en);
                    }
                    $lang = 'en';
                    $subtitle = " - " . $menu . " - " . $category;
                }
            } else {
                $lang = 'es';
                $get_category = CategoriesPost::where('url', $url[3])->first();
                if (isset($get_category) != 0) {
                    $category = $get_category->name;
                } else {
                    return view('errors/404');
                }
                $menu = 'Noticias';
                $get_menu = Menu::find(2);
                if (isset($get_menu) != 0) {
                    $menu = $get_menu->title;
                    $url_tab = url($get_menu->url);
                }
                $subtitle = " - " . $menu . " - " . $category;
            }
            $this->visits($menu . '-' . $category);
            $url_en = 'en/news/' . $get_category->url_en;
            $url_es = 'es/noticias/' . $get_category->url;
            return view('frontend.news_category', ['subtitle' => $subtitle, 'url_tab' => $url_tab, 'tab' => $menu, 'lang' => $lang, 'url_en' => $url_en, 'url_es' => $url_es, 'category' => $get_category]);
        } catch (Exception $ex) {
            return false;
        }
        return false;
    }

    /**
     * Display detail news
     * @return type
     */
    public function view_news() {
        try {
            $url = explode("/", $_SERVER["REQUEST_URI"]);
            if (isset($url[1])) {
                if ($url[1] != 'en' || $url[1] == 'es') {
                    $get_new = Post::where('url', $url[3])->first();
                    if (isset($get_new) != 0) {
                        $new = $get_new->title;
                        $title_ogg = $get_new->title;
                        $content_ogg = $get_new->resume;
                    } else {
                        return view('errors/404');
                    }
                    $lang = 'es';
                    $menu = 'Noticias';
                    $get_menu = Menu::find(2);
                    if (isset($get_menu) != 0) {
                        $menu = $get_menu->title;
                        $url_tab = url($get_menu->url);
                    }
                    $subtitle = " - " . $menu . " - " . $new;
                } else {
                    $get_new = Post::where('url_en', $url[3])->first();
                    if (isset($get_new) != 0) {
                        $new = $get_new->title_en;
                        $title_ogg = $get_new->title_en;
                        $content_ogg = $get_new->resume_en;
                    } else {
                        return view('errors/404');
                    }
                    $menu = 'News';
                    $get_menu = Menu::find(2);
                    if (isset($get_menu) != 0) {
                        $menu = $get_menu->title_en;
                        $url_tab = url($get_menu->url_en);
                    }
                    $lang = 'en';
                    $subtitle = " - " . $menu . " - " . $new;
                }
            } else {
                $lang = 'es';
                $get_new = Post::where('url', $url[3])->first();
                if (isset($get_new) != 0) {
                    $new = $get_new->title;
                    $title_ogg = $get_new->title;
                    $content_ogg = $get_new->resume;
                } else {
                    return view('errors/404');
                }
                $menu = 'Noticias';
                $get_menu = Menu::find(2);
                if (isset($get_menu) != 0) {
                    $menu = $get_menu->title;
                    $url_tab = url($get_menu->url);
                }
                $subtitle = " - " . $menu . " - " . $new;
            }
            $this->visits($menu . '-' . $new);
            $url_en = 'en/news/' . $get_new->url_en;
            $url_es = 'es/noticias/' . $get_new->url;
            return view('frontend.view_new', ['subtitle' => $subtitle, 'tab' => $menu, 'url_tab' => $url_tab, 'lang' => $lang, 'url_en' => $url_en, 'url_es' => $url_es, 'new' => $get_new, 'title_ogg' => $title_ogg, 'content_ogg' => $content_ogg]);
        } catch (Exception $ex) {
            return false;
        }
        return false;
    }

    /**
     * Display presentations
     * @return type
     */
    public function presentations() {
        try {
            // if (!Session::has('miba')) {

                // return redirect('iniciar-sesion');
            // } else {
                $url = explode("/", $_SERVER["REQUEST_URI"]);
                if (isset($url[1])) {
                    if ($url[1] != 'en' || $url[1] == 'es') {
                        $lang = 'es';
                        $menu = 'Presentación de proyectos';
                        $get_menu = Menu::find(6);
                        if (isset($get_menu) != 0) {
                            $menu = $get_menu->title;
                        }
                        $subtitle = " - " . $menu;
                    } else {
                        $menu = 'Presentation of projects';
                        $get_menu = Menu::find(6);
                        if (isset($get_menu) != 0) {
                            $menu = $get_menu->title_en;
                        }
                        $lang = 'en';
                        $subtitle = "- " . $menu;
                    }
                } else {
                    $lang = 'es';
                    $menu = 'Presentación de proyectos';
                    $get_menu = Menu::find(6);
                    if (isset($get_menu) != 0) {
                        $menu = $get_menu->title;
                    }
                    $subtitle = " - " . $menu;
                }
                $this->visits($menu);
                $url_en = $get_menu->url_en;
                $url_es = $get_menu->url;
                $person = Person::where('status', '1')->orderBy('position', 'asc')->get();
                $categories = CategoriesJob::where('status', '1')->orderBy('position', 'asc')->get();
                $state = State::where('status', '1')->orderBy('position', 'asc')->get();
                $dedicated = Dedicated::where('status', '1')->orderBy('position', 'asc')->get();
                $interest = Interest::where('status', '1')->orderBy('position', 'asc')->get();
                $member = Members::where('status', '1')->orderBy('position', 'asc')->get();
                $name = Session::get('name');
                $last_name = Session::get('last_name');
                $dni = Session::get('dni');
                $phone = Session::get('phone');

                return view('frontend.presentations', ['subtitle' => $subtitle, 'tab' => $menu, 'lang' => $lang, 'url_en' => $url_en, 'url_es' => $url_es, 'person' => $person, 'categories' => $categories, 'state' => $state, 'dedicated' => $dedicated, 'interest' => $interest, 'member' => $member, 'name' => $name, 'last_name' => $last_name, 'phone' => $phone, 'dni' => $dni]);
            // }
        } catch (Exception $ex) {
            return false;
        }
        return false;
    }

    /**
     * Display contact
     * @return type
     */
    public function contact() {
        try {
            $url = explode("/", $_SERVER["REQUEST_URI"]);
            if (isset($url[1])) {
                if ($url[1] != 'en' || $url[1] == 'es') {
                    $lang = 'es';
                    $menu = 'Contacto';
                    $get_menu = Menu::find(5);
                    if (isset($get_menu) != 0) {
                        $menu = $get_menu->title;
                    }
                    $subtitle = " - " . $menu;
                } else {
                    $menu = 'Contact';
                    $get_menu = Menu::find(5);
                    if (isset($get_menu) != 0) {
                        $menu = $get_menu->title_en;
                    }
                    $lang = 'en';
                    $subtitle = "- " . $menu;
                }
            } else {
                $lang = 'es';
                $menu = 'Contacto';
                $get_menu = Menu::find(5);
                if (isset($get_menu) != 0) {
                    $menu = $get_menu->title;
                }
                $subtitle = " - " . $menu;
            }
            $this->visits($menu);
            $url_en = $get_menu->url_en;
            $url_es = $get_menu->url;
            return view('frontend.contact', ['subtitle' => $subtitle, 'tab' => $menu, 'lang' => $lang, 'url_en' => $url_en, 'url_es' => $url_es]);
        } catch (Exception $ex) {
            return false;
        }
        return false;
    }

    /**
     * Display mentor
     * @return type
     */
    public function mentor() {
        try {
            $url = explode("/", $_SERVER["REQUEST_URI"]);
            if (isset($url[1])) {
                if ($url[1] != 'en' || $url[1] == 'es') {
                    $lang = 'es';
                    $menu = 'Mentores';
                    $get_menu = Menu::find(4);
                    if (isset($get_menu) != 0) {
                        $menu = $get_menu->title;
                    }
                    $subtitle = " - " . $menu;
                } else {
                    $menu = 'Mentors';
                    $get_menu = Menu::find(4);
                    if (isset($get_menu) != 0) {
                        $menu = $get_menu->title_en;
                    }
                    $lang = 'en';
                    $subtitle = "- " . $menu;
                }
            } else {
                $lang = 'es';
                $menu = 'Mentores';
                $get_menu = Menu::find(4);
                if (isset($get_menu) != 0) {
                    $menu = $get_menu->title;
                }
                $subtitle = " - " . $menu;
            }
            $this->visits($menu);
            $url_en = $get_menu->url_en;
            $url_es = $get_menu->url;
            $faqs = Faqs::orderBy('position', 'asc')->get();
            $categories = CategoriesMentors::where('status', '1')->orderBy('position', 'asc')->get();
            return view('frontend.mentor', ['subtitle' => $subtitle, 'lang' => $lang, 'url_en' => $url_en, 'url_es' => $url_es, 'tab' => $menu, 'categories' => $categories]);
        } catch (Exception $ex) {
            return false;
        }
        return false;
    }

    /**
     * Display categories mentors
     * @return type
     */
    public function categories_mentors() {
        try {
            $url = explode("/", $_SERVER["REQUEST_URI"]);
            if (isset($url[1])) {
                if ($url[1] != 'en' || $url[1] == 'es') {
                    $get_category = CategoriesMentors::where('url', $url[3])->first();
                    if (isset($get_category) != 0) {
                        $category = $get_category->name;
                    } else {
                        return view('errors/404');
                    }
                    $lang = 'es';
                    $menu = 'Mentores';
                    $get_menu = Menu::find(4);
                    if (isset($get_menu) != 0) {
                        $menu = $get_menu->title;
                        $url_tab = url($get_menu->url);
                    }
                    $subtitle = " - " . $menu . " - " . $category;
                } else {
                    $get_category = CategoriesMentors::where('url_en', $url[3])->first();
                    if (isset($get_category) != 0) {
                        $category = $get_category->name_en;
                    } else {
                        return view('errors/404');
                    }
                    $menu = 'Mentors';
                    $get_menu = Menu::find(4);
                    if (isset($get_menu) != 0) {
                        $menu = $get_menu->title_en;
                        $url_tab = url($get_menu->url_en);
                    }
                    $lang = 'en';
                    $subtitle = " - " . $menu . " - " . $category;
                }
            } else {
                $lang = 'es';
                $get_category = CategoriesMentors::where('url', $url[3])->first();
                if (isset($get_category) != 0) {
                    $category = $get_category->name;
                } else {
                    return view('errors/404');
                }
                $menu = 'Mentores';
                $get_menu = Menu::find(4);
                if (isset($get_menu) != 0) {
                    $menu = $get_menu->title;
                    $url_tab = url($get_menu->url);
                }
                $subtitle = " - " . $menu . " - " . $category;
            }
            $this->visits($menu . '-' . $category);
            $url_en = 'en/mentors/' . $get_category->url_en;
            $url_es = 'es/mentores/' . $get_category->url;
            $categories = CategoriesMentors::where('status', '1')->orderBy('position', 'asc')->get();
            $documents = Documents::orderby('id', 'desc')->get();
            $faqs = Faqs::orderBy('position', 'asc')->get();
            return view('frontend.mentors_category', ['subtitle' => $subtitle, 'url_tab' => $url_tab, 'tab' => $menu, 'lang' => $lang, 'url_en' => $url_en, 'url_es' => $url_es, 'category' => $get_category, 'categories' => $categories, 'documents' => $documents, 'faqs' => $faqs]);
        } catch (Exception $ex) {
            return false;
        }
        return false;
    }

    /**
     * Display search
     * @return type
     */
    public function search() {
        try {
            $url = explode("/", $_SERVER["REQUEST_URI"]);
            if (isset($url[1])) {
                if ($url[1] != 'en' || $url[1] == 'es') {
                    $lang = 'es';
                    $subtitle = " - Búsqueda";
                    $this->visits('Búsqueda');
                } else {
                    $lang = 'en';
                    $subtitle = "- Search";
                    $this->visits('Search');
                }
            } else {
                $lang = 'es';
                $subtitle = " - Búsqueda";
                $this->visits('Búsqueda');
            }
            $url_en = 'en/search?q=' . $_REQUEST['q'];
            $url_es = 'es/busqueda?q=' . $_REQUEST['q'];
            $search = trim($_REQUEST['q']);
            $search = str_replace('-', ' ', $search);
            if (!isset($_REQUEST['q']) || $_REQUEST['q']=="" || strlen($search)<3) {
                if ($lang == 'es') {
                    return Redirect::to('/');
                } else {
                    return Redirect::to('en');
                }
            } else {

                return view('frontend.search', ['subtitle' => $subtitle, 'lang' => $lang, 'url_en' => $url_en, 'url_es' => $url_es, 'search' => $search]);
            }
        } catch (Exception $ex) {
            return false;
        }
        return false;
    }

    public function store_project(Request $request) {
        try {

            $isHuman = $this->validate_captcha_google($request['captcha']);
            if ($request['captcha'] == '') {
                return response()->json(["response" => "no-catpcha"]);
            }
            if ($isHuman) {

                $path = $_SERVER['DOCUMENT_ROOT'] . "/images/";
                $archive = '';
                $interest = '';
                if (!empty($request['interest'])) {
                    foreach ($request['interest'] as $selected) {
                        $interest .= $selected . ',';
                    }
                }
                foreach ($_FILES["archive"]['tmp_name'] as $key => $tmp_name) {
                    if ($_FILES["archive"]["name"][$key]) {
                        $filename = $_FILES["archive"]["name"][$key];
                        $source = $_FILES["archive"]["tmp_name"][$key];
                        $upload = $path . $filename;
                        move_uploaded_file($source, $upload);
                        $name = explode('.', $filename);
                        $name = strtolower($name[0]);
                        $name = mb_strtolower($name, 'UTF-8');
                        $name = str_replace('á', 'a', $name);
                        $name = str_replace('é', 'e', $name);
                        $name = str_replace('í', 'i', $name);
                        $name = str_replace('ó', 'o', $name);
                        $name = str_replace('ú;', 'u', $name);
                        $name = str_replace('ñ', 'n', $name);
                        $name = preg_replace('([^A-Za-z0-9])', '', $name);
                        $name = str_replace('-', '_', $name);
                        $name = str_replace(' ', '_', $name);
                        $type = strtolower(strrchr($filename, "."));
                        $pic_new = $name . "_" . time() . $type;
                        $upload_new = $path . $pic_new;
                        rename($upload, $upload_new);
                        $archive .= $pic_new . ',';
                    }
                }
                Presentations::create([
                    'name' => $request['name'],
                    'last_name' => $request['last_name'],
                    'email' => $request['email'],
                    "dni" => $request['dni'],
                    "phone" => $request['phone'],
                    "project_name" => $request['project_name'],
                    "website" => $request['website'],
                    "category" => $request['category'],
                    "state" => $request['state'],
                    "dedicated" => $request['dedicated'],
                    "members" => $request['members'],
                    "interest" => $interest,
                    "person" => $request['person'],
                    "video" => $request['video'],
                    'description' => $request['description'],
                    "documents" => $archive
                ]);
                $content = 'Hola, Administrador Incubate.<br/>
        <br/>
        Le informamos a través de este correo electrónico que tiene una nueva presentación de proyecto por revisar. Los datos que hemos recibido son los siguientes:<br />
        <br />
        <strong>Nombre y Apellido:</strong>  ' . $request['name'] . '' . $request['last_name'] . '<br/>
        <strong>Correo electrónico:</strong>  ' . $request['email'] . '<br/>
        <strong>Teléfono:</strong>  ' . $request['phone'] . '<br/>
        <strong>Nombre del emprendimiento:</strong>  ' . $request['project_name'] . '<br/>';
                $title = "Nueva Presentación";
                $site = DB::table('site')->where('id', '1')->first();
                Mail::to($site->email, $site->name)->send(new BAMail($title, $content));
                return response()->json(["msg" => "Contacto Enviado"]);
            }
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
     * Get Type Device
     * @return string
     */
    public function getTypedevice() {
        try {
            $tablet_browser = 0;
            $mobile_browser = 0;
            $body_class = 'desktop';
            if (preg_match('/(tablet|ipad|playbook)|(android(?!.*(mobi|opera mini)))/i', strtolower($_SERVER['HTTP_USER_AGENT']))) {
                $tablet_browser++;
                $body_class = "tablet";
            }
            if (preg_match('/(up.browser|up.link|mmp|symbian|smartphone|midp|wap|phone|android|iemobile)/i', strtolower($_SERVER['HTTP_USER_AGENT']))) {
                $mobile_browser++;
                $body_class = "mobile";
            }
            if (isset($_SERVER['HTTP_ACCEPT'])) {
                if ((strpos(strtolower($_SERVER['HTTP_ACCEPT']), 'application/vnd.wap.xhtml+xml') > 0) or ( (isset($_SERVER['HTTP_X_WAP_PROFILE']) or isset($_SERVER['HTTP_PROFILE'])))) {
                    $mobile_browser++;
                    $body_class = "mobile";
                }
            }
            $mobile_ua = strtolower(substr($_SERVER['HTTP_USER_AGENT'], 0, 4));
            $mobile_agents = array(
                'w3c ', 'acs-', 'alav', 'alca', 'amoi', 'audi', 'avan', 'benq', 'bird', 'blac',
                'blaz', 'brew', 'cell', 'cldc', 'cmd-', 'dang', 'doco', 'eric', 'hipt', 'inno',
                'ipaq', 'java', 'jigs', 'kddi', 'keji', 'leno', 'lg-c', 'lg-d', 'lg-g', 'lge-',
                'maui', 'maxo', 'midp', 'mits', 'mmef', 'mobi', 'mot-', 'moto', 'mwbp', 'nec-',
                'newt', 'noki', 'palm', 'pana', 'pant', 'phil', 'play', 'port', 'prox',
                'qwap', 'sage', 'sams', 'sany', 'sch-', 'sec-', 'send', 'seri', 'sgh-', 'shar',
                'sie-', 'siem', 'smal', 'smar', 'sony', 'sph-', 'symb', 't-mo', 'teli', 'tim-',
                'tosh', 'tsm-', 'upg1', 'upsi', 'vk-v', 'voda', 'wap-', 'wapa', 'wapi', 'wapp',
                'wapr', 'webc', 'winw', 'winw', 'xda ', 'xda-');
            if (in_array($mobile_ua, $mobile_agents)) {
                $mobile_browser++;
            }
            if (strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'opera mini') > 0) {
                $mobile_browser++;
                $stock_ua = strtolower(isset($_SERVER['HTTP_X_OPERAMINI_PHONE_UA']) ? $_SERVER['HTTP_X_OPERAMINI_PHONE_UA'] : (isset($_SERVER['HTTP_DEVICE_STOCK_UA']) ? $_SERVER['HTTP_DEVICE_STOCK_UA'] : ''));
                if (preg_match('/(tablet|ipad|playbook)|(android(?!.*mobile))/i', $stock_ua)) {
                    $tablet_browser++;
                }
            }
            if ($tablet_browser > 0) {
                return '3';
            } else if ($mobile_browser > 0) {
                return '2';
            } else {
                return '1';
            }
        } catch (Exception $ex) {
            return false;
        }
        return false;
    }

    public function getDay($day) {
        try {
            if ($day == '0') {
                return 'Domingo';
            }
            if ($day == '1') {
                return 'Lunes';
            }
            if ($day == '2') {
                return 'Martes';
            }
            if ($day == '3') {
                return 'Miércoles';
            }
            if ($day == '4') {
                return 'Jueves';
            }
            if ($day == '5') {
                return 'Viernes';
            }
            if ($day == '6') {
                return 'Sábado';
            }
        } catch (Exception $ex) {
            return false;
        }
        return false;
    }

    public function getCodeLocation($ip) {
        try {
            $code = 'Buenos Aires F.D.';
            return $code;
        } catch (Exception $ex) {
            return false;
        }
        return false;
    }

    public function getNameLocation($ip) {
        try {
            $name = 'Buenos Aires';
            return $name;
        } catch (Exception $ex) {
            return false;
        }
        return false;
    }

    public function visits($page) {
        try {
            $visit = Visits::where('page', $page)->where('ip', $this->getIp())->where('date', date("Y-m-d"))->get();
            if (count($visit) == 0) {
                Visits::create([
                    'page' => $page,
                    'ip' => $this->getIp(),
                    'device' => $this->getTypedevice(),
                    'code' => $this->getCodeLocation($this->getIp()),
                    'name' => $this->getNameLocation($this->getIp()),
                    'date' => date("Y-m-d"),
                    'year' => date("Y"),
                    'month' => date("m"),
                    'hour' => date("H") . ':00:00',
                    'day' => date("w"),
                    'name_day' => $this->getDay(date("w"))
                ]);
            }
        } catch (Exception $ex) {
            return false;
        }
        return false;
    }

    function download($fileName) {

        try {

            $filePath = $_SERVER['DOCUMENT_ROOT'] . "/images/" . $fileName;
            if (!empty($fileName) && file_exists($filePath)) {
                // Define headers
                header("Cache-Control: public");
                header("Content-Description: File Transfer");
                header("Content-Disposition: attachment; filename=$fileName");
                header("Content-Type: application/zip");
                header("Content-Transfer-Encoding: binary");

                // Read the file
                readfile($filePath);
                exit;
            } else {
                exit;
            }
        } catch (Exception $ex) {
            return false;
        }
        return false;
    }

    public function validate_captcha_google($token) {


        try {


            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "https://www.google.com/recaptcha/api/siteverify");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(array('secret' => env('CAPTCHA_KEY_SECRET'), 'response' => $token)));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($ch);
            curl_close($ch);
            $arrResponse = json_decode($response, true);


            if ($arrResponse["success"] == '1' && $arrResponse["action"] == 'homepage' && $arrResponse["score"] >= 0.5) {
                return true;
            } else {
                return false;
            }
        } catch (Exception $ex) {
            return false;
        }
        return false;
    }

}
