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
            $pages = ['home', 'about', 'team', 'team_detail', 'projects', 'project_detail', 'articles', 'article_detail', 'contact', 'footer', 'seo'];
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
            $pages = ['home', 'about', 'team', 'team_detail', 'projects', 'project_detail', 'articles', 'article_detail', 'contact', 'footer', 'seo'];
        }

        $defaultOrder = ['home', 'about', 'team', 'team_detail', 'projects', 'project_detail', 'articles', 'article_detail', 'contact', 'footer', 'seo'];
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
            'team' => 'ri-team-line',
            'team_detail' => 'ri-user-settings-line',
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
            'team' => 'Team Directory',
            'team_detail' => 'Team Member Detail',
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
            'team' => ['hero', 'roster', 'cta'],
            'team_detail' => ['hero', 'bio', 'cta', 'related'],
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
            'why_choose_us' => 'Why Choose Us',
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
     * Human-friendly group display name for repeating item collections in a section.
     */
    public static function getGroupDisplayName(string $groupType, string $section, string $page): string
    {
        $customTitles = [
            'timeline' => ['item' => 'Timeline Milestones'],
            'accreditations' => ['item' => 'Accreditations & Certifications'],
            'values' => ['val' => 'Core Values'],
            'features' => ['feature' => 'Feature Highlights'],
            'why_choose_us' => ['feature' => 'Distinct Capabilities'],
            'experience' => ['stat' => 'Performance Statistics'],
            'faq' => ['faq' => 'Frequently Asked Questions (FAQ)'],
            'highlights' => ['card' => 'Technical Highlight Cards'],
            'story' => ['checklist' => 'Capability Checkpoints'],
            'hero' => ['telemetry' => 'Telemetry Indicators'],
        ];

        if (isset($customTitles[$section][$groupType])) {
            return $customTitles[$section][$groupType];
        }

        return ucwords(str_replace('_', ' ', $groupType)) . ' Items';
    }

    /**
     * Human-friendly item display name for individual items in a group.
     */
    public static function getItemDisplayName(string $groupType, int $index, string $section): string
    {
        $customItemNames = [
            'timeline' => 'Timeline Milestone',
            'accreditations' => 'Accreditation Item',
            'values' => 'Value Item',
            'features' => 'Feature Item',
            'why_choose_us' => 'Feature Item',
            'experience' => 'Statistic Item',
            'faq' => 'FAQ Item',
            'highlights' => 'Highlight Card',
            'story' => 'Checklist Item',
            'hero' => 'Telemetry Item',
        ];

        $base = $customItemNames[$section] ?? ucwords(str_replace('_', ' ', $groupType)) . ' Item';
        return "{$base} {$index}";
    }

    /**
     * Categorize a collection of WebsiteContent records for a given section into standalone fields and repeating item groups.
     */
    public static function organizeSectionContent(iterable $records, string $section, string $page): array
    {
        $standalone = [];
        $rawGroups = [];
        $knownGroupPrefixes = ['item', 'val', 'feature', 'stat', 'faq', 'card', 'checklist', 'telemetry'];

        foreach ($records as $record) {
            $matched = false;
            if (preg_match('/^([a-zA-Z]+)_(\d+)(?:_(.*))?$/', $record->key, $matches)) {
                $prefix = $matches[1];
                $index = (int) $matches[2];
                $subKey = $matches[3] ?? '';

                if (in_array($prefix, $knownGroupPrefixes)) {
                    $groupId = "{$prefix}_{$index}";
                    $rawGroups[$prefix][$groupId][] = $record;
                    $matched = true;
                }
            }

            if (!$matched) {
                $standalone[$record->key] = $record;
            }
        }

        $formattedGroups = [];
        foreach ($rawGroups as $prefix => $itemsById) {
            $groupList = [];
            foreach ($itemsById as $groupId => $fieldRecords) {
                preg_match('/^([a-zA-Z]+)_(\d+)$/', $groupId, $m);
                $idx = isset($m[2]) ? (int) $m[2] : 1;
                $itemLabel = self::getItemDisplayName($prefix, $idx, $section);

                // Derive smart preview info from fields
                $badgePreview = null;
                $titlePreview = null;
                $descPreview = null;
                $tags = [];

                foreach ($fieldRecords as $f) {
                    $k = $f->key;
                    $val = $f->value ?? '';
                    if (empty($val))
                        continue;

                    if (str_ends_with($k, '_year') || str_ends_with($k, '_count') || str_ends_with($k, '_num') || str_ends_with($k, '_status')) {
                        $badgePreview = $badgePreview ?: $val;
                    } elseif (str_ends_with($k, '_title') || str_ends_with($k, '_q') || str_ends_with($k, '_label') || $k === 'checklist_' . $idx) {
                        $titlePreview = $titlePreview ?: $val;
                    } elseif (str_ends_with($k, '_desc') || str_ends_with($k, '_text') || str_ends_with($k, '_a') || str_ends_with($k, '_category')) {
                        $descPreview = $descPreview ?: $val;
                    } elseif (str_contains($k, '_tag_')) {
                        $tags[] = $val;
                    }
                }

                if (empty($titlePreview) && !empty($fieldRecords)) {
                    $titlePreview = $fieldRecords[0]->value ?? $fieldRecords[0]->label ?? $itemLabel;
                }

                $groupList[$groupId] = [
                    'group_id' => $groupId,
                    'group_type' => $prefix,
                    'item_index' => $idx,
                    'item_label' => $itemLabel,
                    'badge_preview' => $badgePreview,
                    'title_preview' => $titlePreview,
                    'desc_preview' => $descPreview,
                    'tags_preview' => $tags,
                    'records' => $fieldRecords,
                ];
            }

            $formattedGroups[$prefix] = [
                'group_type' => $prefix,
                'group_title' => self::getGroupDisplayName($prefix, $section, $page),
                'items' => $groupList,
            ];
        }

        return [
            'standalone' => $standalone,
            'groups' => $formattedGroups,
        ];
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
