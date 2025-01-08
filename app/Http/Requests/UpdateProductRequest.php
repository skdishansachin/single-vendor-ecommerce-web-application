<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'collection' => ['nullable', 'exists:collections,id'],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'price' => ['required', 'numeric', 'min:0'], // TODO - Make sure that `min` is used correctly
            'available' => ['required', 'integer', 'min:1'],
            'media' => ['nullable', 'array', 'max:3'], // TODO - Decide on the max number of media files
            'media.*' => ['nullable', 'file', 'mimes:jpeg,png,webp', 'max:2048'], // TODO - Make sure that `max` is used correctly to limit the file size
        ];
    }

    /**
     * Get custom messages for validation errors.
     */
    public function messages(): array
    {
        return [
            'collection_id.exists' => 'The selected collection does not exist.',
            'media.required' => 'Please upload at least one image for the product.',
        ];
    }
}
