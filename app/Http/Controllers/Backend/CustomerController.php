<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\User;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use App\Utils\Utils;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['customer_edit'] = checkPermission('customer_edit');
        $data['customer_view'] = checkPermission('customer_view');
        $data['customer_status'] = checkPermission('customer_status');
        $data['customer_delete'] = checkPermission('customer_delete');
        return view('backend/customer/index',['data' =>$data]);
    }

    public function fetch(Request $request)
    {
        if ($request->ajax()) {
            try {
                $query = User::orderBy('updated_at','desc');
                // print_r($query->get());exit;
                return DataTables::of($query)
                    ->filter(function ($query) use ($request) {
                        if ($request['search']['search_email'] && !is_null($request['search']['search_email'])) {
                            $query->where('email', 'like', "%" . $request['search']['search_email'] . "%");
                        }
                        if ($request['search']['search_name'] && !is_null($request['search']['search_name'])) {
                            $query->where('name', 'like', "%" . $request['search']['search_name'] . "%");
                        }
                        if ($request['search']['search_status'] && !is_null($request['search']['search_status'])) {
                            $query->where('status', 'like', "%" . $request['search']['search_status'] . "%");
                        }
                        $query->get();
                    })
                    ->editColumn('name', function ($event) {
                        return $event->name;
                    })
                    ->editColumn('email', function ($event) {
                        return $event->email;
                    })
                    ->editColumn('phone', function ($event) {
                        return  $event->phone;
                    })
                    ->editColumn('action', function ($event) {
                        $customer_edit = checkPermission('customer_edit');
                        $customer_view = checkPermission('customer_view');
                        $customer_status = checkPermission('customer_status');
                        $customer_delete = checkPermission('customer_delete');
                        $actions = '<span style="white-space:nowrap;">';
                        if ($customer_view) {
                            $actions .= '<a href="customer/view/' . $event->id . '" class="btn btn-primary btn-sm modal_src_data" data-size="large" data-title="View customer Details" title="View"><i class="fa fa-eye"></i></a>';
                        }
                        if ($customer_edit) {
                            $actions .= ' <a href="customer/edit/' . $event->id . '" class="btn btn-success btn-sm src_data" title="Update"><i class="fa fa-edit"></i></a>';
                        }
                        if ($customer_status) {
                            if ($event->status == '1') {
                                $actions .= ' <input type="checkbox" data-url="customer/publish" id="switchery' . $event->id . '" data-id="' . $event->id . '" class="js-switch switchery" checked>';
                            } else {
                                $actions .= ' <input type="checkbox" data-url="customer/publish" id="switchery' . $event->id . '" data-id="' . $event->id . '" class="js-switch switchery">';
                            }
                        }

                        return $actions;
                    })
                    ->addIndexColumn()
                    ->rawColumns(['name', 'email', 'phone', 'action'])->setRowId('id')->make(true);
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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data['customer'] = User::find($id);
        return view('backend/customer/view',$data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['data'] = User::find($id);
		return view('backend/customer/edit',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $data = User::find($_GET['id']);
        $input=$request->all();
        $input['is_verified'] = $request->is_verified ? 'Y': 'N';
        // print_r($input);exit;
        $data->update($input);
        successMessage('Data Saved successfully', []);
    }

    public function updateStatus(Request $request)
    {
        try {
            $msg_data = array();
            $users = User::find($request->id);
            $users->status = $request->status;
            $users->save();
            if ($request->status == 1) {
                successMessage(trans('message.enable'), $msg_data);
            } else {
                errorMessage(trans('message.disable'), $msg_data);
            }
            errorMessage('Customer not found', []);
        } catch (\Exception $e) {
            errorMessage(trans('auth.something_went_wrong'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Customer $customer)
    {
        //
    }
}
