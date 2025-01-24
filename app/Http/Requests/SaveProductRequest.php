<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaveProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get validation rules
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|min:2|max:100',
            'brand' => 'required|string|min:2|max:50',
            'link' => 'nullable|string',
            'description' => 'required|string|min:10',
            'release_date' => 'required|date',
            'price' => 'required|numeric|min:0.01',
            'services' => 'required|array',
        ];
    }
}
