<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\HomeCollection;
use Illuminate\Http\Request;

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
     * @param  \Illuminate\Http\Request  $request
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
