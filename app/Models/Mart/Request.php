<?php

namespace App\Models\Mart;

use Illuminate\Database\Eloquent\Model;

class Request extends Model
{
    protected $table = 'mart_requests';

    protected $fillable = [
        'org_staff_id',
        'asset_id',
        'request_type',
        'request_date',
        'status',
        'approval_layer_1_status',
        'approval_layer_2_status',
        'approval_layer_3_status',
        'final_status',
    ];

    public function orgStaff()
    {
        return $this->belongsTo(\App\Models\Org\Staff::class);
    }

    public function asset()
    {
        return $this->belongsTo(Asset::class);
    }
}
