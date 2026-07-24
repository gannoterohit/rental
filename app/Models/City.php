<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class City extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'state',
        'is_active',
        'is_default',
        'latitude',
        'longitude',
        'sort_order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_default' => 'boolean',
        'latitude' => 'decimal:7',
        'longitude' => 'decimal:7',
    ];

    protected static function booted(): void
    {
        static::saving(function (City $city) {
            if (!$city->slug) {
                $city->slug = Str::slug($city->name);
            }
        });

        static::saved(function (City $city) {
            if ($city->is_default) {
                static::whereKeyNot($city->getKey())->update(['is_default' => false]);
            }
        });
    }

    public static function findByName(?string $name): ?self
    {
        $name = trim((string) $name);
        if ($name === '') {
            return null;
        }

        return static::whereRaw('LOWER(name) = ?', [Str::lower($name)])->first();
    }

    public static function defaultCity(): ?self
    {
        return static::where('is_default', true)->first()
            ?: static::where('is_active', true)->orderBy('sort_order')->orderBy('name')->first();
    }
}
