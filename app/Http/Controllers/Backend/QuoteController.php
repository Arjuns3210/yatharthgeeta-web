<?php

namespace App\Http\Controllers\Backend;

use App\Models\Quote;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Utils\Utils;
use Yajra\DataTables\DataTables;


class QuoteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['quotes_add'] = checkPermission('quotes_add');
        $data['quotes_edit'] = checkPermission('quotes_edit');
        $data['quotes_view'] = checkPermission('quotes_view');
        return view('backend/quotes/index',["data"=>$data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend/quotes/add');
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
        $saveArray = Utils::flipTranslationArray($input);
        $data = Quote::create($saveArray);
        storeMedia($data, $input['image'], Quote::IMAGE);
        successMessage('Data Saved successfully', []);
    }
    

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Quote  $quote
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data['quotes'] = Quote::find($id);
        $data['media'] = $data['quotes']->getMedia(Quote::IMAGE)[0];
		return view('backend/quotes/view')->with($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Quote  $quote
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['quotes'] = Quote::find($id);
		return view('backend/quotes/edit')->with($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Quote  $quote
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $data = Quote::find($_GET['id']);
        $input=$request->all();
        if (!$data) {
            errorMessage('Quote Not Found', []);
        }
        $quote = Utils::flipTranslationArray($input);
        $data->update($quote);
        storeMedia($data, $input['cover'], Quote::COVER);
        successMessage('Data Saved successfully', []);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Quote  $quote
     * @return \Illuminate\Http\Response
     */
    public function destroy(Quote $quote)
    {
        //
    }
	
	public function fetch(Request $request)
    {
        if ($request->ajax()) {
            try {
                $query = Quote::orderBy('updated_at','desc');
                return DataTables::of($query)
                    ->filter(function ($query) use ($request) {
                        if (isset($request['search']['search_category_name']) && !is_null($request['search']['search_category_name'])) {
                            $query->where('book_category_translations.name', 'like', "%" . $request['search']['search_category_name'] . "%");
                        }
                        $query->get()->toArray();
                    })
                    ->editColumn('text',function ($event) {
                        return $event['text'];
                    })
                    ->editColumn('action', function ($event) {
                        $quotes_view = checkPermission('quotes_view');
                        $quotes_add = checkPermission('quotes_add');
                        $quotes_edit = checkPermission('quotes_edit');
                        $actions = '<span style="white-space:nowrap;">';
                        if ($quotes_view) {
                            $actions .= '<a href="quotes/view/' . $event['id'] . '" class="btn btn-primary btn-sm modal_src_data" data-size="large" data-title="View Category Details" title="View"><i class="fa fa-eye"></i></a>';
                        }
                        if ($quotes_edit) {
                            $actions .= ' <a href="quotes/edit/' . $event['id'] . '" class="btn btn-success btn-sm src_data" title="Update"><i class="fa fa-edit"></i></a>';
                        }
                        
                        $actions .= '</span>';
                        return $actions;
                    })
                    ->addIndexColumn()
                    ->rawColumns(['text','action'])->setRowId('id')->make(true);
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
}
