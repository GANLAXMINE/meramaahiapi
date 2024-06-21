<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MatchReport extends Model
{
    protected $table = 'match_report';
    protected $fillable = [
        'view_report_user',
        'view_by'
     ];
}
