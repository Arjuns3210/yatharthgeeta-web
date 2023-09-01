<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Video;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class VideoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['videos_view'] = checkPermission('videos_view');
        $data['videos_add'] = checkPermission('videos_add');
        $data['videos_edit'] = checkPermission('videos_edit');
        $data['videos_status'] = checkPermission('videos_status');
        $data['videos_delete'] = checkPermission('videos_delete');
        $data['translated_block'] = Video::TRANSLATED_BLOCK;
        return view('backend/videos/index',["data"=>$data]);
    }

    public function fetch(Request $request)
    {
        if ($request->ajax()) {
            try {
                $query = Video::leftJoin('video_translations', function ($join) {
                    $join->on("video_translations.video_id", '=', "videos.id");
                    $join->where('video_translations.locale', \App::getLocale());
                 })
                 ->select('videos.*')
                 ->orderBy('updated_at','desc');
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
                    ->editColumn('title'.\App::getLocale(), function ($event) {
                        $Key_index = array_search(\App::getLocale(), array_column($event->translations->toArray(), 'locale'));
                        return $event['translations'][$Key_index]['title'];

                    })->editColumn('title',function ($event) {
                        return $event['title'];
                    })
                    ->editColumn('sequence',function ($event) {
                        return $event['sequence'];
                    })
                    ->editColumn('action', function ($event) {
                        $videos_view = checkPermission('videos_view');
                        $videos_add = checkPermission('videos_add');
                        $videos_edit = checkPermission('videos_edit');
                        $videos_status = checkPermission('videos_status');
                        $videos_delete = checkPermission('videos_delete');
                        $actions = '<span style="white-space:nowrap;">';
                        if ($videos_view) {
                            $actions .= '<a href="videos/view/' . $event['id'] . '" class="btn btn-primary btn-sm modal_src_data" data-size="large" data-title="View Video Details" title="View"><i class="fa fa-eye"></i></a>';
                        }
                        if ($videos_edit) {
                            $actions .= ' <a href="videos/edit/' . $event['id'] . '" class="btn btn-success btn-sm src_data" title="Update"><i class="fa fa-edit"></i></a>';
                        }
                        if ($videos_delete) {
                            $actions .= ' <a data-option="" data-url="videos/delete/' . $event->id . '" class="btn btn-danger btn-sm delete-data" title="delete"><i class="fa fa-trash"></i></a>';
                        }
                        if ($videos_status) {
                            if ($event->status == '1') {
                                $actions .= ' <input type="checkbox" data-url="videos/publish" id="switchery' . $event->id . '" data-id="' . $event->id . '" class="js-switch switchery" checked>';
                            } else {
                                $actions .= ' <input type="checkbox" data-url="videos/publish" id="switchery' . $event->id . '" data-id="' . $event->id . '" class="js-switch switchery">';
                            }
                        }
                        $actions .= '</span>';
                        return $actions;
                    })
                    ->addIndexColumn()
                    ->rawColumns(['title'.\App::getLocale(),'sequence','action'])->setRowId('id')->make(true);
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

    //Update Status

    public function updateStatus(Request $request)
    {
        try {
            $msg_data = array();
            $language = Video::find($request->id);
            $language->status = $request->status;
            $language->save();
            if ($request->status == 1) {
                successMessage('Enable', $msg_data);
            } else {
                successMessage('Disable', $msg_data);
            }
            errorMessage('Banner not found', []);
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
        return view('backend/videos/add');
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
        $data = Video::create($input);
        storeMedia($data, $input['cover_image'], Video::COVER_IMAGE);
        successMessage('Data Saved successfully', []);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Video  $video
     * @return \Illuminate\Http\Response
     */
    public function show(Video $video)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Video  $video
     * @return \Illuminate\Http\Response
     */
    public function edit(Video $video)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Video  $video
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Video $video)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Video  $video
     * @return \Illuminate\Http\Response
     */
    public function destroy(Video $video)
    {
        //
    }
}
