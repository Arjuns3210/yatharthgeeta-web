<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Customer;
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
        return view('backend/customer/index');
    }

    public function fetch(Request $request)
    {
        if ($request->ajax()) {
            try {
                $query = User::orderBy('updated_at','desc');
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
                    ->editColumn('name', function ($event) {
                        return $event['name'][$Key_index]['title'];
                    })
                    ->editColumn('email', function ($event) {
                        return $event['email'];
                    })
                    ->editColumn('phone', function ($event) {
                        return $event['phone'];
                    })
                    ->editColumn('action', function ($event) {
                        $customer_edit = checkPermission('customer_edit');
                        $customer_view = checkPermission('customer_view');
                        $customer_status = checkPermission('customer_status');
                        $customer_delete = checkPermission('customer_delete');
                        $actions = '<span style="white-space:nowrap;">';
                        if ($customer_view) {
                            $actions .= '<a href="customer/view/' . $event['id'] . '" class="btn btn-primary btn-sm src_data" data-size="large" data-title="View customer Details" title="View"><i class="fa fa-eye"></i></a>';
                        }
                        if ($customer_edit) {
                            $actions .= ' <a href="customer/edit/' . $event['id'] . '" class="btn btn-success btn-sm src_data" title="Update"><i class="fa fa-edit"></i></a>';
                        }
                        $actions .= '</span>';
                        return $actions;
                    })
                    ->addIndexColumn()
                    ->rawColumns(['name', 'email', 'phone','status', 'action'])->setRowId('id')->make(true);
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
    public function show(Customer $customer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function edit(Customer $customer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Customer $customer)
    {
        //
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
