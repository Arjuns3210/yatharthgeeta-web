<?php

namespace App\Http\Controllers\Backend;
use App\Http\Controllers\Controller;
use Yajra\DataTables\DataTables;
use App\Models\Guru;
use App\Models\GuruTranslation;
use App\Utils\Utils;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class GuruController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['guru_add'] = checkPermission('guru_add');
        $data['guru_edit'] = checkPermission('guru_edit');
        $data['guru_view'] = checkPermission('guru_view');
        $data['guru_status'] = checkPermission('guru_status');
        $data['guru_delete'] = checkPermission('guru_delete');
        return view('backend/guru/index',['data' =>$data]);
    }

    public function fetch(Request $request)
    {
        if ($request->ajax()) {
            try {
                $query = Guru::orderBy('updated_at','desc');
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
                        $query->get()->toArray();
                    })
                    ->editColumn('name', function ($event) {
                        $Key_index = array_search(\App::getLocale(), array_column($event->translations->toArray(), 'locale'));
                        return $event['translations'][$Key_index]['name'];
                    })->editColumn('title', function ($event) {
                        $Key_index = array_search(\App::getLocale(), array_column($event->translations->toArray(), 'locale'));
                        return $event['translations'][$Key_index]['title'];
                    })
                    ->editColumn('action', function ($event) {
                        $guru_edit = checkPermission('guru_edit');
                        $guru_view = checkPermission('guru_view');
                        $guru_status = checkPermission('guru_status');
                        $guru_delete = checkPermission('guru_delete');
                        $actions = '<span style="white-space:nowrap;">';
                        if ($guru_view) {
                            $actions .= '<a href="guru/view/' . $event['id'] . '" class="btn btn-primary btn-sm src_data" data-size="large" data-title="View guru Details" title="View"><i class="fa fa-eye"></i></a>';
                        }
                        if ($guru_edit) {
                            $actions .= ' <a href="guru/edit/' . $event['id'] . '" class="btn btn-success btn-sm src_data" title="Update"><i class="fa fa-edit"></i></a>';
                        }
                        $actions .= '</span>';
                        return $actions;
                    })
                    ->addIndexColumn()
                    ->rawColumns(['name'.\App::getLocale(), 'short_description','location','status', 'action'])->setRowId('id')->make(true);
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
        $data['translated_block'] = Guru::TRANSLATED_BLOCK;

        return view('backend/guru/add',$data);
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
        $translated_keys = array_keys(Guru::TRANSLATED_BLOCK);
        foreach ($translated_keys as $value) {
            $input[$value] = (array) json_decode($input[$value]);
        }
        $saveArray = Utils::flipTranslationArray($input, $translated_keys);
        $data = Guru::create($saveArray);
        storeMedia($data, $input['image'], Guru::IMAGE);
        successMessage('Data Saved successfully', []);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\guru  $guru
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data['guru'] = Guru::find($id);
        $data['media'] = $data['guru']->getMedia(Guru::IMAGE)[0];
        return view('backend/guru/view',$data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\guru  $guru
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['guru'] = Guru::find($id);
        foreach($data['guru']['translations'] as $trans) {
            $translated_keys = array_keys(Guru::TRANSLATED_BLOCK);
            foreach ($translated_keys as $value) {
                $data['guru'][$value.'_'.$trans['locale']] = $trans[$value];
            }
        }
        $data['translated_block'] = Guru::TRANSLATED_BLOCK;
        $data['media'] =$data['guru']->getMedia(Guru::IMAGE)[0];
        return view('backend/guru/edit',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\guru  $guru
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $data = Guru::find($_GET['id']);
        $input=$request->all();
        if (!$data) {
            errorMessage('guru Not Found', []);
        }
        $translated_keys = array_keys(Guru::TRANSLATED_BLOCK);
        foreach ($translated_keys as $value) 
        {
            $input[$value] = (array) json_decode($input[$value]);
        }
        $guru = Utils::flipTranslationArray($input, $translated_keys);
        $data->update($guru);
        if(!empty($input['image'])){
            $data->clearMediaCollection(Guru::IMAGE);
            storeMedia($data, $input['image'], Guru::IMAGE);
        }
        successMessage('Data Updated successfully', []);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\guru  $guru
     * @return \Illuminate\Http\Response
     */
    public function destroy(guru $guru)
    {
        //
    }
}
