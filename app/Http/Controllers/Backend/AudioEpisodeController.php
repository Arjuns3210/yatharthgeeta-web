<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddAudioEpisodeRequest;
use App\Http\Requests\AddAudioRequest;
use App\Http\Requests\UpdateAudioEpisodeRequest;
use App\Http\Requests\UpdateAudioRequest;
use App\Models\Audio;
use App\Models\AudioEpisode;
use App\Models\AudioTranslation;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use App\Utils\Utils;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\DataTables;


class AudioEpisodeController extends Controller
{
    
    public function index(Request $request)
    {
        $input = $request->all();
        if (empty($input['audioId'])){
           
            return redirect('webadmin/audios');
        }
        
        $data['audio_episode_add'] = checkPermission('audio_episode_add');
        $data['audio_episode_edit'] = checkPermission('audio_episode_edit');
        $data['audio_episode_view'] = checkPermission('audio_episode_view');
        $data['audio_episode_status'] = checkPermission('audio_episode_status');
        $data['audio_episode_delete'] = checkPermission('audio_episode_delete');
        $data['audio_id'] = $input['audioId'];
        $data['audio'] = Audio::with('translations')->findOrFail($data['audio_id']);
        
        return view('backend/audio_episode/index',["data"=>$data]);
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
                $query = AudioEpisode::where('audio_id',$request['search']['search_audio_id'] ?? '')->orderBy('updated_at','desc');

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
                        $query->get()->toArray();
                    })
                    ->editColumn('title'.\App::getLocale(), function ($event) {
                        $key_index = array_search(\App::getLocale(), array_column($event->translations->toArray(), 'locale'));
                        return $event->translations[$key_index]->title ?? '';
                    })
                    ->editColumn('duration', function ($event) {
                        return $event->duration ??'';
                    })
                    ->editColumn('chapter', function ($event) {
                        $key_index = array_search(\App::getLocale(), array_column($event->translations->toArray(), 'locale'));
                        return $event->translations[$key_index]->chapters ?? '';
                    })
                    ->editColumn('verses', function ($event) {
                        $key_index = array_search(\App::getLocale(), array_column($event->translations->toArray(), 'locale'));
                        return $event->translations[$key_index]->verses ?? '';
                    })
                    ->editColumn('action', function ($event) {
                        $audio_episode_view = checkPermission('audio_category_view');
                        $audio_episode_edit = checkPermission('audio_category_edit');
                        $audio_episode_status = checkPermission('audio_category_status');
                        $audio_episode_delete = checkPermission('audio_category_delete');
                        $is_head = session('data')['is_head'] ?? false;
                        $actions = '<span style="white-space:nowrap;">';
                        if ($audio_episode_view) {
                            $actions .= '<a href="audio_episode/view/' . $event['id'] . '" class="btn btn-primary btn-sm src_data" data-size="large" data-title="View Category Details" title="View"><i class="fa fa-eye"></i></a>';
                        }
                        if ($audio_episode_view && $event['has_episodes'] == 1) {
                            $actions .= ' <a href="audios" class="btn btn-info btn-sm" title="Manage Episode"><i class="fa fa-archive"></i></a>';
                        }
                        if ($audio_episode_edit) {
                            $actions .= ' <a href="audio_episode/edit/' . $event['id'] . '" class="btn btn-success btn-sm src_data" title="Update"><i class="fa fa-edit"></i></a>';
                        }
                        if ($audio_episode_status) {
                            if ($event->status == '1') {
                                $actions .= ' <input type="checkbox" data-url="publish_audio_episode" id="switchery' . $event->id . '" data-id="' . $event->id . '" class="js-switch switchery" checked>';
                            } else {
                                $actions .= ' <input type="checkbox" data-url="publish_audio_episode" id="switchery' . $event->id . '" data-id="' . $event->id . '" class="js-switch switchery">';
                            }
                        }
                        if ($audio_episode_delete && $is_head){
                            $key_index = array_search(\App::getLocale(), array_column($event->translations->toArray(), 'locale'));
                            $dataUrl =  $event->translations[$key_index]->title ?? '';
                            $actions .= ' <a data-option="'.$dataUrl.'" data-url="audio_episode_delete/'.$event->id.'" class="btn btn-danger btn-sm delete-data" title="delete"><i class="fa fa-trash"></i></a>';
                        }
                        $actions .= '</span>';
                        return $actions;
                    })
                    ->addIndexColumn()
                    ->rawColumns(['title'.\App::getLocale(),'duration', 'chapters','verses', 'action'])->setRowId('id')->make(true);
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
     */
    public function create($id)
    {
        $data['audio'] = Audio::with('translations')->find($id);
        if ($data['audio']) {
            $data['audioTitle'] = $data['audio']->translations()->first();
            $data['translated_block'] = AudioEpisode::TRANSLATED_BLOCK;
            $data['audioEpisodes'] = AudioEpisode::with('translations')->where('audio_id',$id)->get();

            return view('backend/audio_episode/add', $data);
        }

        return '';
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  AddAudioEpisodeRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AddAudioEpisodeRequest $request)
    {
        try {
            DB::beginTransaction();
            $input = $request->all();
            $translated_keys = array_keys(AudioEpisode::TRANSLATED_BLOCK);
            foreach ($translated_keys as $value) {
                $input[$value] = (array) json_decode($input[$value]);
            }
            $saveArray = Utils::flipTranslationArray($input, $translated_keys);
            $audioEpisode = AudioEpisode::create($saveArray);
            $episodeTitle = $audioEpisode->translations()->first()->title ?? '';
            $audioFileName = null;
            //store audio file
            if (! empty($input['audio_file']) && $audioEpisode) {
                storeMedia($audioEpisode, $input['audio_file'], AudioEpisode::EPISODE_AUDIO_FILE);
                $audioFileName = $episodeTitle.'_en_'.$audioEpisode->id;
                $audioEpisode->update(['file_name' => $audioFileName]);
            }
            //store srt file
            if (! empty($input['srt_file']) && $audioEpisode) {
                storeMedia($audioEpisode, $input['srt_file'], AudioEpisode::EPISODE_AUDIO_SRT_FILE);
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
     * @param  int  $id
     * @return Application|Factory|View|\Illuminate\Http\Response
     */
    public function show($id)
    {
        $data['audioEpisode'] = AudioEpisode::with('translations')->findOrFail($id);
        $data['audioEpisodeFile'] = $data['audioEpisode']->getMedia(AudioEpisode::EPISODE_AUDIO_FILE)->first()?? '';
        $data['audioEpisodeSrtFile'] = $data['audioEpisode']->getMedia(Audio::AUDIO_SRT_FILE)->first()?? '';
        
        return view('backend/audio_episode/view')->with($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Application|Factory|View|\Illuminate\Http\Response
     */
    public function edit($id)
    {
        $audioEpisode = AudioEpisode::with('translations')->find($id);
        $data['audioEpisode'] = $audioEpisode->toArray();
        foreach($data['audioEpisode']['translations'] as $trans) {
            $translated_keys = array_keys(AudioEpisode::TRANSLATED_BLOCK);
            foreach ($translated_keys as $value) {
                $data['audioEpisode'][$value.'_'.$trans['locale']] = $trans[$value];
            }
        }
        $data['translated_block'] = AudioEpisode::TRANSLATED_BLOCK;
        $data['audioFile'] = $audioEpisode->getMedia(AudioEpisode::EPISODE_AUDIO_FILE);
        $data['srtFile'] = $audioEpisode->getMedia(AudioEpisode::EPISODE_AUDIO_SRT_FILE);
        
        return view('backend/audio_episode/edit',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateAudioEpisodeRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAudioEpisodeRequest $request)
    {
        try {
            DB::beginTransaction();
            $input = $request->all();
            $translated_keys = array_keys(AudioEpisode::TRANSLATED_BLOCK);
            foreach ($translated_keys as $value) {
                $input[$value] = (array) json_decode($input[$value]);
            }
            $saveArray = Utils::flipTranslationArray($input, $translated_keys);
            $audioEpisode = AudioEpisode::with('translations')->find($input['id']);
            if ($audioEpisode){
                $audioEpisode->update($saveArray);
            }
            $episodeTitle = $audioEpisode->translations()->first()->title ?? '';
            $audioFileName = null;
            //store audio file
            if (! empty($input['audio_file']) && $audioEpisode) {
                $audioEpisode->clearMediaCollection(AudioEpisode::EPISODE_AUDIO_FILE);
                storeMedia($audioEpisode, $input['audio_file'], AudioEpisode::EPISODE_AUDIO_FILE);
                $audioFileName = $episodeTitle.'_en_'.$audioEpisode->id;
                $audioEpisode->update(['file_name' => $audioFileName]);
            }
            //store srt file
            if (! empty($input['srt_file']) && $audioEpisode) {
                $audioEpisode->clearMediaCollection(AudioEpisode::EPISODE_AUDIO_SRT_FILE);
                storeMedia($audioEpisode, $input['srt_file'], AudioEpisode::EPISODE_AUDIO_SRT_FILE);
            }
            DB::commit();

            successMessage('Data Updated successfully', []);
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

            $audioEpisode = AudioEpisode::find($id);
            if (!empty($audioEpisode)){
                $audioEpisode->delete();
                DB::commit();
                successMessage('Audio Episode Deleted successfully', []);
            }

            errorMessage('Audio Episode not found', []);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Something Went Wrong. Error: " . $e->getMessage());

            errorMessage("Something Went Wrong.");
        }
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

            $audioEpisode = AudioEpisode::find($input['id']);
            if ($audioEpisode->exists()) {
                $audioEpisode->update($input);
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
}
