<?php

namespace FreeThinkerz\LaravelPay\Helper;

use Illuminate\Support\Str;

trait ModelUUID
{
    /**
     * Set UUID for newly created Models.
     */
    protected static function boot(): void
    {
        parent::boot();

        static::creating(function ($model) {
            $model->{$model->getKeyName()} = (string) Str::uuid();
        });
    }
}
