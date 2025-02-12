<?php

namespace App\Models;

use App\Models\Org\JobPosition;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Department extends Model
{
    use HasFactory;

    protected $fillable = [
        'department', 'name', 'description',
    ];

    protected $casts = [

    ];

    public function division(): BelongsTo
    {
        return $this->belongsTo(Division::class);
    }

    public function jobPositions(): HasMany
    {
        return $this->hasMany(JobPosition::class);
    }
}
