<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Domains extends Model
{
    use HasFactory;

    protected $table = 'companies';

    protected $fillable = [
        'company_scheduler_id',
        'name',
        'domain',
        'email_count',
    ];

}
