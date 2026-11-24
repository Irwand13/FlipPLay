<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMediaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255|unique:media,title',
            'type' => 'required|in:anime,drama,manga,light_novel',
            'genre' => 'required|string|max:100',
            'year' => 'required|integer|min:1900|max:2100',
            'creator' => 'nullable|string|max:255',
            'episodes' => 'nullable|integer|min:1',
            'is_available' => 'boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Judul media wajib diisi.',
            'title.unique' => 'Judul media sudah ada.',
            'type.in' => 'Tipe media harus anime, drama, manga, atau light_novel.',
            'genre.required' => 'Genre wajib diisi.',
            'year.required' => 'Tahun wajib diisi.',
        ];
    }
}
