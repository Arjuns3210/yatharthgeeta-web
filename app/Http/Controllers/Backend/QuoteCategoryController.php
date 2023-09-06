<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\QuoteCategory;
use App\Models\QuoteCategoryTranslation;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Utils\Utils;


class QuoteCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['quote_category_view'] = checkPermission('quote_category_view');
        $data['quote_category_add'] = checkPermission('quote_category_add');
        $data['quote_category_edit'] = checkPermission('quote_category_edit');
        $data['quote_category_status'] = checkPermission('quote_category_status');
        $data['quote_category_delete'] = checkPermission('quote_category_delete');
        return view('backend/quote_category/index',['data' => $data]);
    }

    public function fetch(Request $request)
    {
        if ($request->ajax()) {
            try {
                $query = QuoteCategory::leftJoin('quote_category_translations', function ($join) {
                                        $join->on("quote_category_translations.quote_category_id", '=', "quote_categories.id");
                                        $join->where('quote_category_translations.locale', \App::getLocale());
                                     })
                                     ->select('quote_categories.*')
                                     ->orderBy('updated_at','desc');
                return DataTables::of($query)
                    ->filter(function ($query) use ($request) {
                        if (isset($request['search']['search_name']) && !is_null($request['search']['search_name'])) {
                            $query->where('quote_category_translations.name', 'like', "%" . $request['search']['search_name'] . "%");
                        }
                        if (isset($request['search']['search_status']) && !is_null($request['search']['search_status'])) {
                            $query->where('quote_categories.status', $request['search']['search_status']);
                        }
                        $query->get()->toArray();
                    })
                    ->editColumn('name_'.\App::getLocale(), function ($event) {
                        $Key_index = array_search(\App::getLocale(), array_column($event->translations->toArray(), 'locale'));
                        return $event['translations'][$Key_index]['name'];
                    })->editColumn('status', function ($event) {
                        return $event->status == 1 ?'Active' : 'Inactive';
                    })
                    ->editColumn('action', function ($event) {
                        $quote_category_view = checkPermission('quote_category_view');
                        $quote_category_edit = checkPermission('quote_category_edit');
                        $quote_category_status = checkPermission('quote_category_status');
                        $quote_category_delete = checkPermission('quote_category_delete');
                        $actions = '<span style="white-space:nowrap;">';
                        if ($quote_category_view) {
                            $actions .= '<a href="books_category/view/' . $event['id'] . '" class="btn btn-primary btn-sm src_data" data-size="large" data-title="View Category Details" title="View"><i class="fa fa-eye"></i></a>';
                        }
                        if ($quote_category_edit) {
                            $actions .= ' <a href="books_category/edit/' . $event['id'] . '" class="btn btn-success btn-sm src_data" title="Update"><i class="fa fa-edit"></i></a>';
                        }
                        $actions .= '</span>';
                        return $actions;
                    })
                    ->addIndexColumn()
                    ->rawColumns(['name_'.\App::getLocale(), 'status', 'action'])->setRowId('id')->make(true);
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
     * @param  \App\Models\QuoteCategory  $quoteCategory
     * @return \Illuminate\Http\Response
     */
    public function show(QuoteCategory $quoteCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\QuoteCategory  $quoteCategory
     * @return \Illuminate\Http\Response
     */
    public function edit(QuoteCategory $quoteCategory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\QuoteCategory  $quoteCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, QuoteCategory $quoteCategory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\QuoteCategory  $quoteCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(QuoteCategory $quoteCategory)
    {
        //
    }
}
