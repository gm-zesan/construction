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
     * Get list of all distinct pages with metadata dynamically from the database ordered by page sequence.
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
            $pages = ['home', 'about', 'projects', 'project_detail', 'articles', 'article_detail', 'contact', 'footer', 'seo'];
        }

        $defaultOrder = ['home', 'about', 'projects', 'project_detail', 'articles', 'article_detail', 'contact', 'footer', 'seo'];
        usort($pages, function ($a, $b) use ($defaultOrder) {
            $posA = array_search($a, $defaultOrder);
            $posB = array_search($b, $defaultOrder);
            $posA = $posA === false ? 999 : $posA;
            $posB = $posB === false ? 999 : $posB;
            return $posA <=> $posB;
        });

        $pageIcons = [
            'home' => 'ri-home-4-line',
            'about' => 'ri-building-line',
            'projects' => 'ri-community-line',
            'project_detail' => 'ri-layout-grid-line',
            'articles' => 'ri-newspaper-line',
            'article_detail' => 'ri-article-line',
            'contact' => 'ri-customer-service-2-line',
            'footer' => 'ri-layout-bottom-line',
            'seo' => 'ri-search-eye-line',
        ];

        $pageBadges = [
            'home' => 'Home',
            'about' => 'About Us',
            'projects' => 'Projects',
            'project_detail' => 'Project Detail',
            'articles' => 'Articles & News',
            'article_detail' => 'Article Detail',
            'contact' => 'Contact',
            'footer' => 'Footer & Global',
            'seo' => 'SEO & Meta',
        ];

        $result = [];
        foreach ($pages as $p) {
            $badge = $pageBadges[$p] ?? ucwords(str_replace(['_', '-'], ' ', $p));
            $result[$p] = [
                'title' => $badge . ' Content',
                'badge' => $badge,
                'icon' => $pageIcons[$p] ?? 'ri-file-list-3-line',
                'sections_title' => $badge . ' Sections',
            ];
        }

        return $result;
    }

    /**
     * Get list of all distinct sections with metadata dynamically from the database for a page ordered by logical flow.
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

        $defaultSectionOrders = [
            'home' => ['hero', 'about_story', 'features', 'experience', 'services', 'projects', 'testimonials', 'why_choose_us', 'news'],
            'about' => ['hero', 'story', 'chairman_speech', 'values', 'timeline', 'leadership', 'accreditations'],
            'projects' => ['hero', 'showcase', 'spotlight', 'index_matrix'],
            'project_detail' => ['narrative', 'highlights', 'sidebar', 'gallery', 'milestones', 'cta', 'related'],
            'articles' => ['hero', 'featured', 'archive', 'sidebar'],
            'article_detail' => ['hero', 'plate', 'author', 'sidebar', 'related'],
            'contact' => ['hero', 'info', 'form', 'map', 'faq'],
            'footer' => ['cta', 'brand_bio'],
            'seo' => ['meta'],
        ];

        if (isset($defaultSectionOrders[$page])) {
            $preferred = $defaultSectionOrders[$page];
            usort($sections, function ($a, $b) use ($preferred) {
                $posA = array_search($a, $preferred);
                $posB = array_search($b, $preferred);
                $posA = $posA === false ? 999 : $posA;
                $posB = $posB === false ? 999 : $posB;
                return $posA <=> $posB;
            });
        }

        $sectionIcons = [
            'hero' => 'ri-artboard-2-line',
            'about_story' => 'ri-book-open-line',
            'features' => 'ri-checkbox-circle-line',
            'experience' => 'ri-trophy-line',
            'services' => 'ri-tools-line',
            'projects' => 'ri-building-4-line',
            'testimonials' => 'ri-chat-smile-2-line',
            'why_choose_us' => 'ri-star-line',
            'news' => 'ri-newspaper-line',
            'story' => 'ri-history-line',
            'chairman_speech' => 'ri-mic-line',
            'values' => 'ri-shield-star-line',
            'timeline' => 'ri-time-line',
            'leadership' => 'ri-team-line',
            'accreditations' => 'ri-award-line',
            'cta' => 'ri-phone-camera-line',
            'showcase' => 'ri-gallery-line',
            'spotlight' => 'ri-focus-3-line',
            'index_matrix' => 'ri-grid-fill',
            'standards' => 'ri-list-check-2',
            'narrative' => 'ri-article-line',
            'highlights' => 'ri-flashlight-line',
            'sidebar' => 'ri-side-bar-line',
            'gallery' => 'ri-image-line',
            'milestones' => 'ri-flag-line',
            'related' => 'ri-links-line',
            'featured' => 'ri-pushpin-line',
            'archive' => 'ri-archive-line',
            'plate' => 'ri-information-line',
            'author' => 'ri-user-star-line',
            'info' => 'ri-contacts-line',
            'form' => 'ri-mail-send-line',
            'map' => 'ri-map-pin-2-line',
            'faq' => 'ri-questionnaire-line',
            'brand_bio' => 'ri-file-info-line',
            'newsletter' => 'ri-mail-line',
            'copyright' => 'ri-copyright-line',
            'meta' => 'ri-global-line',
            'og' => 'ri-share-line',
        ];

        $sectionLabels = [
            'about_story' => 'About & Company Story',
            'why_choose_us' => 'Why Choose Us / Excellence Matrix',
            'chairman_speech' => 'Leadership Speech & Vision',
            'index_matrix' => 'Portfolio Matrix & Filters',
            'brand_bio' => 'Brand Bio & Company Info',
            'faq' => 'Frequently Asked Questions (FAQ)',
            'og' => 'OpenGraph Social Sharing',
        ];

        $result = [];
        foreach ($sections as $s) {
            $title = $sectionLabels[$s] ?? ucwords(str_replace(['_', '-'], ' ', $s));
            $result[$s] = [
                'title' => $title,
                'icon' => $sectionIcons[$s] ?? 'ri-layout-masonry-line',
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
