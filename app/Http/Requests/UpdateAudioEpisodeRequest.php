<?php

namespace App\Http\Requests;

use App\Models\AudioEpisode;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class UpdateAudioEpisodeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $ruleData = [
            'id'         => 'required|integer',
            'duration'   => 'required|integer',
            'sequence'   => 'required|integer',
            'main_shlok'   => 'required',
            'explanation_shlok'   => 'required',
        ];

        $audioEpisodeId = $this->input('id');
        $audioEpisode = AudioEpisode::find($audioEpisodeId);
        if (! empty($audioEpisode)) {
            $audioFile = $audioEpisode->getMedia(AudioEpisode::EPISODE_AUDIO_FILE)->first();
            if (empty($audioFile)) {
                $ruleData['audio_file'] = 'required|mimes:mp3,wav';
            }
        }
        
        return $ruleData;
    }

    /**
     * Handle a failed validation attempt.
     *
     * @param  \Illuminate\Contracts\Validation\Validator  $validator
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function failedValidation(Validator $validator)
    {
        $response = response()->json([
            'success' => 0,
            'message' => $validator->errors()->all()
        ]);

        throw (new ValidationException($validator, $response))
            ->errorBag($this->errorBag)
            ->redirectTo($this->getRedirectUrl());
    }
}
