<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class ClientReview extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = [
        'client_name',
        'designation',
        'company_name',
        'review',
        'rating',
        'project_id',
        'featured',
        'is_published',
        'sort_order',
        'created_by',
        'updated_by',
    ];

    protected $appends = [
        'client_photo_url',
    ];

    protected function casts(): array
    {
        return [
            'rating' => 'integer',
            'featured' => 'boolean',
            'is_published' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    /**
     * Register Spatie media collection for client photo.
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('client_photo')->singleFile();
    }

    /**
     * Get the client photo avatar URL.
     */
    public function getClientPhotoUrlAttribute(): ?string
    {
        return $this->getFirstMediaUrl('client_photo') ?: null;
    }

    /**
     * Associated construction project.
     */
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class, 'project_id');
    }

    /**
     * User who created the review.
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * User who last updated the review.
     */
    public function updater(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    /**
     * Scope for published / visible reviews.
     */
    public function scopePublished(Builder $query): Builder
    {
        return $query->where('is_published', true);
    }

    /**
     * Scope for featured reviews on homepage.
     */
    public function scopeFeatured(Builder $query): Builder
    {
        return $query->where('featured', true);
    }
}
