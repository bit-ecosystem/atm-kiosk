<?php

namespace App\Models\Mart;

use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    protected $table = 'mart_assets';

    protected $fillable = [
        'asset_type_id',
        'description',
        'quantity_available',
    ];

    public function assetType()
    {
        return $this->belongsTo(AssetType::class);
    }
}
