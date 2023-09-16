<?php

namespace App\Http\Requests;

use App\Models\Quote;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class UpdateQuoteRequest extends FormRequest
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
        $ruleData= [
			'id' => 'required',
            'title' => 'required',
            'sequence' => 'required|integer',
			'image'   => 'required|mimes:jpeg,jpg,png',
        ];
		
		$quoteId = $this->input('id');
        $quote = Quote::find($quoteId);
        if (! empty($quote)) {
            $quoteImage = $quote->getMedia(Quote::IMAGE)->first();
            if (empty($quoteImage)) {
                $ruleData['image'] = 'required|mimes:jpeg,jpg,png';
            }
        }
        
        return $ruleData;
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
