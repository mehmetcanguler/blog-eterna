<?php

namespace App\Http\Requests\Comments;

use App\Dtos\Comments\CommentDTO;
use App\Rules\Comments\ValidPostVisibility;
use Illuminate\Foundation\Http\FormRequest;

class StoreCommentRequest extends FormRequest
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
            'post_id' => [
                'required',
                'exists:posts,id',
                new ValidPostVisibility(),
            ],
        ];
    }

    public function attributes(): array
    {
        return [
            'content' => trans('attributes.content'),
            'post_id' => trans('attributes.post_id'),
        ];
    }

    public function toDto(): CommentDTO
    {
        return CommentDTO::fromRequest($this->validated());
    }
}
