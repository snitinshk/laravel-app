<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Leads extends Model
{
    use HasFactory;

    protected $table = 'candidate';

    protected $fillable = [
        'full_name',
        'personal_email',
        'corporate_email',
        'current_job_title',
        'current_employer',
        'location',
        'sales_link',
        'top_skill_1',
        'top_skill_2',
        'top_skill_3'
    ];

}
