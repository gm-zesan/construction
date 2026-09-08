<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Service extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = [
        'title',
        'slug',
        'short_description',
        'description',
        'icon',
        'featured',
        'sort_order',
        'is_published',
        'meta_title',
        'meta_description',
        'created_by',
        'updated_by',
    ];

    protected $appends = [
        'image_url',
    ];

    protected function casts(): array
    {
        return [
            'featured' => 'boolean',
            'is_published' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    /**
     * Register media collections for the service.
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('image')->singleFile();
        $this->addMediaCollection('gallery');
    }

    /**
     * Get the primary image URL (fallback to gallery or default placeholder if not present).
     */
    protected function imageUrl(): Attribute
    {
        return Attribute::make(
            get: function () {
                $media = $this->getFirstMedia('image') ?? $this->getFirstMedia('gallery');
                if (!$media) {
                    return asset('admin/assets/images/default.jpg');
                }

                $url = $media->getUrl();
                if (\Illuminate\Support\Str::startsWith($url, ['http://', 'https://'])) {
                    $path = parse_url($url, PHP_URL_PATH);
                    return $path ?: $url;
                }

                return $url;
            }
        );
    }

    /**
     * Get gallery items.
     */
    public function getGalleryItemsAttribute()
    {
        return $this->getMedia('gallery');
    }

    /**
     * Creator relationship.
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Updater relationship.
     */
    public function updater(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    /**
     * Client enquiries relationship.
     */
    public function enquiries(): HasMany
    {
        return $this->hasMany(ClientEnquiry::class, 'service_id');
    }

    /**
     * Scopes
     */
    public function scopePublished(Builder $query): Builder
    {
        return $query->where('is_published', true);
    }

    public function scopeFeatured(Builder $query): Builder
    {
        return $query->where('featured', true);
    }

    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('sort_order', 'asc')->orderBy('created_at', 'desc');
    }
}
