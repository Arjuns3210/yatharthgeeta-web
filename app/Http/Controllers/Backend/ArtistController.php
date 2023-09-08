<?php

namespace App\Http\Controllers\Backend;
use App\Http\Controllers\Controller;
use Yajra\DataTables\DataTables;
use App\Models\Artist;
use App\Models\ArtistTranslation;
use App\Models\Location;
use App\Utils\Utils;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class ArtistController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['artist_add'] = checkPermission('artist_add');
        $data['artist_edit'] = checkPermission('artist_edit');
        $data['artist_view'] = checkPermission('artist_view');
        $data['artist_status'] = checkPermission('artist_status');
        $data['artist_delete'] = checkPermission('artist_delete');
        return view('backend/artist/index',['data' =>$data]);
    }

    public function fetch(Request $request)
    {
        if ($request->ajax()) {
            try {
                $query = Artist::orderBy('updated_at','desc');
                // print_r($query->get()->toArray());exit;
                return DataTables::of($query)
                    ->filter(function ($query) use ($request) {
                        if (isset($request['search']['search_name']) && !is_null($request['search']['search_name'])) {
                            $query->whereHas('translations', function ($translationQuery) use ($request) {
                                $translationQuery->where('locale','en')->where('name', 'like', "%" . $request['search']['search_name'] . "%");
                            });
                        }
                        if (isset($request['search']['search_title']) && !is_null($request['search']['search_title'])) {
                            $query->whereHas('translations', function ($translationQuery) use ($request) {
                                $translationQuery->where('locale','en')->where('title', 'like', "%" . $request['search']['search_title'] . "%");
                            });
                        }
                        if (isset($request['search']['search_status']) && !is_null($request['search']['search_status'])) {
                            $query->where('status', $request['search']['search_status']);
                        }
                        $query->get()->toArray();
                    })
                    ->editColumn('name_'.\App::getLocale(), function ($event) {
                        $Key_index = array_search(\App::getLocale(), array_column($event->translations->toArray(), 'locale'));
                        return $event['translations'][$Key_index]['name'];
                    })->editColumn('title_'.\App::getLocale(), function ($event) {
                        $Key_index = array_search(\App::getLocale(), array_column($event->translations->toArray(), 'locale'));
                        return $event['translations'][$Key_index]['title'];
                    })
                    ->editColumn('action', function ($event) {
                        $artist_edit = checkPermission('artist_edit');
                        $artist_view = checkPermission('artist_view');
                        $artist_status = checkPermission('artist_status');
                        $artist_delete = checkPermission('artist_delete');
                        $actions = '<span style="white-space:nowrap;">';
                        if ($artist_view) {
                            $actions .= '<a href="guru/view/' . $event['id'] . '" class="btn btn-primary btn-sm src_data" data-size="large" data-title="View artist Details" title="View"><i class="fa fa-eye"></i></a>';
                        }
                        if ($artist_edit) {
                            $actions .= ' <a href="guru/edit/' . $event['id'] . '" class="btn btn-success btn-sm src_data" title="Update"><i class="fa fa-edit"></i></a>';
                        }
                        $actions .= '</span>';
                        return $actions;
                    })
                    ->addIndexColumn()
                    ->rawColumns(['name_'.\App::getLocale(), 'title_'.\App::getLocale(),'status', 'action'])->setRowId('id')->make(true);
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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['translated_block'] = Artist::TRANSLATED_BLOCK;
        return view('backend/artist/add',$data);
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
        $translated_keys = array_keys(Artist::TRANSLATED_BLOCK);
        foreach ($translated_keys as $value) {
            $input[$value] = (array) json_decode($input[$value]);
        }
        $saveArray = Utils::flipTranslationArray($input, $translated_keys);
        $data = Artist::create($saveArray);
        storeMedia($data, $input['image'], Artist::IMAGE);
        successMessage('Data Saved successfully', []);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\artist  $artist
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data['guru'] = Artist::find($id);
        foreach($data['guru']['translations'] as $trans) {
            $translated_keys = array_keys(Artist::TRANSLATED_BLOCK);
            foreach ($translated_keys as $value) {
                $data['guru'][$value.'_'.$trans['locale']] = $trans[$value];
            }
        }
        $data['translated_block'] = Artist::TRANSLATED_BLOCK;
        if (!empty($data['guru']->getMedia(Artist::IMAGE))) {
            $media = $data['guru']->getMedia(Artist::IMAGE);
            if (isset($media[0])) {
                $data['media'] = $media[0];
            }
        }
        return view('backend/artist/view',$data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\artist  $artist
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['guru'] = Artist::find($id);
        foreach($data['guru']['translations'] as $trans) {
            $translated_keys = array_keys(Artist::TRANSLATED_BLOCK);
            foreach ($translated_keys as $value) {
                $data['guru'][$value.'_'.$trans['locale']] = str_replace("<br/>", "\r\n", $trans[$value]);
            }
        }
        $data['translated_block'] = Artist::TRANSLATED_BLOCK;
        if (!empty($data['guru']->getMedia(Artist::IMAGE))) {
            $media = $data['guru']->getMedia(Artist::IMAGE);
            if (isset($media[0])) {
                $data['media'] = $media[0];
            }
        }
        return view('backend/artist/edit',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\artist  $artist
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $data = Artist::find($_GET['id']);
        $input=$request->all();
        if (!$data) {
            errorMessage('artist Not Found', []);
        }
        $translated_keys = array_keys(Artist::TRANSLATED_BLOCK);
        foreach ($translated_keys as $value)
        {
            $input[$value] = (array) json_decode($input[$value]);
        }
        $artist = Utils::flipTranslationArray($input, $translated_keys);
        $data->update($artist);
        if(!empty($input['image'])){
            $data->clearMediaCollection(Artist::IMAGE);
            storeMedia($data, $input['image'], Artist::IMAGE);
        }
        successMessage('Data Updated successfully', []);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\artist  $artist
     * @return \Illuminate\Http\Response
     */
    public function destroy(artist $artist)
    {
        //
    }

    public function deleteImage(Request $request)
    {
        $msg_data = array();
        $data = Artist::find($_GET['id']);
        $data->clearMediaCollection(Artist::IMAGE);
        successMessage('image deleted successfully', $msg_data);
    }
}
