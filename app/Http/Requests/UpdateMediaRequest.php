<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateMediaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => ['sometimes', 'string', 'max:255', Rule::unique('media', 'title')->ignore($this->route('media'))],
            'type' => 'sometimes|in:anime,drama,manga,light_novel',
            'genre' => 'sometimes|string|max:100',
            'year' => 'sometimes|integer|min:1900|max:2100',
            'creator' => 'sometimes|nullable|string|max:255',
            'episodes' => 'sometimes|nullable|integer|min:1',
            'is_available' => 'sometimes|boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'title.unique' => 'Judul media sudah ada.',
            'type.in' => 'Tipe media harus anime, drama, manga, atau light_novel.',
        ];
    }
}
