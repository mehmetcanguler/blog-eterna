<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Str;

/**
 * Slug değerinin benzersiz olup olmadığını kontrol eder
 */
class UniqueSlugPerOwner implements ValidationRule
{

    public function __construct(
        protected string $modelClass,
        protected string $ownerColumn,
        protected mixed $ownerId,
        protected string $slugColumn = 'slug',
        protected ?string $ignoreId = null
    ) {
        $this->modelClass = $modelClass;
        $this->ownerColumn = $ownerColumn;
        $this->ownerId = $ownerId;
        $this->slugColumn = $slugColumn;
        $this->ignoreId = $ignoreId;
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $slug = Str::slug($value);

        $query = ($this->modelClass)::where($this->slugColumn, $slug)
            ->where($this->ownerColumn, $this->ownerId);

        if ($this->ignoreId) {
            $query->where('id', '!=', $this->ignoreId);
        }

        if ($query->exists()) {
            $fail(trans('validation.unique', ['attribute' => __("attributes.$attribute")]));
        }
    }
}
