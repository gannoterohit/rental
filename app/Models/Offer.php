<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Offer extends Model
{
    public const PLACEMENTS = [
        'top_nav' => 'Top announcement bar',
        'home_hero' => 'Home page promotion',
        'dashboard' => 'User / owner dashboard',
        'sidebar' => 'Room and blog sidebar',
        'mobile_feed' => 'Mobile listing feed',
        'popup' => 'Timed public-page popup',
    ];
    protected $fillable = [
        'title',
        'description',
        'image_path',
        'link_url',
        'placement',
        'type',
        'discount_text',
        'target_audience',
        'banner_color',
        'is_active',
        'start_date',
        'end_date',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    /**
     * Get the image URL
     */
    public function getImageUrlAttribute()
    {
        if (!$this->image_path) {
            return null;
        }
        if (filter_var($this->image_path, FILTER_VALIDATE_URL)) {
            return $this->image_path;
        }
        return asset('storage/' . $this->image_path);
    }

    /**
     * Check if offer is currently valid
     */
    public function isValid()
    {
        if (!$this->is_active) {
            return false;
        }

        $now = Carbon::now();

        if ($this->start_date && $now->lt($this->start_date)) {
            return false;
        }

        if ($this->end_date && $now->gt($this->end_date->copy()->endOfDay())) {
            return false;
        }

        return true;
    }

    /**
     * Scope for active offers
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true)
            ->where(function($q) {
                $q->whereNull('start_date')
                  ->orWhereDate('start_date', '<=', today());
            })
            ->where(function($q) {
                $q->whereNull('end_date')
                  ->orWhereDate('end_date', '>=', today());
            });
    }

    /**
     * Scope for specific audience
     */
    public function scopeForAudience($query, $audience)
    {
        return $query->where(function($q) use ($audience) {
            $q->where('target_audience', $audience)
              ->orWhere('target_audience', 'both');
        });
    }
}
