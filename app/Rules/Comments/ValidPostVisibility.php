<?php

namespace App\Rules\Comments;

use App\Models\Post;
use App\Enums\PostStatus;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Auth;
/**
 * Yorumlar için gönderilen post_id yi görme yetkisinin olup olmadığını kontrol eder
 */
class ValidPostVisibility implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $post = Post::find($value);

        if (!$post) {
            $fail(__('validation.exists', ['attribute' => __("attributes.$attribute")]));
        }

        if (!Auth::user()->can('publish', $post)) {
            if ($post->author_id !== Auth::id()) {
                $fail(__('validation.exists', ['attribute' => __("attributes.$attribute")]));
            }
        }
    }
}
