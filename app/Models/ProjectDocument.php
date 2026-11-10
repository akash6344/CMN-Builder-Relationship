<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProjectDocument extends Model
{
    protected $connection = 'housing';

    protected $table = 'project_documents';

    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'expires_at' => 'date',
            'file_size' => 'integer',
            'metadata' => 'array',
        ];
    }

    public function projectDetail(): BelongsTo
    {
        return $this->belongsTo(ProjectDetail::class);
    }

    public function displayStatus(): string
    {
        return match ($this->status) {
            'verified' => 'Verified',
            'rejected' => 'Rejected',
            default => 'Pending',
        };
    }

    public function statusBadgeClass(): string
    {
        return match ($this->status) {
            'verified' => 'badge-live',
            'rejected' => 'badge-rejected',
            default => 'badge-pending',
        };
    }

    public function displayCategory(): string
    {
        return match ($this->category) {
            'rera' => 'RERA',
            'brochure' => 'Brochure',
            'price_list' => 'Price List',
            'approval' => 'Approval',
            'agreement' => 'Agreement',
            default => ucfirst(str_replace('_', ' ', (string) $this->category)),
        };
    }

    public function verify(): static
    {
        $this->forceFill(['status' => 'verified'])->save();

        return $this;
    }

    public function reject(): static
    {
        $this->forceFill(['status' => 'rejected'])->save();

        return $this;
    }
}
