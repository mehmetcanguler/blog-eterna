<?php

namespace App\Http\Requests;

use App\Dtos\FilterDTO;
use App\Dtos\ListDTO;
use Illuminate\Foundation\Http\FormRequest;

class ListRequest extends FormRequest
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
            'search' => 'nullable|string',
            'per_page' => 'nullable|integer',
        ];
    }

    public function attributes()
    {
        return [
            'search' => trans('attributes.search'),
            'per_page' => trans('attributes.per_page'),
        ];
    }

    public function toDto(): ListDTO
    {
        return ListDTO::fromRequest($this->validated());
    }
}
