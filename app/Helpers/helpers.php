<?php

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
