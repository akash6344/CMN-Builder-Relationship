<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProjectDetail extends Model
{
    protected $connection = 'housing';

    protected $table = 'project_details';

    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'smart_bargain_enabled' => 'boolean',
            'possession_date' => 'date',
            'amenities' => 'array',
            'highlights' => 'array',
            'media_preferences' => 'array',
            'towers' => 'integer',
            'total_units' => 'integer',
        ];
    }

    public function unitConfigurations(): HasMany
    {
        return $this->hasMany(UnitConfiguration::class);
    }

    public function documents(): HasMany
    {
        return $this->hasMany(ProjectDocument::class);
    }

    public function isPendingReview(): bool
    {
        return $this->status === 'under_review';
    }

    public function displayStatus(): string
    {
        return match ($this->status) {
            'published' => 'Live',
            'under_review' => 'Pending Approval',
            'rejected' => 'Rejected',
            'archived' => 'Archived',
            'draft' => 'Under Review',
            default => ucfirst((string) $this->status),
        };
    }

    public function statusBadgeClass(): string
    {
        return match ($this->status) {
            'published' => 'badge-live',
            'under_review' => 'badge-pending',
            'rejected' => 'badge-rejected',
            'draft' => 'badge-review',
            'archived' => 'badge-muted',
            default => 'badge-muted',
        };
    }

    /**
     * @return array{properties:int,leads:int,views:int,offers:int,revenue:string}
     */
    public function dashboardMetrics(): array
    {
        $seed = max(1, (int) $this->id);
        $properties = (int) ($this->unit_configurations_count ?: $this->total_units ?: (($seed % 8) + 1));
        $leads = ($seed * 37) % 1400 + 40;
        $views = $leads * (($seed % 5) + 4);
        $offers = max(0, (int) floor($leads / (($seed % 7) + 6)));

        if ($this->status === 'rejected' || $this->status === 'draft') {
            $revenue = '—';
        } else {
            $lakhs = (($seed * 13) % 90) + 8;
            $revenue = $lakhs >= 100
                ? '₹'.number_format($lakhs / 100, 2).' Cr'
                : '₹'.$lakhs.' L';
        }

        return [
            'properties' => $properties,
            'leads' => $leads,
            'views' => $views,
            'offers' => $offers,
            'revenue' => $revenue,
        ];
    }

    public function approve(): static
    {
        $this->forceFill([
            'status' => 'published',
            'rejection_reason' => null,
        ])->save();

        return $this;
    }

    public function reject(string $reason): static
    {
        $this->forceFill([
            'status' => 'rejected',
            'rejection_reason' => $reason,
        ])->save();

        return $this;
    }
}
