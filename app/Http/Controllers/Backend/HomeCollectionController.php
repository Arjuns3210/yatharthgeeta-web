<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateCollectionRequest;
use App\Models\Artist;
use App\Models\Book;
use App\Models\BookCategory;
use App\Models\HomeCollection;
use App\Models\Language;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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

        return view('backend/home_collection/index', ["data" => $data]);
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
        
        $data['audios'] = Artist::with([
            'translations' => function ($query) use ($localeLanguage) {
                $query->where('locale', $localeLanguage);
            },
        ])->where('status', 1)->get();
        
        $data['videos'] = Video::with([
            'translations' => function ($query) use ($localeLanguage) {
                $query->where('locale', $localeLanguage);
            },
        ])->where('status', 1)->get();

        $data['shloks'] = Artist::with([
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

        return view('backend/home_collection/add',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateCollectionRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateCollectionRequest $request)
    {
        try {
            DB::beginTransaction();
            $input = $request->all();
            $input['type'] = $input['collection_type'];
            $input['is_scrollable'] = false;
            if (! empty($input['is_scrollable'])) {
                $input['is_scrollable'] = true;
            }
            $input['created_by'] = session('data')['id'] ?? 0;
            $collection = HomeCollection::create($input);
            if (! empty($collection) && $input['type'] == 'Book' && !empty($input['book_id'])) {
                $homeCollectionDetails = [
                    'home_collection_id' => $collection->id,
                    'mapped_ids'         => $collection->id,
                ];
            }
            DB::commit();

            successMessage('Data Saved successfully', []);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Something Went Wrong. Error: ".$e->getMessage());

            errorMessage($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\HomeCollection  $homeCollection
     * @return \Illuminate\Http\Response
     */
    public function show(HomeCollection $homeCollection)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\HomeCollection  $homeCollection
     * @return \Illuminate\Http\Response
     */
    public function edit(HomeCollection $homeCollection)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  \App\Models\HomeCollection  $homeCollection
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, HomeCollection $homeCollection)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\HomeCollection  $homeCollection
     * @return \Illuminate\Http\Response
     */
    public function destroy(HomeCollection $homeCollection)
    {
        //
    }
}
