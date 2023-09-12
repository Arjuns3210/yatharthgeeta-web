<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\EventImage;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class EventImageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['event_image_view'] = checkPermission('event_image_view');
        $data['event_image_add'] = checkPermission('event_image_add');
        $data['event_image_edit'] = checkPermission('event_image_edit');
        $data['event_image_status'] = checkPermission('event_image_status');
        $data['event_image_delete'] = checkPermission('event_image_delete');
        return view('backend/event_images/index',["data"=>$data]);
    }

    public function fetch(Request $request)
    {
        if ($request->ajax()) {
            try {
                $query = EventImage::orderBy('updated_at','desc');
                return DataTables::of($query)
                    ->filter(function ($query) use ($request) {
                        if (isset($request['search']['search_status']) && !is_null($request['search']['search_status'])) {
                            $query->where('status', 'like', "%" . $request['search']['search_status'] . "%");
                        }
                        if (isset($request['search']['search_sequence']) && !is_null($request['search']['search_sequence'])) {
                            $query->where('sequence', 'like', "%" . $request['search']['search_sequence'] . "%");
                        }
                        if
                        (isset($request['search']['search_title']) && !is_null($request['search']['search_title'])) {
                            $query->where('title', 'like', "%" . $request['search']['search_title'] . "%");
                        }
                        $query->get()->toArray();
                    })
                    ->editColumn('title',function ($event) {
                        return $event['title'];
                    })
                    ->editColumn('sequence',function ($event) {
                        return $event['sequence'];
                    })
                    ->editColumn('action', function ($event) {
                        $event_image_view = checkPermission('event_image_view');
                        $event_image_add = checkPermission('event_image_add');
                        $event_image_edit = checkPermission('event_image_edit');
                        $event_image_status = checkPermission('event_image_status');
                        $event_image_delete = checkPermission('event_image_delete');
                        $actions = '<span style="white-space:nowrap;">';
                        if ($event_image_view) {
                            $actions .= '<a href="event_images/view/' . $event['id'] . '" class="btn btn-primary btn-sm src_data" data-size="large" data-title="View Event Image Details" title="View"><i class="fa fa-eye"></i></a>';
                        }
                        if ($event_image_edit) {
                            $actions .= ' <a href="event_images/edit/' . $event['id'] . '" class="btn btn-success btn-sm src_data" title="Update"><i class="fa fa-edit"></i></a>';
                        }
                        if ($event_image_delete) {
                            $actions .= ' <a data-option="" data-url="event_images/delete/' . $event->id . '" class="btn btn-danger btn-sm delete-data" title="delete"><i class="fa fa-trash"></i></a>';
                        }
                        if ($event_image_status) {
                            if ($event->status == '1') {
                                $actions .= ' <input type="checkbox" data-url="event_images/publish" id="switchery' . $event->id . '" data-id="' . $event->id . '" class="js-switch switchery" checked>';
                            } else {
                                $actions .= ' <input type="checkbox" data-url="event_images/publish" id="switchery' . $event->id . '" data-id="' . $event->id . '" class="js-switch switchery">';
                            }
                        }
                        $actions .= '</span>';
                        return $actions;
                    })
                    ->addIndexColumn()
                    ->rawColumns(['title','sequence','action'])->setRowId('id')->make(true);
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
                $event = EventImage::find($request->id);
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
        $data['event'] = Event::all();
        return view('backend/event_images/add', $data);
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
        // print_r($input); exit();
        //$data = EventImage::create($input);
        //$images = $request->file('images');
        // foreach ($images as $image) {
        //     // Assuming you are using the Spatie MediaLibrary package
        // }
        if ($request->hasFile('images')) {
            foreach($input['images'] as $key => $value) {
                $event_image = new EventImage();
                $event_image->event_id = $input['event_id'];
                $event_image->title = $input['title'];
                $event_image->images = $value;
                $event_image->sequence = $input['sequence'];
                $event_image->save();
                $event_image->addMedia($value)->toMediaCollection(EventImage::IMAGE);
            }
        }
        // storeMedia($data, $request->file('images'), EventImage::IMAGE);
        //successMessage('Data Saved successfully', []);

    // print_r($input); exit();

    // storeMedia($data, $request->file('images'), EventImage::IMAGE);
    successMessage('Data Saved successfully', []);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\EventImage  $eventImage
     * @return \Illuminate\Http\Response
     */
    public function view($id)
    {
        $data['event_image'] = EventImage::find($id);
        $data['event'] = Event::where('id', $data['event_image']->event_id)->first();
        $data['media'] = $data['event_image']->getMedia(EventImage::IMAGE)[0];
        return view('backend/event_images/view', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\EventImage  $eventImage
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['event_image'] = EventImage::find($id);
        $data['event'] = Event::all();
        $data['media'] =$data['event_image']->getMedia(EventImage::IMAGE)[0];
        return view('backend/event_images/edit',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\EventImage  $eventImage
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $data = EventImage::find($_GET['id']);
        $input=$request->all();
        if (!$data) {
            errorMessage('Event Not Found', []);
        }
        $data->update($input);
        if(!empty($input['image'])){
            $data->clearMediaCollection(EventImage::IMAGE);
            storeMedia($data, $input['image'], EventImage::IMAGE);
        }
        successMessage('Data Updated successfully', []);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\EventImage  $eventImage
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data= EventImage::find($id);
        $data->delete();
        successMessage('Data Deleted successfully', []);
    }
}
