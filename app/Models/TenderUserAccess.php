<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TenderUserAccess extends Model
{
    protected $table = 'tender_user_access';

    protected $fillable = [
        'user_id',
        'tender_id',
        'is_download'
    ];
}
