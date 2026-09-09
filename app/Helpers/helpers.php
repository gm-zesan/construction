<?php

use App\Models\WebsiteContent;
use App\Models\WebsiteSetting;

if (!function_exists('get_setting')) {
    /**
     * Retrieve a website setting value by key with optional default fallback.
     */
    function get_setting(string $key, mixed $default = null): mixed
    {
        return WebsiteSetting::get($key, $default);
    }
}

if (!function_exists('get_content')) {
    /**
     * Retrieve a website content value by page, section, and key.
     */
    function get_content(string $page, string $section, string $key, mixed $default = null): mixed
    {
        return WebsiteContent::get($page, $section, $key, $default);
    }
}

if (!function_exists('get_content_section')) {
    /**
     * Retrieve all key-value content items for a specific page section.
     */
    function get_content_section(string $page, string $section): array
    {
        return WebsiteContent::getSection($page, $section);
    }
}

if (!function_exists('get_content_image')) {
    /**
     * Retrieve image URL for a website content item with optional fallback.
     */
    function get_content_image(string $page, string $section, string $key, ?string $fallback = null): ?string
    {
        return WebsiteContent::getImageUrl($page, $section, $key, $fallback);
    }
}
