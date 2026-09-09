<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class WebsiteContent extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $table = 'website_contents';

    protected $fillable = [
        'page',
        'section',
        'key',
        'value',
        'type',
        'label',
    ];

    protected $appends = [
        'image_url',
    ];

    /**
     * Register single-file media collection for images/banners.
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('image')->singleFile();
    }

    /**
     * Cache key generator for a given page.
     */
    public static function getCacheKey(string $page): string
    {
        return "website_content.{$page}";
    }

    /**
     * Clear cache for a specific page or all pages.
     */
    public static function clearPageCache(?string $page = null): void
    {
        if ($page) {
            Cache::forget(self::getCacheKey($page));
        } else {
            $pages = ['home', 'about', 'contact', 'footer', 'seo'];
            foreach ($pages as $p) {
                Cache::forget(self::getCacheKey($p));
            }
        }
    }

    protected static function booted(): void
    {
        static::saved(function (self $model) {
            self::clearPageCache($model->page);
        });

        static::deleted(function (self $model) {
            self::clearPageCache($model->page);
        });
    }

    /**
     * Get all content for a specific page as a nested array [section][key] => value.
     */
    public static function getPage(string $page): array
    {
        return Cache::rememberForever(self::getCacheKey($page), function () use ($page) {
            $records = self::with('media')->where('page', $page)->get();
            $data = [];

            foreach ($records as $item) {
                if ($item->type === 'image') {
                    $mediaUrl = $item->getFirstMediaUrl('image');
                    $data[$item->section][$item->key] = !empty($mediaUrl) ? $mediaUrl : $item->value;
                } else {
                    $data[$item->section][$item->key] = $item->value;
                }
            }

            return $data;
        });
    }

    /**
     * Get all content for a specific section on a page.
     */
    public static function getSection(string $page, string $section): array
    {
        $pageData = self::getPage($page);
        return $pageData[$section] ?? [];
    }

    /**
     * Retrieve a specific content value by page, section, and key.
     */
    public static function get(string $page, string $section, string $key, mixed $default = null): mixed
    {
        $pageData = self::getPage($page);
        return $pageData[$section][$key] ?? $default;
    }

    /**
     * Retrieve image URL for a specific image content item.
     */
    public static function getImageUrl(string $page, string $section, string $key, ?string $fallback = null): ?string
    {
        $val = self::get($page, $section, $key, $fallback);
        return !empty($val) ? $val : $fallback;
    }

    /**
     * Set or update a content record.
     */
    public static function set(string $page, string $section, string $key, mixed $value, string $type = 'text', ?string $label = null): self
    {
        $record = self::updateOrCreate(
            [
                'page' => $page,
                'section' => $section,
                'key' => $key,
            ],
            [
                'value' => $value,
                'type' => $type,
                'label' => $label,
            ]
        );

        self::clearPageCache($page);

        return $record;
    }

    /**
     * Get list of all distinct pages with metadata dynamically from the database ordered by earliest ID (insertion order).
     */
    public static function getAvailablePagesWithMeta(): array
    {
        $pages = self::query()
            ->select('page')
            ->selectRaw('MIN(id) as min_id')
            ->groupBy('page')
            ->orderBy('min_id', 'asc')
            ->pluck('page')
            ->toArray();

        if (empty($pages)) {
            $pages = ['home', 'about', 'contact', 'footer', 'seo'];
        }

        $result = [];
        foreach ($pages as $p) {
            $result[$p] = [
                'title' => ucwords(str_replace(['_', '-'], ' ', $p)) . ' Content',
                'badge' => ucwords(str_replace(['_', '-'], ' ', $p)),
                'icon' => 'ri-file-list-3-line',
                'sections_title' => ucwords(str_replace(['_', '-'], ' ', $p)) . ' Sections',
            ];
        }

        return $result;
    }

    /**
     * Get list of all distinct sections with metadata dynamically from the database for a page ordered by earliest ID.
     */
    public static function getPageSectionsWithMeta(string $page): array
    {
        $sections = self::query()
            ->where('page', $page)
            ->select('section')
            ->selectRaw('MIN(id) as min_id')
            ->groupBy('section')
            ->orderBy('min_id', 'asc')
            ->pluck('section')
            ->toArray();

        $result = [];
        foreach ($sections as $s) {
            $result[$s] = [
                'title' => ucwords(str_replace(['_', '-'], ' ', $s)),
                'icon' => 'ri-layout-masonry-line',
            ];
        }

        return $result;
    }

    /**
     * Accessor for Spatie media image url.
     */
    public function getImageUrlAttribute(): ?string
    {
        $url = $this->getFirstMediaUrl('image');
        if (!empty($url)) {
            return $url;
        }

        return !empty($this->value) ? asset($this->value) : null;
    }
}
