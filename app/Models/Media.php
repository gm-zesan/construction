<?php

namespace App\Models;

use Spatie\MediaLibrary\MediaCollections\Models\Media as BaseMedia;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Media extends BaseMedia
{
    /**
     * Get the uploader user from custom properties if present.
     */
    public function uploader(): BelongsTo
    {
        return $this->belongsTo(User::class, 'custom_properties->uploaded_by');
    }

    /**
     * Check if the media is an image.
     */
    public function isImage(): bool
    {
        return str_starts_with($this->mime_type ?? '', 'image/');
    }

    /**
     * Human-readable file size accessor.
     */
    public function getReadableSizeAttribute(): string
    {
        $bytes = $this->size;
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];

        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }

        return round($bytes, 2) . ' ' . $units[$i];
    }

    /**
     * Custom property accessors for title, alt text, and caption.
     */
    public function getTitleAttribute(): ?string
    {
        return $this->getCustomProperty('title', $this->name);
    }

    public function getAltTextAttribute(): ?string
    {
        return $this->getCustomProperty('alt_text', $this->name);
    }

    public function getCaptionAttribute(): ?string
    {
        return $this->getCustomProperty('caption');
    }
}
