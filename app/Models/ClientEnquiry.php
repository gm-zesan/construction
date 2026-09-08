<?php

namespace App\Models;

use App\Enums\EnquiryStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;

class ClientEnquiry extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'company',
        'subject',
        'message',
        'service_id',
        'project_id',
        'status',
        'internal_notes',
        'submitted_at',
    ];

    protected function casts(): array
    {
        return [
            'status' => EnquiryStatus::class,
            'submitted_at' => 'datetime',
        ];
    }

    /**
     * Related service.
     */
    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class, 'service_id');
    }

    /**
     * Related project.
     */
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class, 'project_id');
    }

    /**
     * Scopes
     */
    public function scopeByStatus(Builder $query, EnquiryStatus|string $status): Builder
    {
        $statusValue = $status instanceof EnquiryStatus ? $status->value : $status;
        return $query->where('status', $statusValue);
    }

    public function scopeRecent(Builder $query): Builder
    {
        return $query->orderBy('submitted_at', 'desc')->orderBy('created_at', 'desc');
    }
}
