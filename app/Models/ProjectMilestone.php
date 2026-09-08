<?php

namespace App\Models;

use App\Enums\MilestoneStatus;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class ProjectMilestone extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = [
        'project_id',
        'title',
        'slug',
        'description',
        'target_date',
        'completion_date',
        'status',
        'progress_percentage',
        'sort_order',
        'is_published',
        'created_by',
        'updated_by',
    ];

    protected function casts(): array
    {
        return [
            'target_date' => 'date',
            'completion_date' => 'date',
            'status' => MilestoneStatus::class,
            'progress_percentage' => 'integer',
            'sort_order' => 'integer',
            'is_published' => 'boolean',
        ];
    }

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function (ProjectMilestone $milestone) {
            if (empty($milestone->slug)) {
                $baseSlug = Str::slug($milestone->title);
                $slug = $baseSlug;
                $count = 1;
                while (static::where('slug', $slug)->exists()) {
                    $slug = "{$baseSlug}-{$count}";
                    $count++;
                }
                $milestone->slug = $slug;
            }
        });
    }

    /**
     * Relationship to Project.
     */
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class, 'project_id');
    }

    /**
     * Relationship to Creator user.
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Relationship to Updater user.
     */
    public function updater(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    /**
     * Register Spatie media collection.
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('image')->singleFile();
    }

    /**
     * Get primary site photo verification URL.
     */
    protected function imageUrl(): \Illuminate\Database\Eloquent\Casts\Attribute
    {
        return \Illuminate\Database\Eloquent\Casts\Attribute::make(
            get: function () {
                $media = $this->getFirstMedia('image');
                if (!$media) {
                    return null;
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
     * Scopes
     */
    public function scopePublished(Builder $query): Builder
    {
        return $query->where('is_published', true);
    }

    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('sort_order', 'asc')->orderBy('target_date', 'asc');
    }

    public function scopeByProject(Builder $query, int $projectId): Builder
    {
        return $query->where('project_id', $projectId);
    }

    public function scopeByStatus(Builder $query, string|MilestoneStatus $status): Builder
    {
        $statusValue = $status instanceof MilestoneStatus ? $status->value : $status;
        return $query->where('status', $statusValue);
    }
}
