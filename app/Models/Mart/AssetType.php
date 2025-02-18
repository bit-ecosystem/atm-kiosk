<?php

namespace App\Models\Mart;

use Illuminate\Database\Eloquent\Model;

class AssetType extends Model
{
    protected $table = 'mart_asset_types';

    protected $fillable = [
        'asset_type_name',
    ];

    public function assets()
    {
        return $this->hasMany(Asset::class);
    }
}
