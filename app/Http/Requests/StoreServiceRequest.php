<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreServiceRequest extends FormRequest
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
            'nom' => 'required|string|max:255|unique:services,nom',
            'description' => 'nullable|string|max:1000',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     */
    public function messages(): array
    {
        return [
            'nom.required' => 'Le nom du service est obligatoire',
            'nom.max' => 'Le nom ne doit pas dépasser 255 caractères',
            'nom.unique' => 'Ce nom de service existe déjà',
            'description.max' => 'La description ne doit pas dépasser 1000 caractères',
            'image.image' => 'Le fichier doit être une image',
            'image.mimes' => 'L\'image doit être au format jpeg, png, jpg, gif ou webp',
            'image.max' => 'L\'image ne doit pas dépasser 2 Mo',
        ];
    }
}
