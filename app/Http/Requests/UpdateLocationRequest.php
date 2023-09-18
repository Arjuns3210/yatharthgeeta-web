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
            'sunday_open' => 'required_without_all:monday_open,tuesday_open,wednesday_open,thursday_open,friday_open,saturday_open',
            'monday_end_time' => function ($attribute, $value, $fail) {
                $mondayStartTime = request('monday_start_time');
                if (!empty($mondayStartTime) && $value < $mondayStartTime) {
                    $fail('The Monday end time must be greater than or equal to the Monday start time.');
                }
            },
            'tuesday_end_time' => function ($attribute, $value, $fail) {
                $tuesdayStartTime = request('tuesday_start_time');
                if (!empty($tuesdayStartTime) && $value < $tuesdayStartTime) {
                    $fail('The Tuesday end time must be greater than or equal to the Tuesday start time.');
                }
            },
            'wednesday_end_time' => function ($attribute, $value, $fail) {
                $wednesdayStartTime = request('wednesday_start_time');
                if (!empty($wednesdayStartTime) && $value < $wednesdayStartTime) {
                    $fail('The Wednesday end time must be greater than or equal to the Wednesday start time.');
                }
            },
            'thursday_end_time' => function ($attribute, $value, $fail) {
                $thursdayStartTime = request('thursday_start_time');
                if (!empty($thursdayStartTime) && $value < $thursdayStartTime) {
                    $fail('The Thursday end time must be greater than or equal to the Thursday start time.');
                }
            },
            'friday_end_time' => function ($attribute, $value, $fail) {
                $fridayStartTime = request('friday_start_time');
                if (!empty($fridayStartTime) && $value < $fridayStartTime) {
                    $fail('The Friday end time must be greater than or equal to the Friday start time.');
                }
            },
            'saturday_end_time' => function ($attribute, $value, $fail) {
                $saturdayStartTime = request('saturday_start_time');
                if (!empty($saturdayStartTime) && $value < $saturdayStartTime) {
                    $fail('The Saturday end time must be greater than or equal to the Saturday start time.');
                }
            },
            'sunday_end_time' => function ($attribute, $value, $fail) {
                $sundayStartTime = request('sunday_start_time');
                if (!empty($sundayStartTime) && $value < $sundayStartTime) {
                    $fail('The Sunday end time must be greater than or equal to the Sunday start time.');
                }
            },
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
