<?php

namespace App\Http\Requests;

use App\Models\Audio;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class UpdatePravachanRequest extends FormRequest
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
            'id'           => 'required',
            'duration'     => 'required|integer',
            'sequence'     => 'required|integer',
            'language_id'  => 'required',
            'author_id'  => 'required',
        ];
        
        $pravachanId = $this->input('id');
        $pravachan = Audio::find($pravachanId);
        if (! empty($pravachan)) {
            $audioCoverImage = $pravachan->getMedia(Audio::AUDIO_COVER_IMAGE)->first();
            if (empty($audioCoverImage)) {
                $ruleData['cover_image'] = 'required|mimes:jpeg,jpg,png,gif';
            }
            $audioFile = $pravachan->getMedia(Audio::AUDIO_FILE)->first();
            if (empty($audioFile)) {
                $ruleData['audio_file'] = 'required|mimes:mp3';
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
