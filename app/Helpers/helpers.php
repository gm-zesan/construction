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

if (!function_exists('get_content_html')) {
    /**
     * Retrieve a website content value as safely sanitized HTML for rich text fields.
     */
    function get_content_html(string $page, string $section, string $key, mixed $default = null): string
    {
        $raw = WebsiteContent::get($page, $section, $key, $default);
        return clean_html($raw);
    }
}

if (!function_exists('clean_html')) {
    /**
     * Safely sanitize HTML string for frontend rendering.
     * Preserves safe formatting tags (span, br, strong, em, p, a, etc.) and styling classes
     * while stripping dangerous scripts, iframes, and inline event handlers.
     */
    function clean_html(mixed $content): string
    {
        if (empty($content)) {
            return '';
        }

        $html = (string) $content;

        // Strip dangerous tags completely along with their inner content
        $html = preg_replace('/<(script|style|iframe|object|embed|applet|form|input|button)[\s>][\s\S]*?<\/\1>/i', '', $html);
        $html = preg_replace('/<(script|style|iframe|object|embed|applet|meta|link|form|input|button)[^>]*?>/i', '', $html);

        // Strip inline on* javascript event handlers (e.g. onclick, onerror, onload, onmouseover)
        $html = preg_replace('/\s*on[a-zA-Z]+\s*=\s*("[^"]*"|\'[^\']*\'|[^\s>]+)/i', '', $html);

        // Strip javascript: and vbscript: URIs
        $html = preg_replace('/(?:\bhref|\bsrc)\s*=\s*("javascript:[^"]*"|\'javascript:[^\']*\'|javascript:[^\s>]+)/i', '', $html);
        $html = preg_replace('/(?:\bhref|\bsrc)\s*=\s*("vbscript:[^"]*"|\'vbscript:[^\']*\'|vbscript:[^\s>]+)/i', '', $html);

        return $html;
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
