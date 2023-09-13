<?php

namespace App\Http\Controllers\Backend;

use App\Models\Quote;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Utils\Utils;
use Yajra\DataTables\DataTables;
use App\Models\Language;
use App\Models\LanguageTranslation;
use App\Models\QuoteCategory;
use App\Models\QuoteCategoryTranslation;


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
        $data['quotes_status'] = checkPermission('quotes_status');
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
        $input['language_id'] = Language::where('language_code','hi')->first()->id;
        $input['quote_category_id'] = QuoteCategory::where('id','2')->first()->id;
        $data = Quote::create($input);
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
        if (!empty($data['quotes']->getMedia(Quote::IMAGE))) {
            $media = $data['quotes']->getMedia(Quote::IMAGE);
            if (isset($media[0])) {
                $data['media'] = $media[0];
            }
        }
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
        $data['media']= $data['quotes']->getMedia( Quote::IMAGE)[0];
        if (!empty($data['quotes']->getMedia(Quote::IMAGE))) {
            $media = $data['quotes']->getMedia(Quote::IMAGE);
            if (isset($media[0])) {
                $data['media'] = $media[0];
            }
        }
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
        $data->update($input);
        if(!empty($input['image'])){
            $data->clearMediaCollection(Quote::IMAGE);
            storeMedia($data, $input['image'], Quote::IMAGE);
        }
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
                        if (isset($request['search']['search_sequence']) && !is_null($request['search']['search_sequence'])) {
                            $query->where('sequence', 'like', "%" . $request['search']['search_sequence'] . "%");
                        }
                        if (isset($request['search']['search_status']) && !is_null($request['search']['search_status'])) {
                            $query->where('quotes.status', 'like', "%" . $request['search']['search_status'] . "%");
                        }
                        $query->get()->toArray();
                    })
                    ->editColumn('image', function ($event) {
                        $media = $event->getMedia(Quote::IMAGE)->first();
                        return !empty($media) ? "<img src='" . $media->getFullUrl() . "' alt='Quote Image' width='130px'/>" : '';
                    })
                    ->editColumn('sequence',function ($event) {
                        return $event['sequence'];
                    })
                    ->editColumn('action', function ($event) {
                        $quotes_view = checkPermission('quotes_view');
                        $quotes_add = checkPermission('quotes_add');
                        $quotes_edit = checkPermission('quotes_edit');
                        $quotes_status = checkPermission('quotes_status');
                        $actions = '<span style="white-space:nowrap;">';
                        if ($quotes_view) {
                            $actions .= '<a href="quotes/view/' . $event['id'] . '" class="btn btn-primary btn-sm src_data" data-size="large" data-title="View Quote Details" title="View"><i class="fa fa-eye"></i></a>';
                        }
                        if ($quotes_edit) {
                            $actions .= ' <a href="quotes/edit/' . $event['id'] . '" class="btn btn-success btn-sm src_data" title="Update"><i class="fa fa-edit"></i></a>';
                        }
                        if ($quotes_status) {
                            if ($event->status == '1') {
                                $actions .= ' <input type="checkbox" data-url="quotes/publish" id="switchery' . $event->id . '" data-id="' . $event->id . '" class="js-switch switchery" checked>';
                            } else {
                                $actions .= ' <input type="checkbox" data-url="quotes/publish" id="switchery' . $event->id . '" data-id="' . $event->id . '" class="js-switch switchery">';
                            }
                        }

                        $actions .= '</span>';
                        return $actions;
                    })
                    ->addIndexColumn()
                    ->rawColumns([

                        'image','sequence','action'])->setRowId('id')->make(true);
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
            $quotes = Quote::find($request->id);
            $quotes->status = $request->status;
            $quotes->save();
            if ($request->status == 1) {
                successMessage(trans('message.enable'), $msg_data);
            } else {
                errorMessage(trans('message.disable'), $msg_data);
            }
            errorMessage('Quotes not found', []);
        } catch (\Exception $e) {
            errorMessage(trans('auth.something_went_wrong'));
        }
    }

    public function deleteImage(Request $request)
    {
        $msg_data = array();
        $data = Quote::find($_GET['id']);
        $data->clearMediaCollection(Quote::IMAGE);
        successMessage('image deleted successfully', $msg_data);
    }
}
