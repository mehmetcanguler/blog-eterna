<?php

namespace App\Http\Requests\Comments;

use App\Dtos\Comments\CommentListDTO;
use App\Http\Requests\ListRequest;

class ListCommentRequest extends ListRequest
{
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
            'post_id' => 'required|exists:posts,id',
        ];
    }

    public function attributes()
    {
        return [
            'search' => trans('attributes.search'),
            'per_page' => trans('attributes.per_page'),
            'post_id' => trans('attributes.post_id'),
        ];
    }
    public function toDto(): CommentListDTO
    {
        return CommentListDTO::fromRequest($this->validated());
    }
}
