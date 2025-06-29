<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait HasSlug
{
    abstract protected function getSlugSource(): string;

    protected function getSlugField(): string
    {
        return 'slug';
    }

    public static function bootHasSlug()
    {
        static::creating(function ($model) {
            $model->generateSlug();
        });

        static::updating(function ($model) {
            if ($model->isDirty($model->getSlugSource())) {
                $model->generateSlug();
            }
        });
    }

    public function generateSlug()
    {
        $source = $this->getSlugSource();
        $slugField = $this->getSlugField();

        $this->$slugField = Str::slug($this->$source);
    }
}
