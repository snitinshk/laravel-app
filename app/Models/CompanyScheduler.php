<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyScheduler extends Model
{
    use HasFactory;
    protected $table = 'company_schedulers';

    protected $fillable = [
        'user_id',
        'tracking_id',
        'name',
        'status',
    ];

}
