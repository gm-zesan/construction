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
     * Retrieve a website content value by page, section, and key for active or specified theme.
     */
    function get_content(string $page, string $section, string $key, mixed $default = null, ?string $theme = null): mixed
    {
        return WebsiteContent::get($page, $section, $key, $default, $theme);
    }
}

if (!function_exists('get_content_html')) {
    /**
     * Retrieve a website content value as safely sanitized HTML for rich text fields.
     */
    function get_content_html(string $page, string $section, string $key, mixed $default = null, ?string $theme = null): string
    {
        $raw = WebsiteContent::get($page, $section, $key, $default, $theme);
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
    function get_content_section(string $page, string $section, ?string $theme = null): array
    {
        return WebsiteContent::getSection($page, $section, $theme);
    }
}

if (!function_exists('get_content_image')) {
    /**
     * Retrieve image URL for a website content item with optional fallback.
     */
    function get_content_image(string $page, string $section, string $key, ?string $fallback = null, ?string $theme = null): ?string
    {
        return WebsiteContent::getImageUrl($page, $section, $key, $fallback, $theme);
    }
}

if (!function_exists('get_active_theme')) {
    /**
     * Get active theme directory name.
     */
    function get_active_theme(): string
    {
        try {
            return \App\Models\Theme::getActiveDirectory();
        } catch (\Throwable $e) {
            return 'default';
        }
    }
}

if (!function_exists('get_active_theme_model')) {
    /**
     * Get active theme model.
     */
    function get_active_theme_model(): ?\App\Models\Theme
    {
        try {
            return \App\Models\Theme::getActiveTheme();
        } catch (\Throwable $e) {
            return null;
        }
    }
}

if (!function_exists('theme_view')) {
    /**
     * Render a view from the active theme. If the view is unavailable in the active theme directory,
     * abort with a 404 response without falling back to the default theme.
     */
    function theme_view(string $view, array $data = [], array $mergeData = []): \Illuminate\View\View
    {
        $activeTheme = get_active_theme();

        // Check if view exists strictly in the active theme directory: resources/views/themes/{activeTheme}/{view}
        if (view()->exists("themes.{$activeTheme}.{$view}")) {
            return view("themes.{$activeTheme}.{$view}", $data, $mergeData);
        }

        // Active theme page/view is unavailable on directory - abort 404
        abort(404, '404 currently active theme is not available on you directory.');
    }
}

if (!function_exists('theme_asset')) {
    /**
     * Generate an asset path for the active theme.
     */
    function theme_asset(string $path): string
    {
        $activeTheme = get_active_theme();
        $themeAsset = "themes/{$activeTheme}/" . ltrim($path, '/');

        if (file_exists(public_path($themeAsset))) {
            return asset($themeAsset);
        }

        return asset($path);
    }
}

