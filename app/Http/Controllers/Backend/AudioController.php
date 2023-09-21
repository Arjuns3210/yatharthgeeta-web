<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddAudioRequest;
use App\Http\Requests\UpdateAudioRequest;
use App\Models\Artist;
use App\Models\Audio;
use App\Models\AudioCategory;
use App\Models\AudioEpisode;
use App\Models\AudioTranslation;
use App\Models\Language;
use App\Models\Media;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use App\Utils\Utils;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;


class AudioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View|\Illuminate\Http\Response
     */
    public function index()
    {
        $data['audios_add'] = checkPermission('audios_add');
        $data['audios_edit'] = checkPermission('audios_edit');
        $data['audios_view'] = checkPermission('audios_view');
        $data['audios_status'] = checkPermission('audios_status');
        $data['audios_delete'] = checkPermission('audios_delete');

        return view('backend/audio/index',["data"=>$data]);
    }

    /**
     * Fetch a listing of the resource.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function fetch(Request $request)
    {
        $localeLanguage = \App::getLocale();
        if (str_contains($localeLanguage, 'en')) {
            $localeLanguage = 'en';
        } else {
            $localeLanguage = 'hi';
        }
        if ($request->ajax()) {
            try {
                $query = Audio::with('translations','audioCategory.translations','language.translations')->where('type',Audio::AUDIO)->orderBy('updated_at','desc');

                return DataTables::of($query)
                    ->filter(function ($query) use ($request ,$localeLanguage) {
                        if (isset($request['search']['search_title']) && !is_null($request['search']['search_title'])) {
                            $query->whereHas('translations', function ($translationQuery) use ($request ,$localeLanguage) {
                                $translationQuery->where('locale',$localeLanguage)->where('title', 'like', "%" . $request['search']['search_title'] . "%");
                            });
                        }
                        if (isset($request['search']['search_status']) && !is_null($request['search']['search_status'])) {
                            $query->where('status', $request['search']['search_status']);
                        }
                        if (isset($request['search']['search_audio_category_id']) && !is_null($request['search']['search_audio_category_id'])) {
                            $query->where('audio_category_id', $request['search']['search_audio_category_id']);
                        }
                        $query->get()->toArray();
                    })
                    ->editColumn('audio_category'.\App::getLocale(), function ($event) {
                        if(!empty($event->audioCategory)){
                            $key_index = array_search(\App::getLocale(), array_column($event->audioCategory->translations->toArray(), 'locale'));
                            return $event->audioCategory->translations[$key_index]->name ?? '';
                        }else{
                            return '';
                        }

                    })
                    ->editColumn('title'.\App::getLocale(), function ($event) {
                        $key_index = array_search(\App::getLocale(), array_column($event->translations->toArray(), 'locale'));
                        return $event->translations[$key_index]->title ?? '';
                    })
                    ->editColumn('duration', function ($event) {
                        return $event->duration ??'';
                    })
                    ->editColumn('language_name', function ($event) {
                        return $event->language->name ??'';
                    })
                    ->editColumn('episode_count', function ($event) {
                        if ($event->has_episodes) {
                            return $event->episodes()->count() ?? '-';
                        }

                        return '-';
                    })
                    ->editColumn('status', function ($event) {
                        return $event->status == 1 ?'Active' : 'Inactive';
                    })
                    ->editColumn('action', function ($event) {
                        $audios_view = checkPermission('audios_view');
                        $audios_edit = checkPermission('audios_edit');
                        $audios_status = checkPermission('audios_status');
                        $audios_delete = checkPermission('audios_delete');
                        $audio_episode_view = checkPermission('audio_episode_view');
                        $is_head = session('data')['is_head'] ?? false;
                        $actions = '<span style="white-space:nowrap;">';
                        if ($audios_view) {
                            $actions .= '<a href="audio/view/' . $event['id'] . '" class="btn btn-primary btn-sm src_data" data-size="large" data-title="View Category Details" title="View"><i class="fa fa-eye"></i></a>';
                        }
                        if ($audios_edit) {
                            $actions .= ' <a href="audio/edit/' . $event['id'] . '" class="btn btn-success btn-sm src_data" title="Update"><i class="fa fa-edit"></i></a>';
                        }
                        if ($audios_status) {
                            if ($event->status == '1') {
                                $actions .= ' <input type="checkbox" data-url="publish_audio" id="switchery' . $event->id . '" data-id="' . $event->id . '" class="js-switch switchery" checked>';
                            } else {
                                $actions .= ' <input type="checkbox" data-url="publish_audio" id="switchery' . $event->id . '" data-id="' . $event->id . '" class="js-switch switchery">';
                            }
                        }
                        if ($audios_delete && $is_head){
                            $key_index = array_search(\App::getLocale(), array_column($event->translations->toArray(), 'locale'));
                            $dataUrl =  $event->translations[$key_index]->title ?? '';
                            $actions .= ' <a data-option="'.$dataUrl.'" data-url="audio_delete/'.$event->id.'" class="btn btn-danger btn-sm delete-data" title="delete"><i class="fa fa-trash"></i></a>';
                        }
                        if ($audio_episode_view && $event['has_episodes'] == 1) {
                            $id = Crypt::encryptString($event->id);
                            $actions .= ' <a href="audio_episodes?audioId=' . $id. '" class="btn btn-info btn-sm" title="Manage Episode"><i class="fa fa-archive"></i></a>';
                        }
                        $actions .= '</span>';
                        return $actions;
                    })
                    ->addIndexColumn()
                    ->rawColumns(['title'.\App::getLocale(),'audio_category'.\App::getLocale(),'duration','language_name','episode_count', 'status', 'action'])->setRowId('id')->make(true);
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

        $data['translated_block'] = Audio::TRANSLATED_BLOCK;
        $data['audios'] = Audio::with([
            'translations' => function ($query) use ($localeLanguage) {
                $query->where('locale', $localeLanguage);
            },
        ])->where('type',Audio::AUDIO)->where('status', 1)->get();


        $data['gurus'] = Artist::with([
            'translations' => function ($query) use ($localeLanguage) {
                $query->where('locale', $localeLanguage);
            },
        ])->get();
        $data['languages'] = Language::with([
            'translations' => function ($query) use ($localeLanguage) {
                $query->where('locale', $localeLanguage);
            },
        ])->where('status', 1)->get();

        return view('backend/audio/add', $data);
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  AddAudioRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AddAudioRequest $request)
    {
        try {
            DB::beginTransaction();
            $input = $request->all();
            $translated_keys = array_keys(Audio::TRANSLATED_BLOCK);
            foreach ($translated_keys as $value) {
                $input[$value] = (array) json_decode($input[$value]);
            }
            $saveArray = Utils::flipTranslationArray($input, $translated_keys);
            //Bhagvad Geeta category id
            $input['audio_category_id'] = 1;
            $coverImage = $input['cover_image'] ?? '';
            $coverImageName = '';
            if (!empty($coverImage)){
                $coverImageName = $coverImage->getClientOriginalName();
            }
            $hasEpisodes = $input['has_episodes'] ?? 0;

            $audioData = [
                'cover_image'          => $coverImageName,
                'has_episodes'         => $hasEpisodes,
                'people_also_read_ids' => implode(',',$input['people_also_read_ids'] ?? []),
                'language_id'          => $input['language_id'] ?? null,
                'duration'             => $input['duration'] ?? null,
                'view_count'           => $input['view_count'] ?? null,
                'sequence'             => $input['sequence'] ?? null,
                'author_id'            => $input['author_id'] ?? null,
                'narrator_id'          => $input['narrator_id'] ?? null,
                'created_by'           => session('data')['id'] ?? 0,
                'audio_category_id'    => $input['audio_category_id'] ?? 0,
                'type'    => Audio::AUDIO,
            ];

            // Prepare language-specific data
            $languageArray = [];
            foreach ($saveArray as $key => $value) {
                if (in_array($key, config('translatable.locales'))) {
                    $languageArray[$key] = $value;
                }
            }
            // Combine audio data with language-specific data
            $audioData = $audioData + $languageArray;
            // Create the audio record
            $audio = Audio::create($audioData);

            //store audio file
            $audioFileName = null;
            $episodeTitle = $audio->translations()->first()->title ?? '';
            if (! empty($input['audio_file']) && $audio) {
                storeMedia($audio, $input['audio_file'], AUDIO::AUDIO_FILE);
                $audioFileName = $episodeTitle.'_en_'.$audio->id;
                $audio->update(['file_name' => $audioFileName]);
            }
            //store audio cover image
            if (! empty($input['cover_image']) && $audio) {
                storeMedia($audio, $input['cover_image'], AUDIO::AUDIO_COVER_IMAGE);
            }
            //store srt file
            if (! empty($input['srt_file']) && $audio) {
                storeMedia($audio, $input['srt_file'], AUDIO::AUDIO_SRT_FILE);
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
     * @param  int  $id
     * @return Application|Factory|View|\Illuminate\Http\Response
     */
    public function show($id)
    {
        $data['audio'] = Audio::find($id);
        $data['audioFile'] = $data['audio']->getMedia(Audio::AUDIO_FILE)->first()?? '';
        $data['audioCoverImage'] = $data['audio']->getMedia(Audio::AUDIO_COVER_IMAGE)->first()?? '';

        return view('backend/audio/view')->with($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $localeLanguage = \App::getLocale();
        if (str_contains($localeLanguage, 'en')) {
            $localeLanguage = 'en';
        } else {
            $localeLanguage = 'hi';
        }
        $data['audios'] = Audio::with([
            'translations' => function ($query) use ($localeLanguage) {
                $query->where('locale', $localeLanguage);
            },
        ])->where('type',Audio::AUDIO)->where('status', 1)
            ->where('id','!=',$id)
            ->get();
        $audio = Audio::with('language.translations')->find($id);
        $data['audio'] = $audio->toArray();
        foreach($data['audio']['translations'] as $trans) {
            $translated_keys = array_keys(Audio::TRANSLATED_BLOCK);
            foreach ($translated_keys as $value) {
                $data['audio'][$value.'_'.$trans['locale']] = $trans[$value];
            }
        }
        $data['translated_block'] = Audio::TRANSLATED_BLOCK;
        $data['peopleAlsoReadIds'] = explode(",", $data['audio']['people_also_read_ids'] ?? '');
        $data['audioCoverImage'] = [];
        $data['audioFile'] = [];
        $data['audioCoverImage'] = $audio->getMedia(Audio::AUDIO_COVER_IMAGE);
        $data['audioFile'] = $audio->getMedia(Audio::AUDIO_FILE);

        $data['gurus'] = Artist::with([
            'translations' => function ($query) use ($localeLanguage) {
                $query->where('locale', $localeLanguage);
            },
        ])->get();
        $data['languages'] = Language::with([
            'translations' => function ($query) use ($localeLanguage) {
                $query->where('locale', $localeLanguage);
            },
        ])->where('status', 1)->get();

        return view('backend/audio/edit',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateAudioRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAudioRequest $request)
    {
        try {
            DB::beginTransaction();
            $input = $request->all();
            //Bhagvad Geeta category id
            $input['audio_category_id'] = 1;
            $translated_keys = array_keys(Audio::TRANSLATED_BLOCK);
            foreach ($translated_keys as $value) {
                $input[$value] = (array) json_decode($input[$value]);
            }
            $saveArray = Utils::flipTranslationArray($input, $translated_keys);

            $coverImage = $input['cover_image'] ?? '';
            $coverImageName = '';
            if (!empty($coverImage)){
                $coverImageName = $coverImage->getClientOriginalName();
            }
            $hasEpisodes = $input['has_episodes'] ?? 0;
            $audioData = [
                'cover_image'          => $coverImageName,
                'has_episodes'         => $hasEpisodes,
                'people_also_read_ids' => implode(',',$input['people_also_read_ids'] ?? []),
                'language_id'          => $input['language_id'] ??null,
                'duration'             => $input['duration'] ?? null,
                'view_count'           => $input['view_count'] ?? null,
                'sequence'             => $input['sequence'] ?? null,
                'author_id'            => $input['author_id'] ?? null,
                'narrator_id'          => $input['narrator_id'] ?? null,
                'updated_by'           => session('data')['id'] ?? 0,
                'audio_category_id'    => $input['audio_category_id'] ?? 0,
            ];

            // Prepare language-specific data
            $languageArray = [];
            foreach ($saveArray as $key => $value) {
                if (in_array($key, config('translatable.locales'))) {
                    $languageArray[$key] = $value;
                }
            }
            // Combine audio data with language-specific data
            $audioData = $audioData + $languageArray;
            // Create the audio record
            $audio = Audio::find($input['id']);
            if (!empty($audio)){
                $audio->update($audioData);
            }

            //store audio file
            if (! empty($input['audio_file'])) {
                $audio->clearMediaCollection(AUDIO::AUDIO_FILE);
                storeMedia($audio, $input['audio_file'], AUDIO::AUDIO_FILE);
            }
            //store audio cover image
            if (! empty($input['cover_image'])) {
                $audio->clearMediaCollection(AUDIO::AUDIO_COVER_IMAGE);
                storeMedia($audio, $input['cover_image'], AUDIO::AUDIO_COVER_IMAGE);
            }
            //store srt file
            if (! empty($input['srt_file'])) {
                $audio->clearMediaCollection(AUDIO::AUDIO_SRT_FILE);
                storeMedia($audio, $input['srt_file'], AUDIO::AUDIO_SRT_FILE);
            }

            DB::commit();
            successMessage('Data Update successfully', []);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Something Went Wrong. Error: ".$e->getMessage());

            errorMessage("Something Went Wrong.");
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

            $audio = Audio::with('episodes')->find($id);
            if ($audio->exists()){
                $audio->episodes()->delete();
                $audio->delete();
                DB::commit();
                successMessage('Audio Deleted successfully', []);
            }

            errorMessage('Audio not found', []);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Something Went Wrong. Error: " . $e->getMessage());

            errorMessage("Something Went Wrong.");
        }
    }

    /**
     * @param $id
     *
     * Add Audio Episode form
     * @return Application|Factory|View|string
     */
    public function addEpisodes($id)
    {
        $data['audio'] = Audio::with('translations')->find($id);
        if ($data['audio']) {
            $data['audioTitle'] = $data['audio']->translations()->first();
            $data['translated_block'] = AudioEpisode::TRANSLATED_BLOCK;
            $data['audioEpisodes'] = AudioEpisode::with('translations')->where('audio_id',$id)->get();

            return view('backend/audio/add_episodes', $data);
        }

        return '';
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

            $audio = Audio::find($input['id']);
            if ($audio->exists()) {
                $audio->update($input);
                DB::commit();
                if ($request->status == 1) {
                    successMessage(trans('message.enable'), $msg_data);
                } else {
                    errorMessage(trans('message.disable'), $msg_data);
                }
            }

            errorMessage('Audio not found', []);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Something Went Wrong. Error: " . $e->getMessage());

            errorMessage("Something Went Wrong");
        }
    }

    /**
     * @param  Request  $request
     *
     * delete any media
     * @return bool
     */
    public function deleteMedia(Request $request)
    {
        try {
            DB::beginTransaction();

            $input = $request->all();
            if (! empty($input['id'])) {
                $media = Media::find($input['id']);
                if ($media->exists()) {
                    Storage::disk(config('app.media_disc'))
                        ->deleteDirectory($media->collection_name.'/'.$media->id);
                    $media->delete();

                    DB::commit();
                    return true;
                }
            }

            return false;
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error("Something Went Wrong. Error: ".$e->getMessage());
        }
    }

}
