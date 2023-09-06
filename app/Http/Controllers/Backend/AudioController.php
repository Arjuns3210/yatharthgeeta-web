<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddAudioRequest;
use App\Http\Requests\UpdateAudioRequest;
use App\Models\Audio;
use App\Models\AudioEpisode;
use App\Models\AudioTranslation;
use App\Models\Media;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use App\Utils\Utils;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
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
        if ($request->ajax()) {
            try {
                $query = Audio::orderBy('updated_at','desc');

                return DataTables::of($query)
                    ->filter(function ($query) use ($request) {
                        if (isset($request['search']['search_title']) && !is_null($request['search']['search_title'])) {
                            $query->whereHas('translations', function ($translationQuery) use ($request) {
                                $translationQuery->where('title', 'like', "%" . $request['search']['search_title'] . "%");
                            });
                        }
                        if (isset($request['search']['search_status']) && !is_null($request['search']['search_status'])) {
                            $query->where('status', $request['search']['search_status']);
                        }
                        $query->get()->toArray();
                    })
                    ->editColumn('title'.\App::getLocale(), function ($event) {
                        $key_index = array_search(\App::getLocale(), array_column($event->translations->toArray(), 'locale'));
                        return $event->translations[$key_index]->title ?? '';
                    })
                    ->editColumn('duration', function ($event) {
                        return $event->duration ??'';
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
                            $actions .= ' <a href="audio_episodes?audioId=' . $event->id . '" class="btn btn-info btn-sm" title="Manage Episode"><i class="fa fa-archive"></i></a>';
                        }
                        $actions .= '</span>';
                        return $actions;
                    })
                    ->addIndexColumn()
                    ->rawColumns(['title'.\App::getLocale(),'duration', 'status', 'action'])->setRowId('id')->make(true);
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
        if ($localeLanguage == 'en-US') {
            $localeLanguage = 'en';
        } else {
            $localeLanguage = 'hi';
        }

        $data['translated_block'] = Audio::TRANSLATED_BLOCK;
        $data['audios'] = Audio::with([
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
            
            $coverImage = $input['cover_image'] ?? '';
            $coverImageName = '';
            if (!empty($coverImage)){
                $coverImageName = $coverImage->getClientOriginalName();
            }
            $srtFile = $input['srt_file'] ?? '';
            $srtFileName = '';
            $hasEpisodes = $input['has_episodes'] ?? 0;
            if (!empty($srtFile)){
                $srtFileName = $srtFile->getClientOriginalName();
            }
            $audioData = [
                'cover_image'          => $coverImageName,
                'srt_file_name'        => $srtFileName,
                'has_episodes'         => $hasEpisodes,
                'people_also_read_ids' => implode(',',$input['people_also_read_ids'] ?? []),
                'language_id'          => 1,
                'duration'             => $input['duration'] ?? null,
                'sequence'             => $input['sequence'] ?? null,
                'author_id'            => $input['author_id'] ?? null,
                'narrator_id'          => $input['narrator_id'] ?? null,
                'created_by'           => session('data')['id'] ?? 0,
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
        $data['audio'] = Audio::with('translations')->findOrFail($id);
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
        if ($localeLanguage == 'en-US') {
            $localeLanguage = 'en';
        } else {
            $localeLanguage = 'hi';
        }
        $data['audios'] = Audio::with([
            'translations' => function ($query) use ($localeLanguage) {
                $query->where('locale', $localeLanguage);
            },
        ])->where('status', 1)->get();
        $audio = Audio::find($id);
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
        $data['srtFile'] = [];
        $data['audioCoverImage'] = $audio->getMedia(Audio::AUDIO_COVER_IMAGE);
        $data['audioFile'] = $audio->getMedia(Audio::AUDIO_FILE);
        $data['srtFile'] = $audio->getMedia(Audio::AUDIO_SRT_FILE);
        
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
            $srtFile = $input['srt_file'] ?? '';
            $srtFileName = '';
            $hasEpisodes = $input['has_episodes'] ?? 0;
            if (!empty($srtFile)){
                $srtFileName = $srtFile->getClientOriginalName();
            }
            $audioData = [
                'cover_image'          => $coverImageName,
                'srt_file_name'        => $srtFileName,
                'has_episodes'         => $hasEpisodes,
                'people_also_read_ids' => implode(',',$input['people_also_read_ids'] ?? []),
                'language_id'          => 1,
                'duration'             => $input['duration'] ?? null,
                'sequence'             => $input['sequence'] ?? null,
                'author_id'            => $input['author_id'] ?? null,
                'narrator_id'          => $input['narrator_id'] ?? null,
                'updated_by'           => session('data')['id'] ?? 0,
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
                if ($input['status'] == 1) {
                    successMessage('Published', $msg_data);
                } else {
                    successMessage('Unpublished', $msg_data);
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
