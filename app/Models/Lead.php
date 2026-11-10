<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Lead extends Model
{
    protected $connection = 'housing';

    protected $table = 'leads';

    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'metadata' => 'array',
            'last_activity_at' => 'datetime',
        ];
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(ProjectDetail::class, 'project_id');
    }

    public function statusLabel(): string
    {
        return match ($this->status) {
            'new' => 'New',
            'contacted' => 'Contacted',
            'site_visit' => 'Site Visit',
            'negotiating' => 'Negotiating',
            'closed' => 'Closed',
            'lost' => 'Lost',
            default => Str::title(str_replace('_', ' ', (string) $this->status)),
        };
    }

    public function statusBadgeClass(): string
    {
        return match ($this->status) {
            'new' => 'badge-review',
            'contacted' => 'badge-pending',
            'site_visit' => 'badge-plan-pro',
            'negotiating' => 'badge-plan-premium',
            'closed' => 'badge-live',
            'lost' => 'badge-muted',
            default => 'badge-draft',
        };
    }

    public function sourceLabel(): string
    {
        return match ($this->source) {
            'favorite' => 'Favorite',
            'enquiry' => 'Enquiry',
            'view' => 'Property View',
            'website' => 'Website',
            'facebook_ad' => 'Facebook Ad',
            'google_ad' => 'Google Ad',
            'instagram' => 'Instagram',
            'referral' => 'Referral',
            'manual' => 'Manual',
            default => Str::title(str_replace('_', ' ', (string) $this->source)),
        };
    }

    public function initials(): string
    {
        $parts = preg_split('/\s+/', trim((string) $this->name)) ?: [];
        $first = Str::substr($parts[0] ?? 'L', 0, 1);
        $second = Str::substr($parts[1] ?? ($parts[0] ?? 'D'), 0, 1);

        return Str::upper($first.$second);
    }
}
