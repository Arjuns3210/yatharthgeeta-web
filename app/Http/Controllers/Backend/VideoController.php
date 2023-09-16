<?php

namespace App\Http\Controllers\Backend;
use App\Http\Controllers\Controller;
use App\Models\Artist;
use App\Models\Language;
use App\Models\Video;
use App\Models\VideoCategory;
use App\Utils\Utils;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Yajra\DataTables\DataTables;


class VideoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $data['videos_view'] = checkPermission('videos_view');
        $data['videos_add'] = checkPermission('videos_add');
        $data['videos_edit'] = checkPermission('videos_edit');
        $data['videos_status'] = checkPermission('videos_status');
        $data['videos_delete'] = checkPermission('videos_delete');
        return view('backend/videos/index',["data"=>$data]);
    }

    public function fetch(Request $request)
        {
            if ($request->ajax()) {
                try {
                    $query = Video::orderBy('updated_at','desc');
                    return DataTables::of($query)
                        ->filter(function ($query) use ($request) {
                            if (isset($request['search']['search_title']) && !is_null($request['search']['search_title'])) {
                                $query->whereHas('translations', function ($translationQuery) use ($request) {
                                    $translationQuery->where('locale','en')->where('title', 'like', "%" . $request['search']['search_title'] . "%");
                                });
                            }
                            if (isset($request['search']['search_status']) && !is_null($request['search']['search_status'])) {
                                $query->where('status', 'like', "%" . $request['search']['search_status'] . "%");
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
                            $videos_view = checkPermission('videos_view');
                            $videos_add = checkPermission('videos_add');
                            $videos_edit = checkPermission('videos_edit');
                            $videos_status = checkPermission('videos_status');
                            $videos_delete = checkPermission('videos_delete');
                            $actions = '<span style="white-space:nowrap;">';
                            if ($videos_view) {
                                $actions .= '<a href="videos/view/' . $event['id'] . '" class="btn btn-primary btn-sm src_data" data-size="large" data-title="View Video Details" title="View"><i class="fa fa-eye"></i></a>';
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

    //Update Status

    public function updateStatus(Request $request)
    {
        try {
            $msg_data = array();
            $video = Video::find($request->id);
            $video->status = $request->status;
            $video->save();
            if ($request->status == 1) {
                successMessage(trans('message.enable'), $msg_data);
            } else {
                errorMessage(trans('message.disable'), $msg_data);
            }
            errorMessage('Video not found', []);
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
        $data['translated_block'] = Video::TRANSLATED_BLOCK;
        $data['language'] = Language::all();
        $data['artist'] = Artist::all();
        $data['video_category'] = VideoCategory::all();
        return view('backend/videos/add',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        $input = $request->all();
        $translated_keys = array_keys(Video::TRANSLATED_BLOCK);
        foreach ($translated_keys as $value) {
            $input[$value] = (array) json_decode($input[$value]);
        }
        $saveArray = Utils::flipTranslationArray($input, $translated_keys);
        $saveArray['link'] = explode('&', $saveArray['link'])[0] ?? $saveArray['link'];
        $data = Video::create($saveArray);
        //store video cover image
        if (! empty($input['cover_image']) && $data) {
            storeMedia($data, $input['cover_image'], Video::COVER_IMAGE);
        }
        successMessage('Data Saved successfully', []);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Video  $video
     * @return \Illuminate\Http\Response
     */
    public function view($id)
    {
        $data['videos'] = Video::find($id);
        $data['language'] = Language::where('id', $data['videos']->language_id)->first();
        $data['artist'] = Artist::where('id', $data['videos']->artist_id)->first();
        $data['video_category'] = VideoCategory::where('id', $data['videos']->video_category_id)->first();
        foreach($data['videos']['translations'] as $trans) {
            $translated_keys = array_keys(Video::TRANSLATED_BLOCK);
            foreach ($translated_keys as $value) {
                $data['videos'][$value.'_'.$trans['locale']] = $trans[$value];
            }
        }
        $data['translated_block'] = Video::TRANSLATED_BLOCK;
        $data['media'] = $data['videos']->getMedia(Video::COVER_IMAGE)[0];
        return view('backend/videos/view',$data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Video  $video
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $localeLanguage = \App::getLocale();
        $data['videos'] = Video::find($id);
        $data['language'] = Language::all();
        $data['artist'] = Artist::with([
            'translations' => function ($query) use ($localeLanguage) {
                $query->where('locale', $localeLanguage);
            },
        ])->where('status', 1)->get();
        $data['video_category'] = VideoCategory::all();
        foreach($data['videos']['translations'] as $trans) {
            $translated_keys = array_keys(Video::TRANSLATED_BLOCK);
            foreach ($translated_keys as $value) {
                $data['videos'][$value.'_'.$trans['locale']] = str_replace("<br/>", "\r\n", $trans[$value]);
            }
        }
        $data['translated_block'] = Video::TRANSLATED_BLOCK;
        $data['artist'] = Artist::with([
            'translations' => function ($query) use ($localeLanguage) {
                $query->where('locale', $localeLanguage);
            },
        ])->get();

        $data['language'] = Language::with([
            'translations' => function ($query) use ($localeLanguage) {
                $query->where('locale', $localeLanguage);
            },
        ])->where('status', 1)->get();
        $data['media'] =$data['videos']->getMedia(Video::COVER_IMAGE)[0];
        return view('backend/videos/edit',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function update(Request $request)
    {
        $localeLanguage = \App::getLocale();
        $data = Video::find($_GET['id']);
        $input=$request->all();
        if (!$data) {
            errorMessage('Video Not Found', []);
        }
        $translated_keys = array_keys(Video::TRANSLATED_BLOCK);
        foreach ($translated_keys as $value)
        {
            $input[$value] = (array) json_decode($input[$value]);
        }
        $video = Utils::flipTranslationArray($input, $translated_keys);
        $video['link'] = explode('&', $video['link'])[0] ?? $video['link'];
        $data->update($video);
        if(!empty($input['cover_image'])){
            $data->clearMediaCollection(Video::COVER_IMAGE);
            storeMedia($data, $input['cover_image'], Video::COVER_IMAGE);
        }
        successMessage('Data Updated successfully', []);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Video  $video
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data= Video::find($id);
        $data->delete();
        successMessage('Data Deleted successfully', []);
    }
}
