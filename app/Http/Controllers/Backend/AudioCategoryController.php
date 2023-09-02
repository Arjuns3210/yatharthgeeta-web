<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\AudioCategory;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use App\Utils\Utils;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\DataTables;


class AudioCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View|\Illuminate\Http\Response
     */
    public function index()
    {
        $data['audio_category_add'] = checkPermission('audio_category_add');
        $data['audio_category_edit'] = checkPermission('audio_category_edit');
        $data['audio_category_view'] = checkPermission('audio_category_view');
        $data['audio_category_status'] = checkPermission('audio_category_status');
        $data['audio_category_delete'] = checkPermission('audio_category_delete');
        
        return view('backend/audio_category/index',["data"=>$data]);
    }

    /**
     * Fetch a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function fetch(Request $request)
    {
        if ($request->ajax()) {
            try {
                $query = AudioCategory::orderBy('updated_at','desc');

                return DataTables::of($query)
                    ->filter(function ($query) use ($request) {
                        if (isset($request['search']['search_category_name']) && !is_null($request['search']['search_category_name'])) {
                            $query->whereHas('translations', function ($translationQuery) use ($request) {
                                $translationQuery->where('name', 'like', "%" . $request['search']['search_category_name'] . "%");
                            });
                        }
                        if (isset($request['search']['search_status']) && !is_null($request['search']['search_status'])) {
                            $query->where('audio_categories.status', $request['search']['search_status']);
                        }
                        $query->get()->toArray();
                    })
                    ->editColumn('category_name_'.\App::getLocale(), function ($event) {

                        $key_index = array_search(\App::getLocale(), array_column($event->translations->toArray(), 'locale'));
                        return $event->translations[$key_index]->name ?? '';
                    })->editColumn('status', function ($event) {
                        return $event->status == 1 ?'Active' : 'Inactive';
                    })
                    ->editColumn('action', function ($event) {
                        $audio_category_view = checkPermission('audio_category_view');
                        $audio_category_edit = checkPermission('audio_category_edit');
                        $audio_category_status = checkPermission('audio_category_status');
                        $audio_category_delete = checkPermission('audio_category_delete');
                        $actions = '<span style="white-space:nowrap;">';
                        if ($audio_category_view) {
                            $actions .= '<a href="audio_category/view/' . $event['id'] . '" class="btn btn-primary btn-sm src_data" data-size="large" data-title="View Category Details" title="View"><i class="fa fa-eye"></i></a>';
                        }
                        if ($audio_category_edit) {
                            $actions .= ' <a href="audio_category/edit/' . $event['id'] . '" class="btn btn-success btn-sm src_data" title="Update"><i class="fa fa-edit"></i></a>';
                        }
                        $actions .= '</span>';
                        return $actions;
                    })
                    ->addIndexColumn()
                    ->rawColumns(['category_name_'.\App::getLocale(), 'status', 'action'])->setRowId('id')->make(true);
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
        $data['translated_block'] = AudioCategory::TRANSLATED_BLOCK;
       
        return view('backend/audio_category/add',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $input = $request->all();
            $translated_keys = array_keys(AudioCategory::TRANSLATED_BLOCK);
            foreach ($translated_keys as $value) {
                $input[$value] = (array) json_decode($input[$value]);
            }
            $saveArray = Utils::flipTranslationArray($input, $translated_keys);
            AudioCategory::create($saveArray);
            DB::commit();
            
            successMessage('Data Saved successfully', []);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Something Went Wrong. Error: ".$e->getMessage());

            errorMessage("Something Went Wrong.");
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data['category'] = AudioCategory::find($id)->toArray();
        return view('backend/audio_category/view',$data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['category'] = AudioCategory::find($id)->toArray();
        foreach($data['category']['translations'] as $trans) {
            $translated_keys = array_keys(AudioCategory::TRANSLATED_BLOCK);
            foreach ($translated_keys as $value) {
                $data['category'][$value.'_'.$trans['locale']] = $trans[$value];
            }
        }
        $data['translated_block'] = AudioCategory::TRANSLATED_BLOCK;
        return view('backend/audio_category/edit',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        try {
            DB::beginTransaction();
            $audio = AudioCategory::find($_GET['id']);
            $input = $request->all();
            if (! $audio) {
                errorMessage('Audio Category Not Found', []);
            }
            $translated_keys = array_keys(AudioCategory::TRANSLATED_BLOCK);
            foreach ($translated_keys as $value) {
                $input[$value] = (array) json_decode($input[$value]);
            }
            $category = Utils::flipTranslationArray($input, $translated_keys);
            $audio->update($category);
            DB::commit();
            successMessage('Data Update successfully', []);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Something Went Wrong. Error: ".$e->getMessage());

            errorMessage('Something Went Wrong.');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
