<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Builder extends Model
{
    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'projects_count' => 'integer',
            'revenue_lakhs' => 'float',
            'trust_score' => 'integer',
            'rating' => 'float',
            'support_tickets' => 'integer',
            'featured' => 'boolean',
        ];
    }

    public function initials(): string
    {
        $parts = preg_split('/\s+/', trim($this->owner_name)) ?: [];
        $first = strtoupper(substr($parts[0] ?? 'B', 0, 1));
        $second = strtoupper(substr($parts[1] ?? ($parts[0] ?? 'R'), 0, 1));

        return $first.$second;
    }

    public function subscriptionBadgeClass(): string
    {
        return match ($this->subscription) {
            'Developer Premium' => 'badge-plan-premium',
            'Professional' => 'badge-plan-pro',
            'Enterprise' => 'badge-plan-enterprise',
            default => 'badge-plan-starter',
        };
    }

    public function statusBadgeClass(): string
    {
        return match ($this->status) {
            'Active' => 'badge-live',
            'Pending' => 'badge-pending',
            'Suspended' => 'badge-rejected',
            default => 'badge-muted',
        };
    }

    public function formattedRevenue(): string
    {
        $lakhs = (float) $this->revenue_lakhs;
        if ($lakhs >= 100) {
            return '₹'.number_format($lakhs / 100, 2).' Cr';
        }

        return '₹'.number_format($lakhs, 1).' L';
    }
}
