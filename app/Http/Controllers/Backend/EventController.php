<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Artist;
use App\Models\Event;
use App\Models\EventImage;
use App\Models\Location;
use App\Utils\Utils;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['event_view'] = checkPermission('event_view');
        $data['event_add'] = checkPermission('event_add');
        $data['event_edit'] = checkPermission('event_edit');
        $event_images= checkPermission('event_image_add');
        $data['event_status'] = checkPermission('event_status');
        $data['event_delete'] = checkPermission('event_delete');
        return view('backend/events/index',["data"=>$data]);
    }

    public function fetch(Request $request)
        {
            $localeLanguage = \App::getLocale();
            if (str_contains($localeLanguage, 'en')) {
                $localeLanguage = 'en';
            } else {
                $localeLanguage = 'hi';
            }
            if ($request->ajax()) {
                try {
                    $query = Event::with('translations')
                        ->orderBy('updated_at','desc');
                    return DataTables::of($query)
                        ->filter(function ($query) use ($request,$localeLanguage) {
                            if (isset($request['search']['search_title']) && !is_null($request['search']['search_title'])) {
                                $query->whereHas('translations', function ($translationQuery) use ($request,$localeLanguage) {
                                    $translationQuery->where('locale',$localeLanguage)->where('title', 'like', "%" . $request['search']['search_title'] . "%");
                                });
                            }
                            if (isset($request['search']['search_sequence']) && !is_null($request['search']['search_sequence'])) {
                                $query->where('sequence', 'like', "%" . $request['search']['search_sequence'] . "%");
                            }
                            if (isset($request['search']['search_status']) && !is_null($request['search']['search_status'])) {
                                $query->where('status', $request['search']['search_status']);
                            }
                            $query->get()->toArray();
                        })->editColumn('title_'.\App::getLocale(), function ($event) {
                            $Key_index = array_search(\App::getLocale(), array_column($event->translations->toArray(), 'locale'));
                            return $event['translations'][$Key_index]['title'];

                        })->editColumn('sequence',function ($event) {
                            return $event['sequence'];
                        })
                        ->editColumn('action', function ($event) {
                            $event_view = checkPermission('event_view');
                            $event_add = checkPermission('event_add');
                            $event_edit = checkPermission('event_edit');
                            $event_images=checkPermission('event_image_add');
                            $event_status = checkPermission('event_status');
                            $event_delete = checkPermission('event_delete');
                            $actions = '<span style="white-space:nowrap;">';
                            if ($event_view) {
                                $actions .= '<a href="events/view/' . $event['id'] . '" class="btn btn-primary btn-sm src_data" data-size="large" data-title="View Event Details" title="View"><i class="fa fa-eye"></i></a>';
                            }
                            if ($event_edit) {
                                $actions .= ' <a href="events/edit/' . $event['id'] . '" class="btn btn-success btn-sm src_data" title="Update"><i class="fa fa-edit"></i></a>';
                            }
                            if ($event_images) {
                                $actions .= ' <a href="event_images/add/'.$event['id'].'" class="btn btn-info btn-sm src_data" title="Gallery"><i class="fa fa-picture-o"></i></a>';
                            }
                            if ($event_delete) {
                                $actions .= ' <a data-option="" data-url="events/delete/' . $event->id . '" class="btn btn-danger btn-sm delete-data" title="delete"><i class="fa fa-trash"></i></a>';
                            }
                            if ($event_status) {
                                if ($event->status == '1') {
                                    $actions .= ' <input type="checkbox" data-url="events/publish" id="switchery' . $event->id . '" data-id="' . $event->id . '" class="js-switch switchery" checked>';
                                } else {
                                    $actions .= ' <input type="checkbox" data-url="events/publish" id="switchery' . $event->id . '" data-id="' . $event->id . '" class="js-switch switchery">';
                                }
                            }
                            $actions .= '</span>';
                            return $actions;
                        })
                        ->addIndexColumn()
                        ->rawColumns(['title_'.\App::getLocale(),'sequence', 'action'])->setRowId('id')->make(true);
                } catch (\Exception $e) {
                    \Log::error("Something Went Wrong. Error: " . $e->getMessage());
                    return response([
                        'draw'            => 0,
                        'recordsTotal'    => 0,
                        'recordsFiltered' => 0,
                        'data'            => [],
                        'error'           => 'Something went wrong',
                    ]);
                }
            }
        }

        public function updateStatus(Request $request)
        {
            try {
                $msg_data = array();
                $event = Event::find($request->id);
                $event->status = $request->status;
                $event->save();
                if ($request->status == 1) {
                    successMessage(trans('message.enable'), $msg_data);
                } else {
                    errorMessage(trans('message.disable'), $msg_data);
                }
                errorMessage('Event not found', []);
            } catch (\Exception $e) {
                errorMessage(trans('auth.something_went_wrong'));
            }

        }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['translated_block'] = Event::TRANSLATED_BLOCK;
        $data['location'] = Location::all();
        $data['artist'] = Artist::all();
        return view('backend/events/add',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();
        $translated_keys = array_keys(Event::TRANSLATED_BLOCK);
        foreach ($translated_keys as $value) {
            $input[$value] = (array) json_decode($input[$value]);
        }
        $saveArray = Utils::flipTranslationArray($input, $translated_keys);
        $data = Event::create($saveArray);
        if (!empty($input['cover'])){
            storeMedia($data, $input['cover'], Event::EVENT_COVER);
        }
        successMessage('Data Saved successfully', []);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function view($id)
    {
        $data['event'] = Event::find($id);
        $data['location'] = Location::where('id', $data['event']->location_id)->first();
        $data['artist'] = Artist::where('id', $data['event']->artist_id)->first();
        foreach($data['event']['translations'] as $trans) {
            $translated_keys = array_keys(Event::TRANSLATED_BLOCK);
            foreach ($translated_keys as $value) {
                $data['event'][$value.'_'.$trans['locale']] = $trans[$value];
            }
        }
        $data['translated_block'] = Event::TRANSLATED_BLOCK;
        $data['coverImage'] = $data['event']->getMedia(Event::EVENT_COVER)->first();
        $data['eventImages'] = $data['event']->getMedia(Event::EVENT_IMAGES);
        
        return view('backend/events/view',$data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['event'] = Event::find($id);
        $data['location'] = Location::all();
        $data['artist'] = Artist::all();
        foreach($data['event']['translations'] as $trans) {
            $translated_keys = array_keys(Event::TRANSLATED_BLOCK);
            foreach ($translated_keys as $value) {
                $data['event'][$value.'_'.$trans['locale']] = str_replace("<br/>", "\r\n", $trans[$value]);
            }
        }
        $data['translated_block'] = Event::TRANSLATED_BLOCK;
        $data['coverImage'] =$data['event']->getMedia(Event::EVENT_COVER)->first();
        return view('backend/events/edit',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $data = Event::find($_GET['id']);
        $input=$request->all();
        if (!$data) {
            errorMessage('Event Not Found', []);
        }
        $translated_keys = array_keys(Event::TRANSLATED_BLOCK);
        foreach ($translated_keys as $value)
        {
            $input[$value] = (array) json_decode($input[$value]);
        }
        $event = Utils::flipTranslationArray($input, $translated_keys);
        $data->update($event);
        if(!empty($input['cover'])){
            $data->clearMediaCollection(Event::EVENT_COVER);
            storeMedia($data, $input['cover'], Event::EVENT_COVER);
        }
        successMessage('Data Updated successfully', []);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data= Event::find($id);
        $data->delete();
        successMessage('Data Deleted successfully', []);
    }
}
