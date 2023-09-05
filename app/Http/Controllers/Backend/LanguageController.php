<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Language;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class LanguageController extends Controller
{
    public function index()
    {
        $data['language_view'] = checkPermission('language_view');
        $data['language_add'] = checkPermission('language_add');
        $data['language_edit'] = checkPermission('language_edit');
        $data['language_status'] = checkPermission('language_status');
        $data['language_delete'] = checkPermission('language_delete');
        return view('backend/language/index',['data' => $data]);
    }

    public function fetch(Request $request)
    {
        if ($request->ajax()) {
            try {
                $query = Language::orderBy('id','desc');
                // print_r($query->get());exit;
                return DataTables::of($query)
                    ->filter(function ($query) use ($request) {
                        if (isset($request['search']['language_name']) && !is_null($request['search']['language_name'])) {
                            $query->where('language_name', 'like', "%" . $request['search']['language_name'] . "%");
                        }
                        if (isset($request['search']['language_code']) && !is_null($request['search']['language_code'])) {
                            $query->where('language_code', 'like', "%" . $request['search']['language_code'] . "%");
                        }
                        $query->get()->toArray();
                    })
                    ->editColumn('language_name', function ($event) {
                        return $event->language_name;
                    })
                    ->editColumn('action', function ($event) {
                        $language_add = checkPermission('language_add');
                        $language_view = checkPermission('language_view');
                        $language_edit = checkPermission('language_edit');
                        $language_delete = checkPermission('language_delete');
                        $language_status = checkPermission('language_status');
                        $actions = '<span style="white-space:nowrap;">';
                        if ($language_view) {
                            $actions .= '<a href="language/view/' . $event->id . '" class="btn btn-primary btn-sm modal_src_data" data-size="large" data-title="View Language" title="View Language"><i class="fa fa-eye"></i></a>';
                        }
                        if ($language_edit) {
                            $actions .= ' <a href="language/edit/' . $event['id'] . '" class="btn btn-success btn-sm src_data" title="Update"><i class="fa fa-edit"></i></a>';
                        }
                        if ($language_delete) {
                            $actions .= ' <a data-option="" data-url="language/delete/' . $event->id . '" class="btn btn-danger btn-sm delete-data" title="delete"><i class="fa fa-trash"></i></a>';
                        }
                        if ($language_status) {
                            if ($event->status == '1') {
                                $actions .= ' <input type="checkbox" data-url="language/publish" id="switchery' . $event->id . '" data-id="' . $event->id . '" class="js-switch switchery" checked>';
                            } else {
                                $actions .= ' <input type="checkbox" data-url="language/publish" id="switchery' . $event->id . '" data-id="' . $event->id . '" class="js-switch switchery">';
                            }
                        }
                        $actions .= '</span>';
                        return $actions;
                    })
                    ->addIndexColumn()
                    ->rawColumns(['language_name','action'])->setRowId('id')->make(true);
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

    function view($id){
        $data['data'] = Language::find($id);
        return view('backend/language/view',$data);
    }

    public function updateStatus(Request $request)
    {
        try {
            $msg_data = array();
            $language = Language::find($request->id);
            $language->status = $request->status;
            $language->save();
            if ($request->status == 1) {
                successMessage('Enable', $msg_data);
            } else {
                successMessage('Disable', $msg_data);
            }
            errorMessage('language not found', []);
        } catch (\Exception $e) {
            errorMessage(trans('auth.something_went_wrong'));
        }
    }
    public function add(Request $request)
    {
        return view('backend/language/add');
    }

    public function store(Request $request)
    {
		$input = $request->all();
        $data = Language::create($input);
        successMessage('Data Saved successfully', []);
    }

    public function edit($id)
    {
        $data['data'] = Language::find($id);
		return view('backend/language/edit',$data);
    }

    public function update(Request $request)
    {
        $data = Language::find($_GET['id']);
        $input=$request->all();
        if (!$data) {
            errorMessage('Language Not Found', []);
        }
        $data->update($input);
        if(!empty($input['image'])){
            $data->clearMediaCollection(Language::IMAGE);
            storeMedia($data, $input['image'], Language::IMAGE);
        }
        successMessage('Data Saved successfully', []);
    }

    public function destroy($id)
    {
        $data = Language::find($id);
        $data->delete();
        successMessage('Data Deleted Successfully',[]);
    }
}
