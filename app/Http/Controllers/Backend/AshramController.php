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
                $query = Location::orderBy('updated_at','desc');
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
                        if (isset($request['search']['search_location']) && !is_null($request['search']['search_location'])) {
                            $query->where('location', 'like', "%" . $request['search']['search_location'] . "%");
                        }
                        if (isset($request['search']['search_status']) && !is_null($request['search']['search_status'])) {
                            $query->where('status', $request['search']['search_status']);
                        }
                        $query->get()->toArray();
                    })
                    ->editColumn('name_'.\App::getLocale(), function ($event) {
                        $Key_index = array_search(\App::getLocale(), array_column($event->translations->toArray(), 'locale'));
                        return $event['translations'][$Key_index]['name'];
                    })->editColumn('title_'.\App::getLocale(), function ($event) {
                        $Key_index = array_search(\App::getLocale(), array_column($event->translations->toArray(), 'locale'));
                        return $event['translations'][$Key_index]['title'];
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
                    ->rawColumns(['name_'.\App::getLocale(), 'title_'.\App::getLocale(),'location','status', 'action'])->setRowId('id')->make(true);
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

        return view('backend/ashram/add',$data);
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
        $working_days_data = [
            "monday_open"     => $input['monday_open'] ?? "off",
            "monday_start_time"    => !empty($input['monday_open']) ? $input['monday_start_time'] ?? '' :'',
            "monday_end_time"      => !empty($input['monday_open']) ? $input['monday_end_time'] ?? '' :'',
            "tuesday_open"    => $input['tuesday_open'] ?? "off",
            "tuesday_start_time"   => !empty($input['tuesday_open']) ? $input['tuesday_start_time'] ?? '' :'',
            "tuesday_end_time"     => !empty($input['tuesday_open']) ? $input['tuesday_end_time'] ?? '' :'',
            "wednesday_open"  => $input['wednesday_open'] ?? "off",
            "wednesday_start_time" => !empty($input['wednesday_open']) ? $input['wednesday_start_time'] ?? '' :'',
            "wednesday_end_time"   => !empty($input['wednesday_open']) ? $input['wednesday_end_time'] ?? '' :'',
            "thursday_open"   => $input['thursday_open'] ?? "off",
            "thursday_start_time"  => !empty($input['thursday_open']) ? $input['thursday_start_time'] ?? '' :'',
            "thursday_end_time"    => !empty($input['thursday_open']) ? $input['thursday_end_time'] ?? '' :'',
            "friday_open"     => $input['friday_open'] ?? "off",
            "friday_start_time"    => !empty($input['friday_open']) ? $input['friday_start_time'] ?? '' :'',
            "friday_end_time"      => !empty($input['friday_open']) ? $input['friday_end_time'] ?? '' :'',
            "saturday_open"   => $input['saturday_open'] ?? "off",
            "saturday_start_time"  => !empty($input['saturday_open']) ? $input['saturday_start_time'] ?? '' :'',
            "saturday_end_time"    => !empty($input['saturday_open']) ? $input['saturday_end_time'] ?? '' :'',
            "sunday_open"   => $input['sunday_open'] ?? "off",
            "sunday_start_time"  => !empty($input['sunday_open']) ? $input['sunday_start_time'] ?? '' :'',
            "sunday_end_time"    => !empty($input['sunday_open']) ? $input['sunday_end_time'] ?? '' :''
        ];

        $input['working_days'] = json_encode($working_days_data);

        if ($input['phone']) {
            $phone_array = explode(',', $input['phone']);
            $input['phone'] = json_encode($phone_array);
        }
        $translated_keys = array_keys(Location::TRANSLATED_BLOCK);
        foreach ($translated_keys as $value) {
            $input[$value] = (array) json_decode($input[$value]);
        }
        $saveArray = Utils::flipTranslationArray($input, $translated_keys);
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
        $data['ashram'] = Location::find($id);
        foreach($data['ashram']['translations'] as $trans) {
            $translated_keys = array_keys(Location::TRANSLATED_BLOCK);
            foreach ($translated_keys as $value) {
                $data['ashram'][$value.'_'.$trans['locale']] = $trans[$value];
            }
        }
        $data['translated_block'] = Location::TRANSLATED_BLOCK;
        if (!empty($data['ashram']->getMedia(Location::IMAGE))) {
            $media = $data['ashram']->getMedia(Location::IMAGE);
            if (isset($media[0])) {
                $data['media'] = $media[0];
            }
        }
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
        $data['ashram'] = Location::find($id);
        $working_days_data = json_decode($data['ashram']['working_days'],true);
        $data['working_days'] = $working_days_data;
        foreach($data['ashram']['translations'] as $trans) {
            $translated_keys = array_keys(Location::TRANSLATED_BLOCK);
            foreach ($translated_keys as $value) {
                $data['ashram'][$value.'_'.$trans['locale']] = str_replace("<br/>", "\r\n", $trans[$value]);
            }
        }
        $data['translated_block'] = Location::TRANSLATED_BLOCK;
        if (!empty($data['ashram']->getMedia(Location::IMAGE))) {
            $media = $data['ashram']->getMedia(Location::IMAGE);
            if (isset($media[0])) {
                $data['media'] = $media[0];
            }
        }
        return view('backend/ashram/edit',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Ashram  $ashram
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $data = Location::find($_GET['id']);
        $input=$request->all();
        $working_days_data = [
            "monday_open"     => $input['monday_open'] ?? "off",
            "monday_start_time"    => !empty($input['monday_open']) ? $input['monday_start_time'] ?? '' :'',
            "monday_end_time"      => !empty($input['monday_open']) ? $input['monday_end_time'] ?? '' :'',
            "tuesday_open"    => $input['tuesday_open'] ?? "off",
            "tuesday_start_time"   => !empty($input['tuesday_open']) ? $input['tuesday_start_time'] ?? '' :'',
            "tuesday_end_time"     => !empty($input['tuesday_open']) ? $input['tuesday_end_time'] ?? '' :'',
            "wednesday_open"  => $input['wednesday_open'] ?? "off",
            "wednesday_start_time" => !empty($input['wednesday_open']) ? $input['wednesday_start_time'] ?? '' :'',
            "wednesday_end_time"   => !empty($input['wednesday_open']) ? $input['wednesday_end_time'] ?? '' :'',
            "thursday_open"   => $input['thursday_open'] ?? "off",
            "thursday_start_time"  => !empty($input['thursday_open']) ? $input['thursday_start_time'] ?? '' :'',
            "thursday_end_time"    => !empty($input['thursday_open']) ? $input['thursday_end_time'] ?? '' :'',
            "friday_open"     => $input['friday_open'] ?? "off",
            "friday_start_time"    => !empty($input['friday_open']) ? $input['friday_start_time'] ?? '' :'',
            "friday_end_time"      => !empty($input['friday_open']) ? $input['friday_end_time'] ?? '' :'',
            "saturday_open"   => $input['saturday_open'] ?? "off",
            "saturday_start_time"  => !empty($input['saturday_open']) ? $input['saturday_start_time'] ?? '' :'',
            "saturday_end_time"    => !empty($input['saturday_open']) ? $input['saturday_end_time'] ?? '' :'',
            "sunday_open"   => $input['sunday_open'] ?? "off",
            "sunday_start_time"  => !empty($input['sunday_open']) ? $input['sunday_start_time'] ?? '' :'',
            "sunday_end_time"    => !empty($input['sunday_open']) ? $input['sunday_end_time'] ?? '' :''
        ];

        $input['working_days'] = json_encode($working_days_data);
        if ($input['phone']) {
            $phone_array = explode(',', $input['phone']);
            $input['phone'] = json_encode($phone_array);
        }
        if (!$data) {
            errorMessage('Ashram Not Found', []);
        }
        $translated_keys = array_keys(Location::TRANSLATED_BLOCK);
        foreach ($translated_keys as $value)
        {
            $input[$value] = (array) json_decode($input[$value]);
        }
        $ashram = Utils::flipTranslationArray($input, $translated_keys);
        $data->update($ashram);
        if(!empty($input['image'])){
            $data->clearMediaCollection(Location::IMAGE);
            storeMedia($data, $input['image'], Location::IMAGE);
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

    public function deleteImage(Request $request)
    {
        $msg_data = array();
        $data = Location::find($_GET['id']);
        $data->clearMediaCollection(Location::IMAGE);
        successMessage('image deleted successfully', $msg_data);
    }
}
