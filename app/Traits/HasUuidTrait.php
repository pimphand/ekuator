<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait HasUuidTrait
{
    /**
     * The "booting" method of the trait.
     *
     * @return void
     */
    protected static function bootHasUuidTrait()
    {
        static::creating(function ($model) {
            $model->{$model->getKeyName()} = (string) Str::uuid();
        });
    }
}
