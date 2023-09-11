<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateHomeCollectionRequest;
use App\Http\Requests\UpdateHomeCollectionRequest;
use App\Models\Artist;
use App\Models\Audio;
use App\Models\Book;
use App\Models\BookCategory;
use App\Models\HomeCollection;
use App\Models\HomeCollectionMapping;
use App\Models\Language;
use App\Models\Shlok;
use App\Models\Video;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;
use Ramsey\Collection\Collection;
use Yajra\DataTables\DataTables;

class HomeCollectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['home_collection_add'] = checkPermission('home_collection_add');
        $data['home_collection_view'] = checkPermission('home_collection_view');
        $data['home_collection_edit'] = checkPermission('home_collection_edit');
        $data['home_collection_status'] = checkPermission('home_collection_status');
        $data['collection_types'] = HomeCollection::COLLECTION_TYPES;

        return view('backend/home_collection/index', ["data" => $data]);
    }


    public function fetch(Request $request)
    {
        if ($request->ajax()) {
            try {
                $query = HomeCollection::with('language')
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
                        
                        return $event->type ?? '';
                    })
                    ->editColumn('sequence', function ($event) {

                        return $event->sequence ?? '';
                    })
                    ->editColumn('action', function ($event) {
                        $home_collection_edit = checkPermission('home_collection_edit');
                        $home_collection_view = checkPermission('home_collection_view');
                        $home_collection_status = checkPermission('home_collection_status');
                        $home_collection_delete = checkPermission('home_collection_delete');
                        $is_head = session('data')['is_head'] ?? true;
                        $actions = '<span style="white-space:nowrap;">';
                        if ($home_collection_view) {
                            $actions .= '<a href="home_collection/view/' . $event['id'] . '" class="btn btn-primary btn-sm src_data" data-size="large" data-title="View Book Details" title="View"><i class="fa fa-eye"></i></a>';
                        }
                        if ($home_collection_edit) {
                            $actions .= ' <a href="home_collection/edit/' . $event['id'] . '" class="btn btn-success btn-sm src_data" title="Update"><i class="fa fa-edit"></i></a>';
                        }
                        if ($home_collection_delete && $is_head) {
                            $dataUrl = $event->title ?? '';
                            $actions .= ' <a data-option="'.$dataUrl.'" data-url="home_collection/delete/'.$event->id.'" class="btn btn-danger btn-sm delete-data" title="delete"><i class="fa fa-trash"></i></a>';
                        }
                        if ($home_collection_status) {
                            if ($event->status == '1') {
                                $actions .= ' <input type="checkbox" data-url="home_collection/publish" id="switchery' . $event->id . '" data-id="' . $event->id . '" class="js-switch switchery" checked>';
                            } else {
                                $actions .= ' <input type="checkbox" data-url="home_collection/publish" id="switchery' . $event->id . '" data-id="' . $event->id . '" class="js-switch switchery">';
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
        $data['collection_types'] = HomeCollection::COLLECTION_TYPES;

        $data['books'] = Book::with([
            'translations' => function ($query) use ($localeLanguage) {
                $query->where('locale', $localeLanguage);
            },
        ])->where('status', 1)->get();
        
        $data['audios'] = Audio::with([
            'translations' => function ($query) use ($localeLanguage) {
                $query->where('locale', $localeLanguage);
            },
        ])->where('status', 1)->get();
        
        $data['videos'] = Video::with([
            'translations' => function ($query) use ($localeLanguage) {
                $query->where('locale', $localeLanguage);
            },
        ])->where('status', 1)->get();

        $data['shloks'] = Shlok::with([
            'translations' => function ($query) use ($localeLanguage) {
                $query->where('locale', $localeLanguage);
            },
        ])->get();
        
        $data['artists'] = Artist::with([
            'translations' => function ($query) use ($localeLanguage) {
                $query->where('locale', $localeLanguage);
            },
        ])->get();
        
        $data['languages'] = Language::with([
            'translations' => function ($query) use ($localeLanguage) {
                $query->where('locale', $localeLanguage);
            },
        ])->where('status', 1)->get(); 
        
        $data['mappingCollectionType'] = HomeCollectionMapping::MAPPING_COLLECTION_TYPES;

        return view('backend/home_collection/add',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateHomeCollectionRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateHomeCollectionRequest $request)
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
            $collection = HomeCollection::create($input);
            if (! empty($collection) && $input['type'] == HomeCollection::SINGLE && ! empty($input['single_image'])) {
                storeMedia($collection, $input['single_image'], HomeCollection::SINGLE_COLLECTION_IMAGE);
            }
            if (! empty($collection) && $input['type'] == HomeCollection::BOOK && ! empty($input['book_id'])) {
                $mappedIds = implode(",", $input['book_id']);
                $homeCollectionDetails = [
                    'home_collection_id' => $collection->id,
                    'mapped_ids'         => $mappedIds,
                    'sequence'           => 1,
                    'mapped_to'          => $input['type'],
                ];
                HomeCollectionMapping::create($homeCollectionDetails);
            }
            if (! empty($collection) && $input['type'] == HomeCollection::AUDIO && ! empty($input['audio_id'])) {
                $mappedIds = implode(",", $input['audio_id']);
                $homeCollectionDetails = [
                    'home_collection_id' => $collection->id,
                    'mapped_ids'         => $mappedIds,
                    'sequence'           => 1,
                    'mapped_to'          => $input['type'],
                ];
                HomeCollectionMapping::create($homeCollectionDetails);
            }
            if (! empty($collection) && $input['type'] == HomeCollection::VIDEO && ! empty($input['video_id'])) {
                $mappedIds = implode(",", $input['video_id']);
                $homeCollectionDetails = [
                    'home_collection_id' => $collection->id,
                    'mapped_ids'         => $mappedIds,
                    'sequence'           => 1,
                    'mapped_to'          => $input['type'],
                ];
                HomeCollectionMapping::create($homeCollectionDetails);
            }
            if (! empty($collection) && $input['type'] == HomeCollection::SHLOK && ! empty($input['shlok_id'])) {
                $mappedIds = implode(",", $input['shlok_id']);
                $homeCollectionDetails = [
                    'home_collection_id' => $collection->id,
                    'mapped_ids'         => $mappedIds,
                    'sequence'           => 1,
                    'mapped_to'          => $input['type'],
                ];
                HomeCollectionMapping::create($homeCollectionDetails);
            }
            if (! empty($collection) && $input['type'] == HomeCollection::ARTIST && ! empty($input['artist_id'])) {
                $mappedIds = implode(",", $input['artist_id']);
                $homeCollectionDetails = [
                    'home_collection_id' => $collection->id,
                    'mapped_ids'         => $mappedIds,
                    'sequence'           => 1,
                    'mapped_to'          => $input['type'],
                ];
                HomeCollectionMapping::create($homeCollectionDetails);
            }

            if (! empty($collection) && $input['type'] == HomeCollection::MULTIPLE && ! empty($input['mapped_to'])) {
                foreach ($input['mapped_to'] as $key => $value) {
                    $mappedIds = implode(",", $input['mapped_ids'][$key] ?? []);
                    $homeCollectionDetails = [
                        'home_collection_id' => $collection->id,
                        'mapped_ids'         => $mappedIds,
                        'sequence'           => 1,
                        'img_clickable'      => $input['img_clickable'][$key] ?? 0,
                        'mapped_to'          => $input['mapped_to'][$key],
                    ];
                    $multipleCollection = HomeCollectionMapping::create($homeCollectionDetails);
                    if (! empty($input['img_file'][$key])) {
                        storeMedia($multipleCollection, $input['img_file'][$key],
                            HomeCollectionMapping::MULTIPLE_COLLECTION_IMAGE);
                    }
                }
            }
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
        $collection = HomeCollection::find($id);
        $collectionDetails = HomeCollectionMapping::where('home_collection_id', $collection->id)->first();
        $localeLanguage = \App::getLocale();
        if (str_contains($localeLanguage, 'en')) {
            $localeLanguage = 'en';
        } else {
            $localeLanguage = 'hi';
        }
        $data['translated_block'] = [];
        $data['collection_types'] = HomeCollection::COLLECTION_TYPES;

        $data['books'] = Book::with([
            'translations' => function ($query) use ($localeLanguage) {
                $query->where('locale', $localeLanguage);
            },
        ])->where('status', 1)->get();

        $data['audios'] = Audio::with([
            'translations' => function ($query) use ($localeLanguage) {
                $query->where('locale', $localeLanguage);
            },
        ])->where('status', 1)->get();

        $data['videos'] = Video::with([
            'translations' => function ($query) use ($localeLanguage) {
                $query->where('locale', $localeLanguage);
            },
        ])->where('status', 1)->get();

        $data['shloks'] = Shlok::with([
            'translations' => function ($query) use ($localeLanguage) {
                $query->where('locale', $localeLanguage);
            },
        ])->get();

        $data['artists'] = Artist::with([
            'translations' => function ($query) use ($localeLanguage) {
                $query->where('locale', $localeLanguage);
            },
        ])->get();

        $data['languages'] = Language::with([
            'translations' => function ($query) use ($localeLanguage) {
                $query->where('locale', $localeLanguage);
            },
        ])->where('status', 1)->get();
        
        $data['collection'] = $collection;
        $data['collectionDetails'] = $collectionDetails;
        $data['mappedIds'] = explode(',',$data['collectionDetails']->mapped_ids ?? '');
       $data['singleImage'] = $collection->getMedia(HomeCollection::SINGLE_COLLECTION_IMAGE);
        $data['mappingCollectionType'] = HomeCollectionMapping::MAPPING_COLLECTION_TYPES;
        $data['multipleCollectionData'] = [];
        if ($collection->type == HomeCollection::MULTIPLE){
            $collection->load('homeCollectionDetails');
            $data['multipleCollectionData'] = $collection->homeCollectionDetails;
        }
        
        return view('backend/home_collection/edit',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateHomeCollectionRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateHomeCollectionRequest $request)
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
            $collection = HomeCollection::find($input['id']);
            if (!empty($collection)){
                $collection->update($input);
            }
            if (! empty($collection) && $input['type'] == HomeCollection::SINGLE && ! empty($input['single_image'])) {
                $collection->clearMediaCollection(HomeCollection::SINGLE_COLLECTION_IMAGE);
                storeMedia($collection, $input['single_image'], HomeCollection::SINGLE_COLLECTION_IMAGE);
            }
            $detail = HomeCollectionMapping::where('home_collection_id', $collection->id)->first();
            if (! empty($collection) && $input['type'] == HomeCollection::BOOK && ! empty($input['book_id'])) {
                $mappedIds = implode(",", $input['book_id']);
                $homeCollectionDetails = [
                    'mapped_ids' => $mappedIds,
                ];
                if ($detail) {
                    $detail->update($homeCollectionDetails);
                }
            }
            if (! empty($collection) && $input['type'] == HomeCollection::AUDIO && ! empty($input['audio_id'])) {
                $mappedIds = implode(",", $input['audio_id']);
                $homeCollectionDetails = [
                    'mapped_ids'         => $mappedIds,
                ];
                if ($detail) {
                    $detail->update($homeCollectionDetails);
                }
            }
            if (! empty($collection) && $input['type'] == HomeCollection::VIDEO && ! empty($input['video_id'])) {
                $mappedIds = implode(",", $input['video_id']);
                $homeCollectionDetails = [
                    'mapped_ids'         => $mappedIds,
                ];
                if ($detail) {
                    $detail->update($homeCollectionDetails);
                }
            }
            if (! empty($collection) && $input['type'] == HomeCollection::SHLOK && ! empty($input['shlok_id'])) {
                $mappedIds = implode(",", $input['shlok_id']);
                $homeCollectionDetails = [
                    'mapped_ids'         => $mappedIds,
                ];
                if ($detail) {
                    $detail->update($homeCollectionDetails);
                }
            }
            if (! empty($collection) && $input['type'] == HomeCollection::ARTIST && ! empty($input['artist_id'])) {
                $mappedIds = implode(",", $input['artist_id']);
                $homeCollectionDetails = [
                    'mapped_ids'         => $mappedIds,
                ];
                if ($detail) {
                    $detail->update($homeCollectionDetails);
                }
            }
            if (! empty($collection) && $input['type'] == HomeCollection::MULTIPLE && ! empty($input['mapped_to'])) {
                $oldCollectionDetailsIds = $collection->homeCollectionDetails()->pluck('id')->toArray();
                $getDeletedIds = array_diff($oldCollectionDetailsIds, $input['collection_details_ids'] ?? []);
                HomeCollectionMapping::whereIn('id', $getDeletedIds)->delete();
                foreach ($input['mapped_to'] as $key => $value) {
                    $mappedIds = implode(",", $input['mapped_ids'][$key] ?? []);
                    $homeCollectionDetails = [
                        'home_collection_id' => $collection->id,
                        'mapped_ids'         => $mappedIds,
                        'sequence'           => 1,
                        'is_clickable'      => $input['img_clickable'][$key] ?? 0,
                        'mapped_to'          => $input['mapped_to'][$key],
                    ];
                    if(!empty($input['collection_details_ids'][$key])){
                        $multipleCollection = HomeCollectionMapping::where('id',$input['collection_details_ids'][$key])->first();
                        if(!empty($multipleCollection)){
                            $multipleCollection->update($homeCollectionDetails);
                        }
                    }else{
                        $multipleCollection = HomeCollectionMapping::create($homeCollectionDetails);
                    }
                    if (! empty($input['img_file'][$key]) && !empty($multipleCollection)) {
                        $multipleCollection->clearMediaCollection(HomeCollectionMapping::MULTIPLE_COLLECTION_IMAGE);
                        storeMedia($multipleCollection, $input['img_file'][$key],
                            HomeCollectionMapping::MULTIPLE_COLLECTION_IMAGE);
                    }
                }
                
                $getHomeCollectionDetails = HomeCollectionMapping::where('home_collection_id',$collection->id)->get();
                foreach ($getHomeCollectionDetails as $indexKey => $getHomeCollectionDetail) {
                    $sequence = $indexKey + 1;
                    $getHomeCollectionDetail->update(['sequence' => $sequence]);
                }
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

            $collection = HomeCollection::find($id);
            if (!empty($collection)){
                $collection->delete();
                
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

            $homeCollection = HomeCollection::find($input['id']);
            if ($homeCollection->exists()) {
                $homeCollection->update($input);
                DB::commit();
                if ($input['status'] == 1) {
                    successMessage('Published', $msg_data);
                } else {
                    successMessage('Unpublished', $msg_data);
                }
            }

            errorMessage('Home Collection not found', []);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Something Went Wrong. Error: " . $e->getMessage());

            errorMessage("Something Went Wrong");
        }
    }
    
    public function getMappedListing($type)
    {
        $localeLanguage = \App::getLocale();
        if (str_contains($localeLanguage, 'en')) {
            $localeLanguage = 'en';
        } else {
            $localeLanguage = 'hi';
        }
        $data = [];
        if ($type == HomeCollectionMapping::BOOK){
            $data['books'] = Book::with([
                'translations' => function ($query) use ($localeLanguage) {
                    $query->where('locale', $localeLanguage);
                },
            ])->where('status', 1)->get();   
        }
        if ($type == HomeCollectionMapping::AUDIO){
            $data['audios'] = Audio::with([
                'translations' => function ($query) use ($localeLanguage) {
                    $query->where('locale', $localeLanguage);
                },
            ])->where('status', 1)->get();
        }
        if ($type == HomeCollectionMapping::VIDEO) {

            $data['videos'] = Video::with([
                'translations' => function ($query) use ($localeLanguage) {
                    $query->where('locale', $localeLanguage);
                },
            ])->where('status', 1)->get();
        }
        if ($type == HomeCollectionMapping::SHLOK) {
            $data['shloks'] = Shlok::with([
                'translations' => function ($query) use ($localeLanguage) {
                    $query->where('locale', $localeLanguage);
                },
            ])->get();
        }

        if ($type == HomeCollectionMapping::ARTIST){
            $data['artists'] = Artist::with([
                'translations' => function ($query) use ($localeLanguage) {
                    $query->where('locale', $localeLanguage);
                },
            ])->get();
        }
        
        return Response::json($data);
    }

    /**
     * @param $count
     *
     * prepare multiple div
     * @return JsonResponse
     */
    
    public function prepareMultipleCollectionItem($count)
    {
        $localeLanguage = \App::getLocale();
        if (str_contains($localeLanguage, 'en')) {
            $localeLanguage = 'en';
        } else {
            $localeLanguage = 'hi';
        }
        $data['books'] = Book::with([
            'translations' => function ($query) use ($localeLanguage) {
                $query->where('locale', $localeLanguage);
            },
        ])->where('status', 1)->get();

        $data['mappingCollectionType'] = HomeCollectionMapping::MAPPING_COLLECTION_TYPES;
        $data['count'] = $count;
        
        $returnValue =  view('backend.home_collection.prepare_multiple_collection_item')->with($data)->render();

        return \Illuminate\Support\Facades\Response::json($returnValue);
    }
}
