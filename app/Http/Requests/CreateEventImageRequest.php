<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class CreateEventImageRequest extends FormRequest
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
        $coverImageMaxWidth = config('global.dimensions.home_banners_width');
        $coverImageMaxHeight = config('global.dimensions.home_banners_height');
      
        return [
            'event_images.*' => 'required|mimes:jpeg,jpg,png,gif|dimensions:width=' . $coverImageMaxWidth . ',height=' . $coverImageMaxHeight,
        ];

    }

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
