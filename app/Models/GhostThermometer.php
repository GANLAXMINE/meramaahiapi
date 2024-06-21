<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GhostThermometer extends Model
{
    protected $table = 'ghost_thermometers';
    protected $fillable = [
        'date',
        'rating',
        'answer',
        'user_id',
        'receiver_id',
        'point'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }
}
