<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Event extends Model implements HasMedia
{
    use HasFactory, SoftDeletes, InteractsWithMedia;

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('cover')->singleFile();
    }

    protected $fillable = [
        'organization_id',
        'venue_id',
        'category_id',
        'uuid',
        'title',
        'slug',
        'description',
        'seo_title',
        'seo_description',
        'subdomain',
        'use_venue_capacity',
        'max_capacity',
        'price_cents',
        'start_date',
        'end_date',
        'event_image',
        'header_image',
        'background_image',
        'is_published',
        'published_at',
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'is_published' => 'boolean',
        'use_venue_capacity' => 'boolean',
        'published_at' => 'datetime',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }
}
