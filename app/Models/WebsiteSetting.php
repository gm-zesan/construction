<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class WebsiteSetting extends Model
{
    use HasFactory;

    protected $table = 'website_settings';

    protected $fillable = [
        'key',
        'value',
        'type',
        'group',
    ];

    public const CACHE_KEY = 'website_settings_all';

    protected static function booted(): void
    {
        static::saved(function () {
            Cache::forget(self::CACHE_KEY);
        });

        static::deleted(function () {
            Cache::forget(self::CACHE_KEY);
        });
    }

    /**
     * Get a setting value by key.
     */
    public static function get(string $key, mixed $default = null): mixed
    {
        $settings = Cache::rememberForever(self::CACHE_KEY, function () {
            return self::pluck('value', 'key')->toArray();
        });

        return $settings[$key] ?? $default;
    }

    /**
     * Set or update a setting value.
     */
    public static function set(string $key, mixed $value, string $type = 'text', string $group = 'general'): self
    {
        $setting = self::updateOrCreate(
            ['key' => $key],
            [
                'value' => $value,
                'type' => $type,
                'group' => $group,
            ]
        );

        Cache::forget(self::CACHE_KEY);

        return $setting;
    }

    /**
     * Human-readable label accessor for key.
     */
    public function getLabelAttribute(): string
    {
        $customLabels = [
            'company_name' => 'Company Name',
            'company_tagline' => 'Company Tagline / Slogan',
            'site_logo' => 'Website Logo',
            'site_favicon' => 'Website Favicon',
            'primary_phone' => 'Primary Phone',
            'primary_email' => 'Primary Email',
            'whatsapp_number' => 'WhatsApp Number',
            'office_address' => 'Office Physical Address',
            'google_maps_url' => 'Google Maps Link / Embed URL',
            'facebook_url' => 'Facebook Profile URL',
            'instagram_url' => 'Instagram Profile URL',
            'linkedin_url' => 'LinkedIn Profile URL',
            'youtube_url' => 'YouTube Channel URL',
            'office_hours' => 'Office Working Hours',
            'copyright_text' => 'Footer Copyright Notice',
        ];

        return $customLabels[$this->key] ?? ucwords(str_replace('_', ' ', $this->key));
    }

    /**
     * Bootstrap column width class for responsive grid.
     */
    public function getColClassAttribute(): string
    {
        if (in_array($this->type, ['textarea']) || in_array($this->key, ['office_address', 'google_maps_url'])) {
            return 'col-12';
        }

        if (in_array($this->key, ['primary_phone', 'primary_email', 'whatsapp_number'])) {
            return 'col-md-4 col-12';
        }

        return 'col-md-6 col-12';
    }

    /**
     * Placeholder text helper.
     */
    public function getPlaceholderAttribute(): string
    {
        $placeholders = [
            'company_name' => 'Enter company name',
            'company_tagline' => 'e.g. Architectural Precision & Engineering Excellence',
            'primary_phone' => '+1 (800) 555-0199',
            'primary_email' => 'info@example.com',
            'whatsapp_number' => '+1 (800) 555-0199',
            'office_address' => 'Street Address, City, State, ZIP',
            'google_maps_url' => 'https://maps.google.com/...',
            'facebook_url' => 'https://facebook.com/yourbrand',
            'instagram_url' => 'https://instagram.com/yourbrand',
            'linkedin_url' => 'https://linkedin.com/company/yourbrand',
            'youtube_url' => 'https://youtube.com/@yourbrand',
            'office_hours' => 'Mon - Fri: 08:00 AM - 06:00 PM',
            'copyright_text' => '© 2026 COMPANY NAME. All Rights Reserved.',
        ];

        return $placeholders[$this->key] ?? '';
    }

    /**
     * Group metadata definitions (label, icon).
     */
    public static function getGroupMeta(): array
    {
        return [
            'general' => [
                'title' => 'General Settings',
                'icon' => 'ri-building-4-line text-primary',
                'nav_icon' => 'ri-building-4-line',
            ],
            'contact' => [
                'title' => 'Contact Information',
                'icon' => 'ri-contacts-line text-success',
                'nav_icon' => 'ri-contacts-book-2-line',
            ],
            'social' => [
                'title' => 'Social Media Profiles',
                'icon' => 'ri-share-line text-info',
                'nav_icon' => 'ri-share-forward-line',
            ],
            'business' => [
                'title' => 'Business Information',
                'icon' => 'ri-briefcase-4-line text-warning',
                'nav_icon' => 'ri-briefcase-4-line',
            ],
        ];
    }

    /**
     * Get all settings in a specific group as key => value array.
     */
    public static function getGroup(string $group): array
    {
        return self::where('group', $group)->pluck('value', 'key')->toArray();
    }

    /**
     * Get all settings grouped by group name.
     */
    public static function getAllGrouped(): array
    {
        return self::all()->groupBy('group')->map(function ($items) {
            return $items->pluck('value', 'key')->toArray();
        })->toArray();
    }
}
