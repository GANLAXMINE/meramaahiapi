<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserDetail extends Model
{
    protected $table = 'user_details';

    protected $fillable = [
        'religion',
        'community',
        'relationship_status',
        'country',
        'state',
        'city',
        'education_course',
        'education_college_name',
        'education_college_place',
        'working',
        'job_role',
        'company_name',
        'workplace',
        'passions',
        'profile_for',
        'about_me',
        'user_id',
    ];
}
