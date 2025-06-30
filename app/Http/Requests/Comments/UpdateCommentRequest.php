<?php

namespace App\Http\Requests\Comments;

use App\Dtos\Comments\CommentUpdateDTO;
use Illuminate\Foundation\Http\FormRequest;

class UpdateCommentRequest extends FormRequest
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
            'content' => 'required|string',
        ];
    }

    public function attributes(): array
    {
        return [
            'content' => trans('attributes.content'),
        ];
    }

    public function toDto(): CommentUpdateDTO
    {
        return CommentUpdateDTO::fromRequest($this->validated());
    }
}
