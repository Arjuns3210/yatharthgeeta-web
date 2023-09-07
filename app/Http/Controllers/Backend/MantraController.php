<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Mantra;
use App\Utils\Utils;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class MantraController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['mantra_view'] = checkPermission('mantra_view');
        $data['mantra_add'] = checkPermission('mantra_add');
        $data['mantra_edit'] = checkPermission('mantra_edit');
        $data['mantra_status'] = checkPermission('mantra_status');
        $data['mantra_delete'] = checkPermission('mantra_delete');
        return view('backend/mantras/index',["data"=>$data]);
    }

    public function fetch(Request $request)
        {
            if ($request->ajax()) {
                try {
                    $query = Mantra::leftJoin('mantra_translations', function ($join) {
                        $join->on("mantra_translations.mantra_id", '=', "mantras.id");
                        $join->where('mantra_translations.locale', \App::getLocale());
                     })
                     ->select('mantras.*')
                    ->orderBy('updated_at','desc');
                    return DataTables::of($query)
                        ->filter(function ($query) use ($request) {
                            // if (isset($request['search']['search_title']) && !is_null($request['search']['search_title'])) {
                            //     $query->whereHas('translations', function ($translationQuery) use ($request) {
                            //         $translationQuery->where('locale','en')->where('title', 'like', "%" . $request['search']['search_title'] . "%");
                            //     });
                            //}
                            if (isset($request['search']['search_sanskrit_title']) && !is_null($request['search']['search_sanskrit_title'])) {
                                $query->where('mantras.sanskrit_title', 'like', "%" . $request['search']['search_sanskrit_title'] . "%");
                            }
                            if (isset($request['search']['search_status']) && !is_null($request['search']['search_status'])) {
                                $query->where('mantras.status', 'like', "%" . $request['search']['search_status'] . "%");
                            }
                            if (isset($request['search']['search_sequence']) && !is_null($request['search']['search_sequence'])) {
                                $query->where('sequence', 'like', "%" . $request['search']['search_sequence'] . "%");
                            }
                            $query->get()->toArray();
                        // })->editColumn('title_'.\App::getLocale(), function ($event) {
                        //     $Key_index = array_search(\App::getLocale(), array_column($event->translations->toArray(), 'locale'));
                        //     return $event['translations'][$Key_index]['title'];
                        })->editColumn('sanskrit_title',function ($event) {
                        return $event['sanskrit_title'];
                        
                        })->editColumn('sequence',function ($event) {
                            return $event['sequence'];
                        })
                        ->editColumn('action', function ($event) {
                            $mantra_view = checkPermission('mantra_view');
                            $mantra_add = checkPermission('mantra_add');
                            $mantra_edit = checkPermission('mantra_edit');
                            $mantra_status = checkPermission('mantra_status');
                            $mantra_delete = checkPermission('mantra_delete');
                            $actions = '<span style="white-space:nowrap;">';
                            if ($mantra_view) {
                                $actions .= '<a href="mantras/view/' . $event['id'] . '" class="btn btn-primary btn-sm src_data" data-size="large" data-title="View Mantra Details" title="View"><i class="fa fa-eye"></i></a>';
                            }
                            if ($mantra_edit) {
                                $actions .= ' <a href="mantras/edit/' . $event['id'] . '" class="btn btn-success btn-sm src_data" title="Update"><i class="fa fa-edit"></i></a>';
                            }
                            if ($mantra_delete) {
                                $actions .= ' <a data-option="" data-url="mantras/delete/' . $event->id . '" class="btn btn-danger btn-sm delete-data" title="delete"><i class="fa fa-trash"></i></a>';
                            }
                            if ($mantra_status) {
                                if ($event->status == '1') {
                                    $actions .= ' <input type="checkbox" data-url="mantras/publish" id="switchery' . $event->id . '" data-id="' . $event->id . '" class="js-switch switchery" checked>';
                                } else {
                                    $actions .= ' <input type="checkbox" data-url="mantras/publish" id="switchery' . $event->id . '" data-id="' . $event->id . '" class="js-switch switchery">';
                                }
                            }
                            $actions .= '</span>';
                            return $actions;
                        })
                        ->addIndexColumn()
                        ->rawColumns(['sanskrit_title','sequence', 'action'])->setRowId('id')->make(true);
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
                $mantra = Mantra::find($request->id);
                $mantra->status = $request->status;
                $mantra->save();
                if ($request->status == 1) {
                    successMessage(trans('message.enable'), $msg_data);
                } else {
                    errorMessage(trans('message.disable'), $msg_data);
                }
                errorMessage('Mantra not found', []);
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
        $data['translated_block'] = Mantra::TRANSLATED_BLOCK;
        return view('backend/mantras/add',$data);
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
        $translated_keys = array_keys(Mantra::TRANSLATED_BLOCK);
        foreach ($translated_keys as $value) {
            $input[$value] = (array) json_decode($input[$value]);
        }
        $saveArray = Utils::flipTranslationArray($input, $translated_keys);
        $data = Mantra::create($saveArray);
        successMessage('Data Saved successfully', []);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Mantra  $mantra
     * @return \Illuminate\Http\Response
     */
    public function view($id)
    {
        $data['mantras'] = Mantra::find($id);
        foreach($data['mantras']['translations'] as $trans) {
            $translated_keys = array_keys(Mantra::TRANSLATED_BLOCK);
            foreach ($translated_keys as $value) {
                $data['mantras'][$value.'_'.$trans['locale']] = $trans[$value];
            }
        }
        $data['translated_block'] = Mantra::TRANSLATED_BLOCK;
        return view('backend/mantras/view',$data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Mantra  $mantra
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['mantras'] = Mantra::find($id);
        foreach($data['mantras']['translations'] as $trans) {
            $translated_keys = array_keys(Mantra::TRANSLATED_BLOCK);
            foreach ($translated_keys as $value) {
                $data['mantras'][$value.'_'.$trans['locale']] = str_replace("<br/>", "\r\n", $trans[$value]);
            }
        }
        $data['translated_block'] = Mantra::TRANSLATED_BLOCK;
        return view('backend/mantras/edit',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Mantra  $mantra
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Mantra $mantra)
    {
        $data = Mantra::find($_GET['id']);
        $input=$request->all();
        if (!$data) {
            errorMessage('Mantra Not Found', []);
        }
        $translated_keys = array_keys(Mantra::TRANSLATED_BLOCK);
        foreach ($translated_keys as $value)
        {
            $input[$value] = (array) json_decode($input[$value]);
        }
        $mantra = Utils::flipTranslationArray($input, $translated_keys);
        $data->update($mantra);
        successMessage('Data Updated successfully', []);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Mantra  $mantra
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data= Mantra::find($id);
        $data->delete();
        successMessage('Data Deleted successfully', []);
    }
}
