<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Theme extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'directory',
        'description',
        'preview_image',
        'author',
        'version',
        'is_active',
        'settings',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'settings' => 'array',
    ];

    public const CACHE_KEY_ACTIVE_THEME = 'active_website_theme_dir';
    public const CACHE_KEY_ACTIVE_ID = 'active_website_theme_id';

    protected static ?string $activeDirectoryRuntime = null;
    protected static ?self $activeModelRuntime = null;

    /**
     * Get the currently active theme directory slug.
     */
    public static function getActiveDirectory(): string
    {
        if (static::$activeDirectoryRuntime !== null) {
            return static::$activeDirectoryRuntime;
        }

        try {
            static::$activeDirectoryRuntime = Cache::remember(self::CACHE_KEY_ACTIVE_THEME, 86400, function () {
                try {
                    return self::where('is_active', true)->value('directory') ?? 'default';
                } catch (\Throwable $e) {
                    return 'default';
                }
            }) ?? 'default';
        } catch (\Throwable $e) {
            static::$activeDirectoryRuntime = 'default';
        }

        return static::$activeDirectoryRuntime;
    }

    /**
     * Get the currently active theme model.
     */
    public static function getActiveTheme(): ?self
    {
        if (static::$activeModelRuntime !== null) {
            return static::$activeModelRuntime;
        }

        try {
            $id = Cache::remember(self::CACHE_KEY_ACTIVE_ID, 86400, function () {
                try {
                    return self::where('is_active', true)->value('id');
                } catch (\Throwable $e) {
                    return null;
                }
            });

            if ($id) {
                $theme = self::find($id);
                if ($theme) {
                    static::$activeModelRuntime = $theme;
                    return $theme;
                }
            }

            static::$activeModelRuntime = self::where('is_active', true)->first() ?? self::first();
            return static::$activeModelRuntime;
        } catch (\Throwable $e) {
            return null;
        }
    }

    /**
     * Set a theme as active by ID or Slug.
     */
    public static function activateTheme(int|string $idOrSlug): bool
    {
        $theme = is_numeric($idOrSlug)
            ? self::find($idOrSlug)
            : self::where('slug', $idOrSlug)->first();

        if (!$theme) {
            return false;
        }

        // Deactivate all themes
        self::query()->update(['is_active' => false]);

        // Activate the selected theme
        $theme->update(['is_active' => true]);

        // Clear theme cache
        self::clearThemeCache();

        return true;
    }

    /**
     * Clear active theme cache.
     */
    public static function clearThemeCache(): void
    {
        static::$activeDirectoryRuntime = null;
        static::$activeModelRuntime = null;

        try {
            Cache::forget(self::CACHE_KEY_ACTIVE_THEME);
            Cache::forget(self::CACHE_KEY_ACTIVE_ID);
        } catch (\Throwable $e) {
            //
        }
    }

    /**
     * Get preview image url.
     */
    public function getPreviewImageUrlAttribute(): string
    {
        if (!empty($this->preview_image) && file_exists(public_path($this->preview_image))) {
            return asset($this->preview_image);
        }

        return asset('images/theme-placeholder.jpg');
    }
}
