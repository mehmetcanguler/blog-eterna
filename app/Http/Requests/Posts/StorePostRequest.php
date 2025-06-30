<?php

namespace App\Http\Requests\Posts;

use App\Dtos\Posts\PostDTO;
use App\Rules\UniqueSlugPerOwner;
use Auth;
use Illuminate\Foundation\Http\FormRequest;

class StorePostRequest extends FormRequest
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
            'title' => [
                'required',
                'max:255',
                new UniqueSlugPerOwner(
                    modelClass: \App\Models\Post::class,
                    ownerColumn: 'author_id',
                    ownerId: Auth::user()->id,
                    slugColumn: 'slug',
                ),
            ],
            'content' => 'required|max:10000',
            'cover_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'gallery_images' => 'required|array',
            'gallery_images.*' => 'required|image|mimes:jpeg,png,jpg,gif,webp,svg|max:2048',
            'categories' => 'required|array',
            'categories.*' => 'exists:categories,id',
        ];
    }

    public function attributes()
    {
        return [
            'title' => trans('attributes.title'),
            'content' => trans('attributes.content'),
            'cover_image' => trans('attributes.cover_image'),
            'gallery_images' => trans('attributes.gallery_images'),
            'categories' => trans('attributes.categories'),
        ];
    }

    public function toDto(): PostDTO
    {
        return PostDTO::fromRequest($this->validated());
    }
}
