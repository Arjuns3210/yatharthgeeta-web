<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Artist;
use App\Models\Audio;
use App\Models\Book;
use App\Models\BookCategory;
use App\Models\BookTranslation;
use App\Models\Language;
use App\Models\Video;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use App\Utils\Utils;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['book_view'] = checkPermission('book_view');
        $data['book_add'] = checkPermission('book_add');
        $data['book_edit'] = checkPermission('book_edit');
        $data['book_status'] = checkPermission('book_status');
        $data['book_delete'] = checkPermission('book_delete');
        return view('backend/books/index',["data"=>$data]);
    }

    public function fetch(Request $request)
        {
            if ($request->ajax()) {
                try {
                    $query = Book::leftJoin('book_translations', function ($join) {
                        $join->on("book_translations.book_id", '=', "books.id");
                        $join->where('book_translations.locale', \App::getLocale());
                     })
                     ->select('books.*')
                    ->orderBy('updated_at','desc');
                    return DataTables::of($query)
                        ->filter(function ($query) use ($request) {
                            if (isset($request['search']['search_name']) && !is_null($request['search']['search_name'])) {
                                $query->whereHas('translations', function ($translationQuery) use ($request) {
                                    $translationQuery->where('locale','en')->where('name', 'like', "%" . $request['search']['search_name'] . "%");
                                });
                            }
                            if (isset($request['search']['search_status']) && !is_null($request['search']['search_status'])) {
                                $query->where('books.status', 'like', "%" . $request['search']['search_status'] . "%");
                            }
                            if (isset($request['search']['search_sequence']) && !is_null($request['search']['search_sequence'])) {
                                $query->where('sequence', 'like', "%" . $request['search']['search_sequence'] . "%");
                            }
                            $query->get()->toArray();
                        })->editColumn('name_'.\App::getLocale(), function ($event) {
                            $Key_index = array_search(\App::getLocale(), array_column($event->translations->toArray(), 'locale'));
                            return $event['translations'][$Key_index]['name'];

                        })->editColumn('sequence',function ($event) {
                            return $event['sequence'];
                        })
                        ->editColumn('action', function ($event) {
                            $book_view = checkPermission('book_view');
                            $book_add = checkPermission('book_add');
                            $book_edit = checkPermission('book_edit');
                            $book_status = checkPermission('book_status');
                            $book_delete = checkPermission('book_delete');
                            $actions = '<span style="white-space:nowrap;">';
                            if ($book_view) {
                                $actions .= '<a href="books/view/' . $event['id'] . '" class="btn btn-primary btn-sm src_data" data-size="large" data-title="View Book Details" title="View"><i class="fa fa-eye"></i></a>';
                            }
                            if ($book_edit) {
                                $actions .= ' <a href="books/edit/' . $event['id'] . '" class="btn btn-success btn-sm src_data" title="Update"><i class="fa fa-edit"></i></a>';
                            }
                            if ($book_delete) {
                                $actions .= ' <a data-option="" data-url="books/delete/' . $event->id . '" class="btn btn-danger btn-sm delete-data" title="delete"><i class="fa fa-trash"></i></a>';
                            }
                            if ($book_status) {
                                if ($event->status == '1') {
                                    $actions .= ' <input type="checkbox" data-url="books/publish" id="switchery' . $event->id . '" data-id="' . $event->id . '" class="js-switch switchery" checked>';
                                } else {
                                    $actions .= ' <input type="checkbox" data-url="books/publish" id="switchery' . $event->id . '" data-id="' . $event->id . '" class="js-switch switchery">';
                                }
                            }
                            $actions .= '</span>';
                            return $actions;
                        })
                        ->addIndexColumn()
                        ->rawColumns(['name_'.\App::getLocale(),'sequence', 'action'])->setRowId('id')->make(true);
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
                $event = Book::find($request->id);
                $event->status = $request->status;
                $event->save();
                if ($request->status == 1) {
                    successMessage(trans('message.enable'), $msg_data);
                } else {
                    errorMessage(trans('message.disable'), $msg_data);
                }
                errorMessage('Event not found', []);
            } catch (\Exception $e) {
                errorMessage(trans('auth.something_went_wrong'));
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
        $data['translated_block'] = Book::TRANSLATED_BLOCK;
        $data['books'] = Book::with([
            'translations' => function ($query) use ($localeLanguage) {
                $query->where('locale', $localeLanguage);
            },
        ])->where('status', 1)->get();
        $data['book_category'] = BookCategory::all();
        $data['language'] = Language::all();
        $data['artist'] = Artist::all();
        $data['audio'] = Audio::all();
        $data['video'] = Video::all();
        return view('backend/books/add', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        {
            $input = $request->all();
            if ($input['video_id']) {
                $video_id_array = explode(',', $input['video_id']);
                $input['video_id'] = json_encode($video_id_array);
            }
            if ($input['audio_id']) {
                $audio_id_array = explode(',', $input['audio_id']);
                $input['audio_id'] = json_encode($audio_id_array);
            }
            if ($input['related_id']) {
                $related_id_array = explode(',', $input['related_id']);
                $input['related_id'] = json_encode($related_id_array);
            }
            $translated_keys = array_keys(Book::TRANSLATED_BLOCK);
            foreach ($translated_keys as $value) {
                $input[$value] = (array) json_decode($input[$value]);
            }
            $saveArray = Utils::flipTranslationArray($input, $translated_keys);
            $data = Book::create($saveArray);
            storeMedia($data, $input['cover_image'], Book::COVER_IMAGE);
            storeMedia($data, $input['pdf_file_name'], Book::PDF_FILE);
            storeMedia($data, $input['epub_file_name'], Book::EPUB_FILE);
            successMessage('Data Saved successfully', []);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function view($id)
    {
        $data['books'] = Book::find($id);
        $data['book_category'] = BookCategory::where('id', $data['books']->book_category_id)->first();
        $data['language'] = Language::where('id', $data['books']->language_id)->first();
        $data['artist'] = Artist::where('id', $data['books']->artist_id)->first();
        foreach($data['books']['translations'] as $trans) {
            $translated_keys = array_keys(Book::TRANSLATED_BLOCK);
            foreach ($translated_keys as $value) {
                $data['books'][$value.'_'.$trans['locale']] = $trans[$value];
            }
        }
        $data['translated_block'] = Book::TRANSLATED_BLOCK;
        $data['media'] = $data['books']->getMedia(Book::COVER_IMAGE)[0];
        $data['pdf_file'] = $data['books']->getMedia(Book::PDF_FILE)->first()?? '';
        $data['epub_file'] = $data['books']->getMedia(Book::EPUB_FILE)->first()?? '';
        return view('backend/books/view',$data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['books'] = Book::find($id);
        $data['language'] = Language::all();
        $data['book_category'] = BookCategory::all();
        $data['artist'] = Artist::all();
        foreach($data['books']['translations'] as $trans) {
            $translated_keys = array_keys(Book::TRANSLATED_BLOCK);
            foreach ($translated_keys as $value) {
                $data['books'][$value.'_'.$trans['locale']] = str_replace("<br/>", "\r\n", $trans[$value]);
            }
        }
        $data['translated_block'] = Book::TRANSLATED_BLOCK;
        $data['media'] =$data['books']->getMedia(Book::COVER_IMAGE)[0];
        $data['pdf_file'] = $data['books']->getMedia(Book::PDF_FILE)->first()?? '';
        $data['epub_file'] = $data['books']->getMedia(Book::EPUB_FILE)->first()?? '';
        return view('backend/books/edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $data = Book::find($_GET['id']);
        $input=$request->all();
        if (!$data) {
            errorMessage('Book Not Found', []);
        }
        if ($input['video_id']) {
            $video_id_array = explode(',', $input['video_id']);
            $input['video_id'] = json_encode($video_id_array);
        }
        if ($input['audio_id']) {
            $audio_id_array = explode(',', $input['audio_id']);
            $input['audio_id'] = json_encode($audio_id_array);
        }
        if ($input['related_id']) {
            $related_id_array = explode(',', $input['related_id']);
            $input['related_id'] = json_encode($related_id_array);
        }
        $translated_keys = array_keys(Book::TRANSLATED_BLOCK);
        foreach ($translated_keys as $value)
        {
            $input[$value] = (array) json_decode($input[$value]);
        }
        $book = Utils::flipTranslationArray($input, $translated_keys);
        $data->update($book);

        if(!empty($input['cover_image'])){
            $data->clearMediaCollection(Book::COVER_IMAGE);
            storeMedia($data, $input['cover_image'], Book::COVER_IMAGE);
        }
        if(!empty($input['pdf_file_name'])){
            $data->clearMediaCollection(Book::PDF_FILE);
            storeMedia($data, $input['pdf_file_name'], Book::PDF_FILE);
        }
        if(!empty($input['epub_file_name'])){
            $data->clearMediaCollection(Book::EPUB_FILE);
            storeMedia($data, $input['epub_file_name'], Book::EPUB_FILE);
        }
        successMessage('Data Updated successfully', []);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data= Book::find($id);
        $data->delete();
        successMessage('Data Deleted successfully', []);
    }
}
