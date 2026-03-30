<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreContactRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'name' => strip_tags($this->name),
            'email' => strip_tags($this->email),
            'message' => strip_tags($this->message),
        ]);
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min:2', 'max:100'],
            'email' => ['required', 'email:rfc,filter', 'max:150'],
            'message' => ['required', 'string', 'min:10', 'max:2000'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.min' => 'Your name must be at least 2 characters.',
            'email.email' => 'Please enter a valid email address.',
            'message.min' => 'Your message must be at least 10 characters.',
            'message.max' => 'Your message must not exceed 2000 characters.',
        ];
    }
}
