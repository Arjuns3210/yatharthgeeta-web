<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class CreateEventRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true; // Adjust as needed based on your authorization logic
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'event_start_date' => 'required|date',
            'event_start_time' => 'required|date_format:H:i',
            'event_end_date' => 'required|date|after_or_equal:event_start_date',
            'event_end_time' => 'required|date_format:H:i|after_or_equal:event_start_time',
            'artist_id' => 'required',
            'location_id' => 'required',
            'cover'  => "required|mimes:jpeg,jpg,png,gif",
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
            'event_end_date.after_or_equal' => 'Event Start date cannot be greater than Event end  date.',
            'event_end_time.after_or_equal' => 'Event Start time cannot be greater than Event end  time.',
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
