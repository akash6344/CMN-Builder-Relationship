<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UnitConfiguration extends Model
{
    protected $connection = 'housing';

    protected $table = 'unit_configurations';

    protected $guarded = [];

    public function project(): BelongsTo
    {
        return $this->belongsTo(ProjectDetail::class, 'project_detail_id');
    }
}
