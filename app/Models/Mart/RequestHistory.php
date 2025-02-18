<?php

namespace App\Models\Mart;

use Illuminate\Database\Eloquent\Model;

class RequestHistory extends Model
{
    protected $table = 'mart_request_history';

    protected $fillable = [
        'request_id',
        'action',
        'action_date',
        'performed_by',
    ];

    public function request()
    {
        return $this->belongsTo(Request::class);
    }

    public function performedBy()
    {
        return $this->belongsTo(\App\Models\Org\Staff::class, 'performed_by');
    }
}
