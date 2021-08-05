<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyEmail extends Model
{
    use HasFactory;
    protected $table = 'company_emails';

    protected $fillable = [
        'company_id',
        'email',
        'type',
        'status',
        'first_name',
        'last_name',
        'position',
        'source',
    ];

}
