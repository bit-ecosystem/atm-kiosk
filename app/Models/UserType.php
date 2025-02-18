<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Permission\Traits\HasRoles;
class UserType extends Model
{
    use HasFactory, HasRoles;

    protected $fillable = [
        'type_name', 'description', 'tag', 'home',
    ];

    protected $casts = [

    ];

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }
}
