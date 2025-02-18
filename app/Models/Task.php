<?php

namespace App\Models;

use App\Models\Org\JobRole;
use App\Models\Org\Staff;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'type', 'description', 'status',
    ];

    protected $casts = [

    ];

    public function assign_to(): BelongsTo
    {
        return $this->belongsTo(JobRole::class, 'assign_to_id');
    }

    public function assignee(): BelongsTo
    {
        return $this->belongsTo(Staff::class, 'assignee_id');
    }
}
