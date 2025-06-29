<?php

namespace App\Http\Requests\Posts;

use App\Dtos\Posts\PostUpdateDTO;
use Illuminate\Foundation\Http\FormRequest;

class UpdatePostRequest extends FormRequest
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
            'title' => 'required|max:255',
            'content' => 'required|max:10000',
            'categories' => 'required|array',
            'categories.*' => 'exists:categories,id',
        ];
    }

    public function attributes()
    {
        return [
            'title' => trans('attributes.title'),
            'content' => trans('attributes.content'),
            'categories' => trans('attributes.categories'),
        ];
    }

    public function toDto(): PostUpdateDTO
    {
        return PostUpdateDTO::fromRequest($this->validated());
    }
}
