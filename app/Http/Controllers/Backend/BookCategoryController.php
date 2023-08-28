<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BookCategory;
use App\Models\BookCategoryTranslation;
use App\Utils\Utils;
use Yajra\DataTables\DataTables;


class BookCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['books_category_add'] = checkPermission('category_add');
        $data['books_category_edit'] = checkPermission('category_edit');
        $data['books_category_view'] = checkPermission('category_view');
        $data['books_category_status'] = checkPermission('category_status');
        $data['books_category_delete'] = checkPermission('category_delete');
        return view('backend/books_category/index',["data"=>$data]);
    }

    /**
     * Fetch a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function fetch(Request $request)
    {
        if ($request->ajax()) {
            try {
                $query = BookCategory::leftJoin('book_category_translations', function ($join) {
                                        $join->on("book_category_translations.book_category_id", '=', "book_categories.id");
                                        $join->where('book_category_translations.locale', \App::getLocale());
                                     })
                                     ->select('book_categories.*')
                                     ->orderBy('updated_at','desc');
                return DataTables::of($query)
                    ->filter(function ($query) use ($request) {
                        if (isset($request['search']['search_category_name']) && !is_null($request['search']['search_category_name'])) {
                            $query->where('book_category_translations.name', 'like', "%" . $request['search']['search_category_name'] . "%");
                        }
                        if (isset($request['search']['search_status']) && !is_null($request['search']['search_status'])) {
                            $query->where('book_categories.status', $request['search']['search_status']);
                        }
                        $query->get()->toArray();
                    })
                    ->editColumn('category_name_'.\App::getLocale(), function ($event) {
                        $Key_index = array_search(\App::getLocale(), array_column($event->translations->toArray(), 'locale'));
                        return $event['translations'][$Key_index]['name'];
                    })->editColumn('status', function ($event) {
                        return $event->status == 1 ?'Active' : 'Inactive';
                    })
                    ->editColumn('action', function ($event) {
                        $books_category_view = checkPermission('books_category_view');
                        $books_category_edit = checkPermission('books_category_edit');
                        $books_category_status = checkPermission('books_category_status');
                        $books_category_delete = checkPermission('books_category_delete');
                        $actions = '<span style="white-space:nowrap;">';
                        if ($books_category_view) {
                            $actions .= '<a href="books_category/view/' . $event['id'] . '" class="btn btn-primary btn-sm src_data" data-size="large" data-title="View Category Details" title="View"><i class="fa fa-eye"></i></a>';
                        }
                        if ($books_category_edit) {
                            $actions .= ' <a href="books_category/edit/' . $event['id'] . '" class="btn btn-success btn-sm src_data" title="Update"><i class="fa fa-edit"></i></a>';
                        }
                        $actions .= '</span>';
                        return $actions;
                    })
                    ->addIndexColumn()
                    ->rawColumns(['category_name_'.\App::getLocale(), 'status', 'action'])->setRowId('id')->make(true);
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
        $data['translated_block'] = BookCategory::TRANSLATED_BLOCK;
        return view('backend/books_category/add', $data);
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
        $translated_keys = array_keys(BookCategory::TRANSLATED_BLOCK);
        foreach ($translated_keys as $value) {
            $input[$value] = (array) json_decode($input[$value]);
        }
        $saveArray = Utils::flipTranslationArray($input, $translated_keys);
        $data = BookCategory::create($saveArray);
        successMessage('Data Saved successfully', []);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data['category'] = BookCategory::find($id)->toArray();
        return view('backend/books_category/view',$data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['category'] = BookCategory::find($id)->toArray();
        foreach($data['category']['translations'] as $trans) {
            $translated_keys = array_keys(BookCategory::TRANSLATED_BLOCK);
            foreach ($translated_keys as $value) {
                $data['category'][$value.'_'.$trans['locale']] = $trans[$value];
            }
        }
        $data['translated_block'] = BookCategory::TRANSLATED_BLOCK;
        return view('backend/books_category/edit',$data);
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
        $data = BookCategory::find($_GET['id']);
        $input=$request->all();
        if ($data) 
        {
            $translated_keys = array_keys(BookCategory::TRANSLATED_BLOCK);
            foreach ($translated_keys as $value) 
            {
                $input[$value] = (array) json_decode($input[$value]);
            }
            $category = Utils::flipTranslationArray($input, $translated_keys);
            $data->update($category);
        } else {
            errorMessage('Book Category Not Found', []);

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
        //
    }
}
