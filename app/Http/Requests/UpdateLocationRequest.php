<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class UpdateLocationRequest extends FormRequest
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
        return [
            'email' => 'required',
            'phone' => 'required|regex:/^\d+(,\d+)*$/',
            'sequence'     => 'required|integer',
            'location'  => 'required',
            'name'  => 'required',
            'title'  => 'required',
            'description'  => 'required',
            'monday_open' => 'required_without_all:tuesday_open,wednesday_open,thursday_open,friday_open,saturday_open,sunday_open',
            'tuesday_open' => 'required_without_all:monday_open,wednesday_open,thursday_open,friday_open,saturday_open,sunday_open',
            'wednesday_open' => 'required_without_all:monday_open,tuesday_open,thursday_open,friday_open,saturday_open,sunday_open',
            'thursday_open' => 'required_without_all:monday_open,tuesday_open,wednesday_open,friday_open,saturday_open,sunday_open',
            'friday_open' => 'required_without_all:monday_open,tuesday_open,wednesday_open,thursday_open,saturday_open,sunday_open',
            'saturday_open' => 'required_without_all:monday_open,tuesday_open,wednesday_open,thursday_open,friday_open,sunday_open',
            'sunday_open' => 'required_without_all:monday_open,tuesday_open,wednesday_open,thursday_open,friday_open,saturday_open'
            ];
    }

    public function messages()
    {
        return [
            'required_without_all' => 'Please select at least one day.',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $messages = $validator->errors()->all();

        // Filter duplicate messages.
        $filteredMessages = [];
        foreach ($messages as $message) {
            if (!in_array($message, $filteredMessages)) {
                $filteredMessages[] = $message;
            }
        }

        // Show the validation messages to the user.
        $response = response()->json([
            'success' => 0,
            'message' => $filteredMessages,
        ]);

        throw (new ValidationException($validator, $response))
            ->errorBag($this->errorBag)
            ->redirectTo($this->getRedirectUrl());
    }

}
