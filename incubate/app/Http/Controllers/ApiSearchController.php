<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Event;
use App\Menu;
use App\Project;
use App\Post;
use App\Faqs;
use Auth;
use App\Http\Requests;

class ApiSearchController extends Controller {

    /**
     * Validate access
     */
    public function __construct() {
        $this->middleware('AuthApi');
    }

    /**
     * Show event
     * @return type
     */
    public function lists($lang, $search, $date, $type) {
        try {
            $items = array();
            $content = array();
            if ($date == '0') {
                $date = '';
            }
            if ($lang == 'es') {
                if ($type == '1' || $type == 'all') {
                    $event = Event::
                            orWhere('title', 'like', '%' . $search . '%')
                            ->orWhere('resume', 'like', '%' . $search . '%')
                            ->orWhere('content', 'like', '%' . $search . '%')
                            ->orderBy('start_date', 'asc')
                            ->get();
                    if (count($event) != 0) {
                        $menu = 'Agenda';
                        $get_menu = Menu::find(3);
                        if (isset($get_menu) != 0) {
                            $menu = $get_menu->title;
                        }
                        if ($date != '') {
                            $row = 0;
                            foreach ($event as $rs):
                                if (date("Y-m-d", strtotime($date)) == date("Y-m-d", strtotime($rs->start_date))) {
                                    $row = $row + 1;
                                    $items[] = array(
                                        "title" => $rs->title,
                                        "content" => $rs->resume,
                                        "url" => "es/agenda/" . $rs->url
                                    );
                                }
                            endforeach;
                            if ($row != 0) {
                                $content[] = array(
                                    "id" => '1',
                                    "title" => $menu,
                                    "total" => $row
                                );
                            }
                        } else {
                            foreach ($event as $rs):
                                $items[] = array(
                                    "title" => $rs->title,
                                    "content" => $rs->resume,
                                    "url" => "es/agenda/" . $rs->url
                                );
                            endforeach;
                            $content[] = array(
                                "id" => '1',
                                "title" => $menu,
                                "total" => count($event)
                            );
                        }
                    }
                }
                if ($type == '2' || $type == 'all') {
                    $projects = Project::
                            orWhere('title', 'like', '%' . $search . '%')
                            ->orWhere('resume', 'like', '%' . $search . '%')
                            ->orWhere('content', 'like', '%' . $search . '%')
                            ->orderBy('created_at', 'asc')
                            ->get();
                    if (count($projects) != 0) {
                        $menu = 'Proyectos';
                        $get_menu = Menu::find(1);
                        if (isset($get_menu) != 0) {
                            $menu = $get_menu->title;
                        }
                        if ($date != '') {
                            $row = 0;
                            foreach ($projects as $rs):
                                if (date("Y-m-d", strtotime($date)) == date("Y-m-d", strtotime($rs->created_at))) {
                                    $row = $row + 1;
                                    $items[] = array(
                                        "title" => $rs->title,
                                        "content" => $rs->resume,
                                        "url" => "es/proyectos/" . $rs->url
                                    );
                                }
                            endforeach;
                            if ($row != 0) {
                                $content[] = array(
                                    "id" => '2',
                                    "title" => $menu,
                                    "total" => $row
                                );
                            }
                        } else {
                            $content[] = array(
                                "id" => '2',
                                "title" => $menu,
                                "total" => count($projects)
                            );
                            foreach ($projects as $rs):
                                $items[] = array(
                                    "title" => $rs->title,
                                    "content" => $rs->resume,
                                    "url" => "es/proyectos/" . $rs->url
                                );
                            endforeach;
                        }
                    }
                }
                if ($type == '3' || $type == 'all') {
                    $posts = Post::
                            orWhere('title', 'like', '%' . $search . '%')
                            ->orWhere('resume', 'like', '%' . $search . '%')
                            ->orWhere('content', 'like', '%' . $search . '%')
                            ->orderBy('created_at', 'asc')
                            ->get();
                    if (count($posts) != 0) {
                        $menu = 'Noticias';
                        $get_menu = Menu::find(2);
                        if (isset($get_menu) != 0) {
                            $menu = $get_menu->title;
                        }
                        if ($date != '') {
                            $row = 0;
                            foreach ($posts as $rs):
                                if (date("Y-m-d", strtotime($date)) == date("Y-m-d", strtotime($rs->created_at))) {
                                    $row = $row + 1;
                                    $items[] = array(
                                        "title" => $rs->title,
                                        "content" => $rs->resume,
                                        "url" => "es/noticias/" . $rs->url
                                    );
                                }
                            endforeach;
                            if ($row != 0) {
                                $content[] = array(
                                    "id" => '3',
                                    "title" => $menu,
                                    "total" => $row
                                );
                            }
                        } else {
                            $content[] = array(
                                "id" => '3',
                                "title" => $menu,
                                "total" => count($posts)
                            );
                            foreach ($posts as $rs):
                                $items[] = array(
                                    "title" => $rs->title,
                                    "content" => $rs->resume,
                                    "url" => "es/noticias/" . $rs->url
                                );
                            endforeach;
                        }
                    }
                }
                if ($type == '4' || $type == 'all') {
                    $faq = Faqs::
                            orWhere('title', 'like', '%' . $search . '%')
                            ->orWhere('content', 'like', '%' . $search . '%')
                            ->orderBy('created_at', 'asc')
                            ->get();
                    if (count($faq) != 0) {
                        $menu = 'Preguntas Frecuentes';
                        $get_menu = Menu::find(4);
                        if (isset($get_menu) != 0) {
                            $menu = $get_menu->title;
                        }
                        if ($date != '') {
                            $row = 0;
                            foreach ($faq as $rs):
                                if (date("Y-m-d", strtotime($date)) == date("Y-m-d", strtotime($rs->created_at))) {
                                    $row = $row + 1;
                                    $items[] = array(
                                        "title" => $rs->title,
                                        "content" => '',
                                        "url" => "es/preguntas-frecuentes#" . $rs->url
                                    );
                                }
                            endforeach;

                            if ($row != 0) {
                                $content[] = array(
                                    "id" => '4',
                                    "title" => $menu,
                                    "total" => $row
                                );
                            }
                        } else {
                            $content[] = array(
                                "id" => '4',
                                "title" => $menu,
                                "total" => count($faq)
                            );
                            foreach ($faq as $rs):
                                $items[] = array(
                                    "title" => $rs->title,
                                    "content" => '',
                                    "url" => "es/preguntas-frecuentes#" . $rs->url
                                );
                            endforeach;
                        }
                    }
                }
            } else {

                if ($type == '1' || $type == 'all') {
                    $event = Event::
                            orWhere('title_en', 'like', '%' . $search . '%')
                            ->orWhere('resume_en', 'like', '%' . $search . '%')
                            ->orWhere('content_en', 'like', '%' . $search . '%')
                            ->orderBy('start_date', 'asc')
                            ->get();
                    if (count($event) != 0) {
                        $menu = 'Diary';
                        $get_menu = Menu::find(3);
                        if (isset($get_menu) != 0) {
                            $menu = $get_menu->title_en;
                        }
                        if ($date != '') {
                            $row = 0;
                            foreach ($event as $rs):
                                if (date("Y-m-d", strtotime($date)) == date("Y-m-d", strtotime($rs->start_date))) {
                                    $row = $row + 1;
                                    $items[] = array(
                                        "title" => $rs->title_en,
                                        "content" => $rs->resume_en,
                                        "url" => "en/diary/" . $rs->url_en
                                    );
                                }
                            endforeach;
                            if ($row != 0) {
                                $content[] = array(
                                    "id" => '1',
                                    "title" => $menu,
                                    "total" => $row
                                );
                            }
                        } else {
                            foreach ($event as $rs):
                                $items[] = array(
                                    "title" => $rs->title_en,
                                    "content" => $rs->resume_en,
                                    "url" => "en/diary/" . $rs->url_en
                                );
                            endforeach;
                            $content[] = array(
                                "id" => '1',
                                "title" => $menu,
                                "total" => count($event)
                            );
                        }
                    }
                }
                if ($type == '2' || $type == 'all') {
                    $projects = Project::
                            orWhere('title_en', 'like', '%' . $search . '%')
                            ->orWhere('resume_en', 'like', '%' . $search . '%')
                            ->orWhere('content_en', 'like', '%' . $search . '%')
                            ->orderBy('created_at', 'asc')
                            ->get();
                    if (count($projects) != 0) {
                        $menu = 'Proyects';
                        $get_menu = Menu::find(1);
                        if (isset($get_menu) != 0) {
                            $menu = $get_menu->title_en;
                        }
                        if ($date != '') {
                            $row = 0;
                            foreach ($projects as $rs):
                                if (date("Y-m-d", strtotime($date)) == date("Y-m-d", strtotime($rs->created_at))) {
                                    $row = $row + 1;
                                    $items[] = array(
                                        "title" => $rs->title_en,
                                        "content" => $rs->resume_en,
                                        "url" => "en/projects/" . $rs->url_en
                                    );
                                }
                            endforeach;
                            if ($row != 0) {
                                $content[] = array(
                                    "id" => '2',
                                    "title" => $menu,
                                    "total" => $row
                                );
                            }
                        } else {
                            $content[] = array(
                                "id" => '2',
                                "title" => $menu,
                                "total" => count($projects)
                            );
                            foreach ($projects as $rs):
                                $items[] = array(
                                    "title" => $rs->title_en,
                                    "content" => $rs->resume_en,
                                    "url" => "en/projects/" . $rs->url_en
                                );
                            endforeach;
                        }
                    }
                }
                if ($type == '3' || $type == 'all') {
                    $posts = Post::
                            orWhere('title_en', 'like', '%' . $search . '%')
                            ->orWhere('resume_en', 'like', '%' . $search . '%')
                            ->orWhere('content_en', 'like', '%' . $search . '%')
                            ->orderBy('created_at', 'asc')
                            ->get();
                    if (count($posts) != 0) {
                        $menu = 'News';
                        $get_menu = Menu::find(2);
                        if (isset($get_menu) != 0) {
                            $menu = $get_menu->title_en;
                        }
                        if ($date != '') {
                            $row = 0;
                            foreach ($posts as $rs):
                                if (date("Y-m-d", strtotime($date)) == date("Y-m-d", strtotime($rs->created_at))) {
                                    $row = $row + 1;
                                    $items[] = array(
                                        "title" => $rs->title_en,
                                        "content" => $rs->resume_en,
                                        "url" => "en/news/" . $rs->url_en
                                    );
                                }
                            endforeach;
                            if ($row != 0) {
                                $content[] = array(
                                    "id" => '3',
                                    "title" => $menu,
                                    "total" => $row
                                );
                            }
                        } else {
                            $content[] = array(
                                "id" => '3',
                                "title" => $menu,
                                "total" => count($posts)
                            );
                            foreach ($posts as $rs):
                                $items[] = array(
                                    "title" => $rs->title_en,
                                    "content" => $rs->resume_en,
                                    "url" => "en/news/" . $rs->url_en
                                );
                            endforeach;
                        }
                    }
                }
                if ($type == '4' || $type == 'all') {
                    $faq = Faqs::
                            orWhere('title_en', 'like', '%' . $search . '%')
                            ->orWhere('content_en', 'like', '%' . $search . '%')
                            ->orderBy('created_at', 'asc')
                            ->get();
                    if (count($faq) != 0) {
                        $menu = 'FAQ';
                        $get_menu = Menu::find(4);
                        if (isset($get_menu) != 0) {
                            $menu = $get_menu->title_en;
                        }
                        if ($date != '') {
                            $row = 0;
                            foreach ($faq as $rs):
                                if (date("Y-m-d", strtotime($date)) == date("Y-m-d", strtotime($rs->created_at))) {
                                    $row = $row + 1;
                                    $items[] = array(
                                        "title" => $rs->title_en,
                                        "content" => '',
                                        "url" => "en/faq#" . $rs->url_en
                                    );
                                }
                            endforeach;

                            if ($row != 0) {
                                $content[] = array(
                                    "id" => '4',
                                    "title" => $menu,
                                    "total" => $row
                                );
                            }
                        } else {
                            $content[] = array(
                                "id" => '4',
                                "title" => $menu,
                                "total" => count($faq)
                            );
                            foreach ($faq as $rs):
                                $items[] = array(
                                    "title" => $rs->title_en,
                                    "content" => '',
                                    "url" => "en/faq#" . $rs->url_en
                                );
                            endforeach;
                        }
                    }
                }
            }
            return response()->json(["items" => $items, 'content' => $content]);
        } catch (Exception $ex) {
            return false;
        }
        return false;
    }

}
