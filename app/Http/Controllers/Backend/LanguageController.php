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
        $data['language_status'] = checkPermission('language_status');
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
                        $query->get()->toArray();
                    })
                    ->editColumn('language_name', function ($event) {
                        return $event->language_name;
                    })
                    ->editColumn('action', function ($event) {
                        $language_view = checkPermission('language_view');
                        $language_status = checkPermission('language_status');
                        $actions = '<span style="white-space:nowrap;">';
                        if ($language_view) {
                            $actions .= '<a href="language/view/' . $event->id . '" class="btn btn-primary btn-sm modal_src_data" data-size="large" data-title="View Language" title="View Language"><i class="fa fa-eye"></i></a>';
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
}
