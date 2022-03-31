<?php

namespace App\Http\Controllers;

use App\Event;
use App\Mail\BAMail;
use App\Http\Requests\EventCreateRequest;
use App\Http\Requests\EventUpdateRequest;
use Illuminate\Http\Request;
use App\CategoriesEvent;
use App\Audits;
use App\Types;
use App\EventsArchives;
use Flash;
use Session;
use Mail;
use Redirect;
use Auth;
use App\Http\Requests;

class EventController extends Controller {

    /**
     * Validate session
     */
    public function __construct() {
        $this->middleware('admin');
        $this->middleware('role:30');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        try {
            return view('admin.event_list');
        } catch (Exception $ex) {
            return false;
        }
        return false;
    }

    /**
     * Display list resources
     * @return type
     */
    public function lists() {
        try {
            $event = Event::orderBy('created_at', 'desc')->get();
            $json = array();
            foreach ($event as $rs):

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
                    "title_2" => $rs->title,
                    "parse_text" => $this->parseText($rs->title),
                    "title" => substr($rs->title, 0, 28) . '...',
                    "type" => $type,
                    'categories' => mb_substr($categories, 0, 100) . '',
                    "created_at" => date("Y-m-d H:i:s", strtotime($rs->start_date)),
                    "end_date" => date("Y-m-d H:i:s", strtotime($rs->end_date)),
                );
            endforeach;
            return response()->json($json);
        } catch (Exception $ex) {
            return false;
        }
        return false;
    }

    /**
     * Display list photo page
     * @return type
     */
    public function lists_photo(Request $request) {
        try {
            $event = Event::find($request['id']);
            $total = substr_count($event->image, ',');
            $json = array();
            if ($event->image != "") {
                for ($i = 1; $i <= substr_count($event->image, ','); $i++) {
                    $imagen = explode(',', $event->image);
                    $json[] = array('nombre' => $imagen[$i]);
                }
            }
            return response()->json($json);
        } catch (Exception $ex) {
            return false;
        }
        return false;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        try {
            $type = Types::where('status', '1')->orderBy('position', 'asc')->pluck('name', 'id');
            $categories = CategoriesEvent::where('status', '1')->orderBy('position', 'asc')->get();
            EventsArchives::where('event', '0')->delete();
            return view('admin.event', compact('type'), ['categories' => $categories]);
        } catch (Exception $ex) {
            return false;
        }
        return false;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EventCreateRequest $request) {
        try {
            $datetime = explode(' ', $request['start_date']);
            $start_date = explode('-', $datetime['0']);
            $start_date = $start_date['2'] . '-' . $start_date['0'] . '-' . $start_date['1'] . ' ' . $datetime['1'];

            $datetime = explode(' ', $request['end_date']);
            $end_date = explode('-', $datetime['0']);
            $end_date = $end_date['2'] . '-' . $end_date['0'] . '-' . $end_date['1'] . ' ' . $datetime['1'];

            if (isset($request['status_event'])) {
                $status_event = '0';
            } else {
                $status_event = '1';
            }

            $categories = '';

            if (isset($request['categories'])) {
                for ($i = 0; $i < count($request['categories']); $i++) {
                    $categories .= ',' . $request['categories'][$i];
                }
            }

            $event = Event::orderBy('position', 'asc')->offset(0)->limit(100)->get();

            foreach ($event as $rs):

                $position = $rs->position + 1;
                $post = Event::find($rs->id);
                $post->fill([
                    'position' => $position,
                ]);
                $post->save();

            endforeach;


            $event = Event::create([
                        'title' => $request['title'],
                        'url' => $request['title'],
                        'resume' => $request['resume'],
                        'content' => $request['content'],
                        'title_en' => $request['title_en'],
                        'url_en' => $request['title_en'],
                        'resume_en' => $request['resume_en'],
                        'content_en' => $request['content_en'],
                        'categories' => $categories,
                        'type' => $request['type'],
                        'place' => $request['place'],
                        'start_date' => date("Y-m-d H:i:s", strtotime($start_date)),
                        'end_date' => date("Y-m-d H:i:s", strtotime($end_date)),
                        'status_event' => $status_event,
                        'image' => $request['image'],
                        'video' => $request['video'],
            ]);



            EventsArchives::where('event', '0')->update([
                'event' => $event->id
            ]);

            $this->audit('Registro de evento ID #' . $event->id);

            Session()->flash('notice', 'Registro Exitoso');
            return redirect::to('/event');
        } catch (Exception $ex) {
            return false;
        }
        return false;
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
        try {
            $event = Event::find($id);
            if (isset($event) == 0)
                return redirect::to('/event');

            $type = Types::where('status', '1')->orderBy('position', 'asc')->pluck('name', 'id');
            $categories = CategoriesEvent::where('status', '1')->orderBy('position', 'asc')->get();
            return view('admin.event_edit', compact('type'), ['event' => $event, 'categories' => $categories]);
        } catch (Exception $ex) {
            return false;
        }
        return false;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(EventUpdateRequest $request, $id) {
        try {

            $datetime = explode(' ', $request['start_date']);
            $start_date = explode('-', $datetime['0']);
            $start_date = $start_date['2'] . '-' . $start_date['0'] . '-' . $start_date['1'] . ' ' . $datetime['1'];

            $datetime = explode(' ', $request['end_date']);
            $end_date = explode('-', $datetime['0']);
            $end_date = $end_date['2'] . '-' . $end_date['0'] . '-' . $end_date['1'] . ' ' . $datetime['1'];

            if (isset($request['status_event'])) {
                $status_event = '0';
            } else {
                $status_event = '1';
            }

            $categories = '';

            if (isset($request['categories'])) {
                for ($i = 0; $i < count($request['categories']); $i++) {
                    $categories .= ',' . $request['categories'][$i];
                }
            }


            $event = Event::find($id);
            $event->fill([
                'title' => $request['title'],
                'url' => $request['title'],
                'resume' => $request['resume'],
                'content' => $request['content'],
                'categories' => $categories,
                'title_en' => $request['title_en'],
                'url_en' => $request['title_en'],
                'resume_en' => $request['resume_en'],
                'content_en' => $request['content_en'],
                'type' => $request['type'],
                'place' => $request['place'],
                'start_date' => date("Y-m-d H:i:s", strtotime($start_date)),
                'end_date' => date("Y-m-d H:i:s", strtotime($end_date)),
                'status_event' => $status_event,
                'image' => $request['image'],
                'video' => $request['video'],
            ]);
            $event->save();
            $this->audit('Actualización evento ID #' . $id);
            Session()->flash('warning', 'Registro Actualizado');
            return Redirect::to('/event');
        } catch (Exception $ex) {
            return false;
        }
        return false;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        try {
            Event::destroy($id);
            $this->audit('Eliminar evento ID #' . $id);
            return response()->json(["msg" => "borrado"]);
        } catch (Exception $ex) {
            return false;
        }
        return false;
    }

    /**
     * Delete photo page
     * @param Request $request
     * @return type
     */
    public function delete_photo(Request $request) {
        try {
            $event = Event::find($request['id']);
            $event->fill([
                'image' => $request['image'],
            ]);
            $event->save();
            $this->audit('Eliminar archivo adjunto de evento ID #' . $request['id']);
            return response()->json(["msg" => "borrado"]);
        } catch (Exception $ex) {
            return false;
        }
        return false;
    }

    /**
     * Move items event
     * @param Request $request
     * @return boolean
     */
    public function move_event(Request $request) {
        try {
            foreach ($request['item'] as $key => $value) {
                $event = Event::find($value);
                $event->fill([
                    'position' => $key
                ]);
                $event->save();
            }
            $this->audit('Ordenar eventos');
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
