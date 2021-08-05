<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Candidate extends Model
{
    use HasFactory;

    protected $table = 'candidate';
    public $timestamps = false;

    protected $fillable = [
        'query_id',
        'status',
        'scrape_time',
        'full_name',
        'personal_email',
        'corporate_email',
        'current_job_title',
        'current_employer',
        'current_employer_sales_link',
        'location',
        'sales_link',
        'profile_url',
        'top_skill_1',
        'top_skill_2',
        'top_skill_3',
        'current_employer_website',
        'current_employer_industry_desc',
        'current_employer_headcount',
        'current_employer_headquarters',
        'current_employer_founded_date',
        'current_employer_incorporation_type',
        'current_employer_specialities',
        'current_employer_overview',
    ];

}
