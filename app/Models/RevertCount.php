<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RevertCount extends Model
{
    protected $table = 'revert_count';
    protected $fillable = [
        'revert_by',
        'revert_count',
        'revert_date'
    ];
}
