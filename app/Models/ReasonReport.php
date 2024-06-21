<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class ReasonReport extends Model
{
    protected $table = 'reason_report';
    protected $fillable = [
        'report_by',
        'user_id',
        'reason_question_id',
        'reason_subquestion_id',
        'message',
    ];

    // Define a belongsTo relationship with the User model
    public function user()
    {
        // The foreign key 'user_id' in the current model corresponds to the 'id' column in the User model
        return $this->belongsTo(User::class, 'user_id');
    }
    // Define a belongsTo relationship with the User model
    public function reportBy()
    {
        // The foreign key 'report_by' in the current model corresponds to the 'id' column in the User model
        return $this->belongsTo(User::class, 'report_by');
    }
    // Define a belongsTo relationship with the ReasonQuestion model
    public function reasonQuestion()
    {
        // The foreign key 'reason_question_id' in the current model corresponds to the 'id' column in the ReasonQuestion model
        return $this->belongsTo(ReasonQuestion::class, 'reason_question_id');
    }
    // Define a belongsTo relationship with the ReasonSubquestion model
    public function reasonSubquestion()
    {
        // The foreign key 'reason_subquestion_id' in the current model corresponds to the 'id' column in the ReasonSubquestion model
        return $this->belongsTo(ReasonSubquestion::class, 'reason_subquestion_id');
    }
}
