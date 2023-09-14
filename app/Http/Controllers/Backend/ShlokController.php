<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Shlok;
use App\Models\ShlokTranslation;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use App\Utils\Utils;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ShlokController extends Controller
{
    public function index()
    {
        $data['shlok_view'] = checkPermission('shlok_view');
        $data['shlok_add'] = checkPermission('shlok_add');
        $data['shlok_edit'] = checkPermission('shlok_edit');
        $data['shlok_status'] = checkPermission('shlok_status');
        $data['shlok_delete'] = checkPermission('shlok_delete');
        return view('backend/shloks/index', ["data" => $data]);
    }

    public function fetch(Request $request)
    {
        if ($request->ajax()) {
            try {
                $query = Shlok::leftJoin('shlok_translations', function ($join) {
                    $join->on("shlok_translations.shlok_id", '=', "shloks.id");
                    $join->where('shlok_translations.locale', \App::getLocale());
                })
                    ->select('shloks.*')
                    ->orderBy('updated_at', 'desc');

                return DataTables::of($query)
                    ->filter(function ($query) use ($request) {
                        if (isset($request['search']['search_title']) && !is_null($request['search']['search_title'])) {
                            $query->whereHas('shlokTranslations', function ($translationQuery) use ($request) {
                                $translationQuery->where('locale', 'en')->where('title', 'like', "%" . $request['search']['search_title'] . "%");
                            });
                        }
                        if (isset($request['search']['search_status']) && !is_null($request['search']['search_status'])) {
                            $query->where('shloks.status', 'like', "%" . $request['search']['search_status'] . "%");
                        }
                        if (isset($request['search']['search_sequence']) && !is_null($request['search']['search_sequence'])) {
                            $query->where('sequence', 'like', "%" . $request['search']['search_sequence'] . "%");
                        }
                        $query->get()->toArray();
                    })->editColumn('title_' . \App::getLocale(), function ($shlok) {
                    $Key_index = array_search(\App::getLocale(), array_column($shlok->shlokTranslations->toArray(), 'locale'));
                    return $shlok['shlokTranslations'][$Key_index]['title'];
                })
                    ->editColumn('sequence', function ($shlok) {
                        return $shlok['sequence'];
                    })
                    ->editColumn('action', function ($shlok) {
                        $shlok_view = checkPermission('shlok_view');
                        $shlok_add = checkPermission('shlok_add');
                        $shlok_edit = checkPermission('shlok_edit');
                        $shlok_status = checkPermission('shlok_status');
                        $shlok_delete = checkPermission('shlok_delete');
                        $actions = '<span style="white-space:nowrap;">';
                        if ($shlok_view) {
                            $actions .= '<a href="shloks/view/' . $shlok['id'] . '" class="btn btn-primary btn-sm src_data" data-size="large" data-title="View Shlok Details" title="View"><i class="fa fa-eye"></i></a>';
                        }
                        if ($shlok_edit) {
                            $actions .= ' <a href="shloks/edit/' . $shlok['id'] . '" class="btn btn-success btn-sm src_data" title="Update"><i class="fa fa-edit"></i></a>';
                        }
                        if ($shlok_delete) {
                            $actions .= ' <a data-option="" data-url="shloks/delete/' . $shlok->id . '" class="btn btn-danger btn-sm delete-data" title="delete"><i class="fa fa-trash"></i></a>';
                        }
                        if ($shlok_status) {
                            if ($shlok->status == '1') {
                                $actions .= ' <input type="checkbox" data-url="shloks/publish" id="switchery' . $shlok->id . '" data-id="' . $shlok->id . '" class="js-switch switchery" checked>';
                            } else {
                                $actions .= ' <input type="checkbox" data-url="shloks/publish" id="switchery' . $shlok->id . '" data-id="' . $shlok->id . '" class="js-switch switchery">';
                            }
                        }
                        $actions .= '</span>';
                        return $actions;
                    })
                    ->addIndexColumn()
                    ->rawColumns(['title_' . \App::getLocale(), 'sequence', 'action'])
                    ->setRowId('id')
                    ->make(true);
            } catch (\Exception $e) {
                \Log::error("Something Went Wrong. Error: " . $e->getMessage());
                return response([
                    'draw' => 0,
                    'recordsTotal' => 0,
                    'recordsFiltered' => 0,
                    'data' => [],
                    'error' => 'Something went wrong',
                ]);
            }
        }
    }

    public function updateStatus(Request $request)
    {
        try {
            $msg_data = array();
            $shlok = Shlok::find($request->id);
            $shlok->status = $request->status;
            $shlok->save();
            if ($request->status == 1) {
                successMessage('Enable', $msg_data);
            } else {
                successMessage('Disable', $msg_data);
            }
            errorMessage('Shlok not found', []);
        } catch (\Exception $e) {
            errorMessage('something_went_wrong');
        }
    }

    public function create()
    {
        return view('backend/shloks/add');
    }

    public function store(Request $request)
    {
        $request->validate([
            'shlok_text' => 'required|string',
            'shlok_status' => 'required|in:1,0',
            'shlok_sequence' => 'required|integer',
        ]);

        try {

            $shlok = new Shlok([
                'shlok' => $request->input('shlok_text'),
                'status' => $request->input('shlok_status'),
                'sequence' => $request->input('shlok_sequence'),
            ]);

            $shlok->save();

            foreach (config('translatable.locales') as $locale) {
                $shlokTranslation = new ShlokTranslation([
                    'shlok_id' => $shlok->id,
                    'locale' => $locale,
                    'title' => $request->input("shlok_title_$locale"),
                    'description' => $request->input("shlok_description_$locale"),
                    'chapter' => $request->input("shlok_chapter_$locale"),
                ]);

                $shlokTranslation->save();
            }

            successMessage('Data Saved successfully', []);

        } catch (\Exception $e) {
            errorMessage("Something went wrong.");
        }
    }



    public function view($id)
    {
        $data['shloks'] = Shlok::find($id);
        return view('backend/shloks/view', $data);
    }

    public function edit($id)
    {
        $data['shloks'] = Shlok::find($id);
        foreach ($data['shloks']->translations as $trans) {
            $translated_keys = array_keys(Shlok::TRANSLATED_BLOCK);
            foreach ($translated_keys as $value) {
                $data['shloks'][$value . '_' . $trans['locale']] = $trans[$value];
            }
        }
        $data['translated_block'] = Shlok::TRANSLATED_BLOCK;

        return view('backend/shloks/edit', $data);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'shlok_text' => 'required|string',
            'shlok_status' => 'required|in:1,0',
            'shlok_sequence' => 'required|integer',
        ]);

        try {
            $shlok = Shlok::findOrFail($id);
            $shlok->shlok = $request->input('shlok_text');
            $shlok->status = $request->input('shlok_status');
            $shlok->sequence = $request->input('shlok_sequence');

            foreach (config('translatable.locales') as $locale) {
                $shlokTranslation = $shlok->shlokTranslations->firstWhere('locale', $locale);

                if ($shlokTranslation) {
                    $shlokTranslation->title = $request->input("shlok_title_$locale");
                    $shlokTranslation->description = $request->input("shlok_description_$locale");
                    $shlokTranslation->chapter = $request->input("shlok_chapter_$locale");
                    $shlokTranslation->save();
                }
            }

            $shlok->save();

            successMessage('Data Updated successfully', []);
        } catch (\Exception $e) {
            errorMessage("Something Went Wrong.");
        }
    }


    public function destroy($id)
    {
        $data= Shlok::find($id);
        $data->delete();
        successMessage('Data Deleted successfully', []);
    }
}
