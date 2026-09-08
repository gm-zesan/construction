<?php

namespace App\Models;

use App\Enums\ProjectStatus;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Project extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = [
        'title',
        'slug',
        'category',
        'client_name',
        'location',
        'start_date',
        'completion_date',
        'status',
        'short_description',
        'description',
        'featured',
        'sort_order',
        'is_published',
        'meta_title',
        'meta_description',
        'created_by',
        'updated_by',
    ];

    protected $appends = [
        'main_image_url',
    ];

    protected function casts(): array
    {
        return [
            'status' => ProjectStatus::class,
            'start_date' => 'date',
            'completion_date' => 'date',
            'featured' => 'boolean',
            'is_published' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    /**
     * Register media collections for project gallery and main imagery.
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('main_image')->singleFile();
        $this->addMediaCollection('gallery');
        $this->addMediaCollection('documents');
    }

    /**
     * Get the primary image URL (fallback to gallery or default placeholder if not present).
     */
    protected function mainImageUrl(): Attribute
    {
        return Attribute::make(
            get: function () {
                $media = $this->getFirstMedia('main_image') ?? $this->getFirstMedia('gallery');
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
     * Check if project has a custom main image.
     */
    public function hasMainImage(): bool
    {
        return $this->hasMedia('main_image');
    }

    /**
     * Get all gallery media items.
     */
    public function getGalleryItemsAttribute()
    {
        return $this->getMedia('gallery');
    }

    /**
     * Get all document media items.
     */
    public function getDocumentItemsAttribute()
    {
        return $this->getMedia('documents');
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
     * Enquiries related to this project.
     */
    public function enquiries(): HasMany
    {
        return $this->hasMany(ClientEnquiry::class, 'project_id');
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

    public function scopeByStatus(Builder $query, ProjectStatus|string $status): Builder
    {
        $statusValue = $status instanceof ProjectStatus ? $status->value : $status;
        return $query->where('status', $statusValue);
    }

    public function scopeByCategory(Builder $query, string $category): Builder
    {
        return $query->where('category', $category);
    }

    /**
     * Relationship to ProjectMilestones.
     */
    public function milestones(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(ProjectMilestone::class, 'project_id')->ordered();
    }
}
