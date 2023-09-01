<?php

namespace App\Http\Controllers\Backend;
use App\Http\Controllers\Controller;
use Yajra\DataTables\DataTables;
use App\Models\Ashram;
use App\Models\Location;
use App\Models\LocationTranslation;
use App\Utils\Utils;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class AshramController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['ashram_add'] = checkPermission('ashram_add');
        $data['ashram_edit'] = checkPermission('ashram_edit');
        $data['ashram_view'] = checkPermission('ashram_view');
        $data['ashram_status'] = checkPermission('ashram_status');
        $data['ashram_delete'] = checkPermission('ashram_delete');
        return view('backend/ashram/index',['data' =>$data]);
    }

    public function fetch(Request $request)
    {
        if ($request->ajax()) {
            try {
                $query = Location::leftJoin('LocationTranslation', function ($join) {
                                        $join->on("location_translations.location_id", '=', "location.id");
                                        $join->where('location_translations.locale', \App::getLocale());
                                     })
                                     ->select('location.*')
                                     ->orderBy('updated_at','desc');;
                return DataTables::of($query)
                    ->filter(function ($query) use ($request) {
                        if (isset($request['search']['search_name']) && !is_null($request['search']['search_name'])) {
                            $query->where('name', 'like', "%" . $request['search']['search_name'] . "%");
                        }
                        if (isset($request['search']['search_title']) && !is_null($request['search']['search_title'])) {
                            $query->where('title', 'like', "%" . $request['search']['search_title'] . "%");
                        }
                        if (isset($request['search']['search_location']) && !is_null($request['search']['search_location'])) {
                            $query->where('location', 'like', "%" . $request['search']['search_location'] . "%");
                        }
                        $query->get()->toArray();
                    })
                    ->editColumn('name', function ($event) {
                        return $event['name'];
                    })->editColumn('short_description', function ($event) {
                        return $event['short_description'];
                    })->editColumn('location', function ($event) {
                        return $event['location'];
                    })
                    ->editColumn('action', function ($event) {
                        $ashram_edit = checkPermission('ashram_edit');
                        $ashram_view = checkPermission('ashram_view');
                        $ashram_status = checkPermission('ashram_status');
                        $ashram_delete = checkPermission('ashram_delete');
                        $actions = '<span style="white-space:nowrap;">';
                        if ($ashram_view) {
                            $actions .= '<a href="ashram/view/' . $event['id'] . '" class="btn btn-primary btn-sm src_data" data-size="large" data-title="View Ashram Details" title="View"><i class="fa fa-eye"></i></a>';
                        }
                        if ($ashram_edit) {
                            $actions .= ' <a href="ashram/edit/' . $event['id'] . '" class="btn btn-success btn-sm src_data" title="Update"><i class="fa fa-edit"></i></a>';
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
        $data['translated_block'] = Location::TRANSLATED_BLOCK;

        return view('backend/ashram/add1',$data);
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

        $translated_keys = array_keys(Location::TRANSLATED_BLOCK);
        foreach ($translated_keys as $value) {
            $input[$value] = (array) json_decode($input[$value]);
        }
        $saveArray = Utils::flipTranslationArray($input, $translated_keys);
        // echo "<pre>";
        // print_r($saveArray);
        // echo "</pre>";
        // die("Debug");
        $data = Location::create($saveArray);
        storeMedia($data, $input['image'], Location::IMAGE);
        successMessage('Data Saved successfully', []);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Ashram  $ashram
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data['ashram'] = Ashram::find($id);
        $data['media'] = $data['ashram']->getMedia(Ashram::IMAGE)[0]; // need to make dynamic index to replace image
        return view('backend/ashram/view',$data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Ashram  $ashram
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['ashram'] = Ashram::find($id);
        return view('backend/ashram/edit',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Ashram  $ashram
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Ashram $ashram)
    {
        $data = Ashram::find($_GET['id']);
        $input = $request->all();
        if (!$data) {
            errorMessage('Ashram Not Found', []);
        }
        $data->update($input);

        if(!empty($input['image'])){
            $data->clearMediaCollection(Ashram::IMAGE);
            storeMedia($data, $input['image'], Ashram::IMAGE);
        }
        successMessage('Data Updated successfully', []);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Ashram  $ashram
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ashram $ashram)
    {
        //
    }
}
