<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Eip extends Model
{
    use HasFactory;

    protected $fillable = [
        'empno', 'name', 'department', 'ext', 'date', 'process', 'others', 'eiptype', 'eipcategory', 'location', 'specificlocation', 'current', 'currentattachment', 'webpath', 'filesize', 'proposal', 'proposalattachment', 'webpath1', 'filesize1', 'createtime',
    ];

    protected $casts = [

    ];
}
