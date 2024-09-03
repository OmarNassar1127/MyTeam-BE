<?php

namespace App\Http\App\Controllers\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSessionRequest extends FormRequest
{
    public function authorize()
    {
        return $this->user()->role === 'manager';
    }

    public function rules()
    {
        return [
            'date' => 'required|date',
            'notes' => 'nullable|string',
            'is_weekly' => 'required|boolean',
            'end_date' => 'required_if:is_weekly,true|nullable|date|after:date',
        ];
    }

    public function messages()
    {
        return [
            'date.required' => 'A date is required for the session.',
            'is_weekly.required' => 'Please specify if this is a weekly session.',
            'end_date.required_if' => 'An end date is required for weekly sessions.',
            'end_date.after' => 'The end date must be after the start date.',
        ];
    }
}