<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSubmissionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|min:2|max:10',
            'email' => [
                'required',
                'email',
                'regex:/^[a-zA-Z0-9._%+-]+@((?!gmail\.com)[a-zA-Z0-9.-]+)\.[a-zA-Z]{2,}$/'
            ],
            'phone' => 'required|regex:/^\+\d{1,4}\s?\d{7,15}$/',
            'message' => 'required|string|min:10',
            'street' => 'required|string',
            'state' => 'required|string',
            'zip' => 'required|string',
            'country' => 'required|string',
            'images.*' => 'nullable|mimes:jpg|max:2048',
            'files.*' => 'nullable|mimes:pdf|max:5120',
        ];
    }

    public function messages(): array
    {
        return [
            'email.regex' => 'Gmail addresses are not allowed.',
            'phone.regex' => 'Invalid phone number format. Use country prefix.',
            'image.mimes' => 'Only JPG images are allowed.',
            'file.mimes' => 'Only PDF files are allowed.',
        ];
    }
}

