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
        $data['customer_verify'] = checkPermission('customer_verify');
        $data['customer_view'] = checkPermission('customer_view');
        $data['customer_status'] = checkPermission('customer_status');
        $data['customer_change_password'] = checkPermission('customer_change_password');
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
                        $customer_verify = checkPermission('customer_verify');
                        $customer_view = checkPermission('customer_view');
                        $customer_status = checkPermission('customer_status');
                        $customer_change_password = checkPermission('customer_change_password');
                        $actions = '<span style="white-space:nowrap;">';
                        if ($customer_view) {
                            $actions .= '<a href="customer/view/' . $event->id . '" class="btn btn-primary btn-sm modal_src_data" data-size="large" data-title="View customer Details" title="View"><i class="fa fa-eye"></i></a>';
                        }
                        if ($customer_change_password) {
                            $actions .= ' <a href="customer/change_password/' . $event->id . '" class="btn btn-success btn-sm modal_src_data" data-size="large" data-title="Change Customer Password" title="Change Password"><i class="fa fa-key"></i></a>';
                        }
                        if ($customer_verify) {
                            if($event->is_verified == 'N'){
                                $actions .= ' <a data-option="" data-url="customer/verify/' . $event->id . '" class="btn btn-success btn-sm verify-data" title="Verify"><i class="fa fa-check" aria-hidden="true"></i></a>';
                            }
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

    public function isVerify(Request $request,$id)
    {
        $data = User::find($id);
        $input['is_verified'] = 'Y';
        $data->update($input);
        successMessage('Customer Verify Successfully',[]);
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

    public function changePassword($id) {
        $data['customer'] = User::find($id);
        return view('backend/customer/change_password',$data);
    }

    public function changeCustomerPassword(Request $request)
    {
        $msg_data = array();
        $users = User::find($_GET['id']);
        if ($request->new_password != $request->confirm_password) {
            errorMessage('Password not matched!', $msg_data);
        }

        if ($users->password == md5($users->email . $request->new_password)) {
            errorMessage(__('change_password.new_password_cannot_same_current_password'), $msg_data);
        }

        $users->password = md5($users->email . $request->new_password);
        $users->save();
        successMessage('Password updated successfully!', $msg_data);
        //return back()->with('success','Password updated successfully!');
    }
}
