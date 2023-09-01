<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Video;
use App\Utils\Utils;
use Illuminate\Http\Request;
use App\Models\Banner;
use Yajra\DataTables\DataTables;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['banners_view'] = checkPermission('banners_view');
        $data['banners_add'] = checkPermission('banners_add');
        $data['banners_edit'] = checkPermission('banners_edit');
        $data['banners_status'] = checkPermission('banners_status');
        $data['banners_delete'] = checkPermission('banners_delete');
        return view('backend/banners/index',["data"=>$data]);
    }

    public function fetch(Request $request)
    {
        if ($request->ajax()) {
            try {
                $query = Banner::orderBy('updated_at','desc');
                return DataTables::of($query)
                    ->filter(function ($query) use ($request) {
                        if (isset($request['search']['search_status']) && !is_null($request['search']['search_status'])) {
                            $query->where('status', 'like', "%" . $request['search']['search_status'] . "%");
                        }
                        if (isset($request['search']['search_sequence']) && !is_null($request['search']['search_sequence'])) {
                            $query->where('sequence', 'like', "%" . $request['search']['search_sequence'] . "%");
                        }
                        if
                        (isset($request['search']['search_title']) && !is_null($request['search']['search_title'])) {
                            $query->where('title', 'like', "%" . $request['search']['search_title'] . "%");
                        }
                        $query->get()->toArray();
                    })
                    ->editColumn('title',function ($event) {
                        return $event['title'];
                    })
                    ->editColumn('sequence',function ($event) {
                        return $event['sequence'];
                    })
                    ->editColumn('action', function ($event) {
                        $banners_view = checkPermission('banners_view');
                        $banners_add = checkPermission('banners_add');
                        $banners_edit = checkPermission('banners_edit');
                        $banners_status = checkPermission('banners_status');
                        $banners_delete = checkPermission('banners_delete');
                        $actions = '<span style="white-space:nowrap;">';
                        if ($banners_view) {
                            $actions .= '<a href="banners/view/' . $event['id'] . '" class="btn btn-primary btn-sm modal_src_data" data-size="large" data-title="View Banner Details" title="View"><i class="fa fa-eye"></i></a>';
                        }
                        if ($banners_edit) {
                            $actions .= ' <a href="banners/edit/' . $event['id'] . '" class="btn btn-success btn-sm src_data" title="Update"><i class="fa fa-edit"></i></a>';
                        }
                        if ($banners_delete) {
                            $actions .= ' <a data-option="" data-url="banners/delete/' . $event->id . '" class="btn btn-danger btn-sm delete-data" title="delete"><i class="fa fa-trash"></i></a>';
                        }
                        if ($banners_status) {
                            if ($event->status == '1') {
                                $actions .= ' <input type="checkbox" data-url="banners/publish" id="switchery' . $event->id . '" data-id="' . $event->id . '" class="js-switch switchery" checked>';
                            } else {
                                $actions .= ' <input type="checkbox" data-url="banners/publish" id="switchery' . $event->id . '" data-id="' . $event->id . '" class="js-switch switchery">';
                            }
                        }
                        $actions .= '</span>';
                        return $actions;
                    })
                    ->addIndexColumn()
                    ->rawColumns(['title','sequence','action'])->setRowId('id')->make(true);
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
            $language = Banner::find($request->id);
            $language->status = $request->status;
            $language->save();
            if ($request->status == 1) {
                successMessage('Enable', $msg_data);
            } else {
                successMessage('Disable', $msg_data);
            }
            errorMessage('Banner not found', []);
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

        return view('backend/banners/add');
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
        $data = Banner::create($input);
        storeMedia($data, $input['cover'], Banner::COVER);
        successMessage('Data Saved successfully', []);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function view($id)
    {
        $data['banners'] = Banner::find($id);

        $data['media'] = $data['banners']->getMedia(Banner::COVER)[0];


        return view('backend/banners/view')->with($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['banners'] = Banner::find($id);
        $data['media'] =$data['banners']->getMedia(Banner::COVER)[0];
        return view('backend/banners/edit')->with($data);
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
        $data = Banner::find($_GET['id']);
        $input=$request->all();
        if (!$data) {
            errorMessage('Banner Not Found', []);
        }
        $data->update($input);
        if(!empty($input['cover'])){
            $data->clearMediaCollection(Banner::COVER);
            storeMedia($data, $input['cover'], Banner::COVER);
        }
        successMessage('Data Saved successfully', []);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data= Banner::find($id);
        $data->delete();
        successMessage('Data Deleted successfully', []);

    }
}
