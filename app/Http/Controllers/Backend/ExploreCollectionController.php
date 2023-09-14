<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateExploreCollectionRequest;
use App\Http\Requests\CreateHomeCollectionRequest;
use App\Http\Requests\UpdateExploreCollectionRequest;
use App\Http\Requests\UpdateHomeCollectionRequest;
use App\Models\Artist;
use App\Models\Audio;
use App\Models\Book;
use App\Models\BookCategory;
use App\Models\ExploreCollection;
use App\Models\HomeCollection;
use App\Models\HomeCollectionMapping;
use App\Models\Language;
use App\Models\Mantra;
use App\Models\Quote;
use App\Models\Shlok;
use App\Models\Video;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;
use Ramsey\Collection\Collection;
use Yajra\DataTables\DataTables;

class ExploreCollectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['explore_collection_add'] = checkPermission('explore_collection_add');
        $data['explore_collection_view'] = checkPermission('explore_collection_view');
        $data['explore_collection_edit'] = checkPermission('explore_collection_edit');
        $data['explore_collection_status'] = checkPermission('explore_collection_status');
        $data['collection_types'] = ExploreCollection::EXPLORE_COLLECTION_TYPES;

        return view('backend/explore_collection/index', ["data" => $data]);
    }


    public function fetch(Request $request)
    {
        if ($request->ajax()) {
            try {
                $query = ExploreCollection::with('language')
                    ->select('*')->orderBy('updated_at','desc');
                return DataTables::of($query)
                    ->filter(function ($query) use ($request) {
                        if (isset($request['search']['search_collection_title']) && !is_null($request['search']['search_collection_title'])) {
                            $query->where('title', 'like', "%" . $request['search']['search_collection_title'] . "%");
                        }
                        if (isset($request['search']['search_collection_type']) && !is_null($request['search']['search_collection_type'])) {
                            $query->where('type',$request['search']['search_collection_type']);
                        }
                        if (isset($request['search']['search_status']) && !is_null($request['search']['search_status'])) {
                            $query->where('status', 'like', "%" . $request['search']['search_status'] . "%");
                        }
                        if (isset($request['search']['search_sequence']) && !is_null($request['search']['search_sequence'])) {
                            $query->where('sequence', 'like', "%" . $request['search']['search_sequence'] . "%");
                        }
                        $query->get();
                    })
                    ->editColumn('title', function ($event) {
                        return $event->title ?? '';

                    })
                    ->editColumn('type', function ($event) {
                        
                        return ExploreCollection::EXPLORE_COLLECTION_TYPES[$event->type] ?? '';
                    })
                    ->editColumn('sequence', function ($event) {

                        return $event->sequence ?? '';
                    })
                    ->editColumn('action', function ($event) {
                        $explore_collection_edit = checkPermission('explore_collection_edit');
                        $explore_collection_view = checkPermission('explore_collection_view');
                        $explore_collection_status = checkPermission('explore_collection_status');
                        $explore_collection_delete = checkPermission('explore_collection_delete');
                        $is_head = session('data')['is_head'] ?? false;
                        $actions = '<span style="white-space:nowrap;">';
                        if ($explore_collection_view) {
                            $actions .= '<a href="explore_collection/view/' . $event['id'] . '" class="btn btn-primary btn-sm src_data" data-size="large" data-title="View Book Details" title="View"><i class="fa fa-eye"></i></a>';
                        }
                        if ($explore_collection_edit) {
                            $actions .= ' <a href="explore_collection/edit/' . $event['id'] . '" class="btn btn-success btn-sm src_data" title="Update"><i class="fa fa-edit"></i></a>';
                        }
                        if ($explore_collection_delete && $is_head) {
                            $dataUrl = $event->title ?? '';
                            $actions .= ' <a data-option="'.$dataUrl.'" data-url="explore_collection/delete/'.$event->id.'" class="btn btn-danger btn-sm delete-data" title="delete"><i class="fa fa-trash"></i></a>';
                        }
                        if ($explore_collection_status) {
                            if ($event->status == '1') {
                                $actions .= ' <input type="checkbox" data-url="explore_collection/publish" id="switchery' . $event->id . '" data-id="' . $event->id . '" class="js-switch switchery" checked>';
                            } else {
                                $actions .= ' <input type="checkbox" data-url="explore_collection/publish" id="switchery' . $event->id . '" data-id="' . $event->id . '" class="js-switch switchery">';
                            }
                        }
                        $actions .= '</span>';
                        return $actions;
                    })
                    ->addIndexColumn()
                    ->rawColumns(['title','sequence', 'action'])->setRowId('id')->make(true);
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
        $localeLanguage = \App::getLocale();
        if (str_contains($localeLanguage, 'en')) {
            $localeLanguage = 'en';
        } else {
            $localeLanguage = 'hi';
        }
        $data['translated_block'] = [];
        $data['collection_types'] = ExploreCollection::EXPLORE_COLLECTION_TYPES;
        $data['books'] = Book::with([
            'translations' => function ($query) use ($localeLanguage) {
                $query->where('locale', $localeLanguage);
            },
        ])->where('status', 1)->get();
        $data['audios'] = Audio::with([
            'translations' => function ($query) use ($localeLanguage) {
                $query->where('locale', $localeLanguage);
            },
        ])->where('type',Audio::PRAVACHAN)->where('status', 1)->get();
        $data['quotes'] = Quote::where('status', 1)->get();
        $data['mantras'] = Mantra::with([
            'translations' => function ($query) use ($localeLanguage) {
                $query->where('locale', $localeLanguage);
            },
        ])->where('status', 1)->get();
        $data['languages'] = Language::with([
            'translations' => function ($query) use ($localeLanguage) {
                $query->where('locale', $localeLanguage);
            },
        ])->where('status', 1)->get(); 
        

        return view('backend/explore_collection/add',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateExploreCollectionRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateExploreCollectionRequest $request)
    {
        try {
            DB::beginTransaction();
            $input = $request->all();
            $input['type'] = $input['collection_type'];
            if (! empty($input['is_scrollable'])) {
                $input['is_scrollable'] = '1';
            }else{
                $input['is_scrollable'] = '0';
            }
            $input['created_by'] = session('data')['id'] ?? 0;
            $input['mapped_ids'] = null;
            if ($input['type'] == ExploreCollection::BOOK && ! empty($input['book_id'])) {
                $input['mapped_ids'] = implode(",", $input['book_id']);
            }
            if ($input['type'] == ExploreCollection::AUDIO && ! empty($input['audio_id'])) {
                $input['mapped_ids'] = implode(",", $input['audio_id']);
            }
            if ($input['type'] == ExploreCollection::QUOTES && ! empty($input['quote_id'])) {
                $input['mapped_ids'] = implode(",", $input['quote_id']);
            }
            if ($input['type'] == ExploreCollection::MANTRA && ! empty($input['mantra_id'])) {
                $input['mapped_ids'] = implode(",", $input['mantra_id']);
            }
            ExploreCollection::create($input);
            
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
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data['collection'] = HomeCollection::find($id);
        $data['singleImage'] = $data['collection']->getMedia(HomeCollection::SINGLE_COLLECTION_IMAGE)->first();

        return view('backend/home_collection/view')->with($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (empty($id)) {

            return redirect()->back();
        }
        $exploreCollection = ExploreCollection::find($id);
        $localeLanguage = \App::getLocale();
        if (str_contains($localeLanguage, 'en')) {
            $localeLanguage = 'en';
        } else {
            $localeLanguage = 'hi';
        }
        $data['translated_block'] = [];
        $data['collection_types'] = ExploreCollection::EXPLORE_COLLECTION_TYPES;
        $data['books'] = Book::with([
            'translations' => function ($query) use ($localeLanguage) {
                $query->where('locale', $localeLanguage);
            },
        ])->where('status', 1)->get();
        $data['audios'] = Audio::with([
            'translations' => function ($query) use ($localeLanguage) {
                $query->where('locale', $localeLanguage);
            },
        ])->where('type',Audio::PRAVACHAN)->where('status', 1)->get();
        $data['quotes'] = Quote::where('status', 1)->get();
        $data['mantras'] = Mantra::with([
            'translations' => function ($query) use ($localeLanguage) {
                $query->where('locale', $localeLanguage);
            },
        ])->where('status', 1)->get();
        $data['languages'] = Language::with([
            'translations' => function ($query) use ($localeLanguage) {
                $query->where('locale', $localeLanguage);
            },
        ])->where('status', 1)->get();

        $data['collection'] = $exploreCollection;
        $data['mappedIds'] = explode(',',$data['collection']->mapped_ids ?? '');
        
        return view('backend/explore_collection/edit',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateExploreCollectionRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateExploreCollectionRequest $request)
    {
        try {
            DB::beginTransaction();
            $input = $request->all();
            $input['type'] = $input['collection_type'];
            if (! empty($input['is_scrollable'])) {
                $input['is_scrollable'] = '1';
            } else {
                $input['is_scrollable'] = '0';
            }
            $input['updated_by'] = session('data')['id'] ?? 0;
            $collection = ExploreCollection::find($input['id']);
            $input['mapped_ids'] = null;   
            if (! empty($collection) && $input['type'] == HomeCollection::BOOK && ! empty($input['book_id'])) {
                $input['mapped_ids'] = implode(",", $input['book_id']);
            }
            if (! empty($collection) && $input['type'] == HomeCollection::AUDIO && ! empty($input['audio_id'])) {
                $input['mapped_ids'] = implode(",", $input['audio_id']);
            }
            if (! empty($collection) && $input['type'] == ExploreCollection::QUOTES && ! empty($input['quote_id'])) {
                $input['mapped_ids'] = implode(",", $input['quote_id']);
            }
            if (! empty($collection) && $input['type'] == ExploreCollection::MANTRA && ! empty($input['mantra_id'])) {
                $input['mapped_ids'] = implode(",", $input['mantra_id']);
            }
            if (!empty($collection)){
                $collection->update($input);
            }

            DB::commit();
            successMessage('Data Update successfully', []);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Something Went Wrong. Error: ".$e->getMessage());

            errorMessage($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     */
    public function destroy($id)
    {
        try {
            DB::beginTransaction();

            $exploreCollection = ExploreCollection::find($id);
            if (!empty($exploreCollection)){
                $exploreCollection->delete();
                
                DB::commit();
                successMessage('Collection Deleted successfully', []);
            }

            errorMessage('Collection not found', []);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Something Went Wrong. Error: " . $e->getMessage());

            errorMessage("Something Went Wrong.");
        }
    }

    /**
     * @param  Request  $request
     *
     */
    public function updateStatus(Request $request)
    {
        try {
            DB::beginTransaction();

            $msg_data = array();
            $input = $request->all();
            $input['updated_by'] = session('data')['id'];

            $exploreCollection = ExploreCollection::find($input['id']);
            if ($exploreCollection->exists()) {
                $exploreCollection->update($input);
                DB::commit();
                if ($input['status'] == 1) {
                    successMessage('Published', $msg_data);
                } else {
                    successMessage('Unpublished', $msg_data);
                }
            }

            errorMessage('Explore Collection not found', []);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Something Went Wrong. Error: " . $e->getMessage());

            errorMessage("Something Went Wrong");
        }
    }
}
