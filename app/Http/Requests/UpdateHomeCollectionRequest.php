<?php

namespace App\Http\Requests;

use App\Models\HomeCollection;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class UpdateHomeCollectionRequest extends FormRequest
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
            'id'              => 'required',
            'collection_type' => 'required|in:Single,Multiple,Book,Audio,Video,Shlok,Artist',
            'language_id'     => 'required|integer',
            'title'           => 'required|max:255',
            'description'     => 'required|max:255',
            'sequence'        => 'required|integer',
        ];
        $collectionType = $this->input('collection_type');
        if ($collectionType == HomeCollection::SINGLE_COLLECTION_IMAGE) {
            $ruleData['single_image'] = 'nullable|mimes:jpeg,jpg,png,gif';
        }
        if ($collectionType == HomeCollection::BOOK) {
            $ruleData['book_id'] = 'required';
        }
        if ($collectionType == HomeCollection::AUDIO) {
            $ruleData['audio_id'] = 'required';
        }
        if ($collectionType == HomeCollection::VIDEO) {
            $ruleData['video_id'] = 'required';
        }
        if ($collectionType == HomeCollection::SHLOK) {
            $ruleData['shlok_id'] = 'required';
        }
        if ($collectionType == HomeCollection::SHLOK) {
            $ruleData['artist_id'] = 'required';
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
