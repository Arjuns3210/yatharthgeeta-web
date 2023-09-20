<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class AddBookRequest extends FormRequest
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
        $coverImageMaxWidth = config('global.dimensions.books_width');
        $coverImageMaxHeight = config('global.dimensions.books_height');
        
        return [
            'name'       => 'required',
            'pdf_file_name'  => 'required|mimes:pdf',
            'cover_image'=> "required|mimes:jpeg,jpg,png|dimensions:width={$coverImageMaxWidth},height={$coverImageMaxHeight}",
            'pages'      => 'required|integer',
            'sequence'   => 'required|integer',
            'language_id'=> 'required',
            'artist_id'       => 'required',
        ];
    }

    /**
     * Custom message for validation
     *
     * @return array
     */
    public function messages()
    {
        return [
            'pdf_file_name.required' => 'PDF file field is required',
        ];
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
