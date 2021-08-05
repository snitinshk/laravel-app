<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SearchScheduler extends Model
{
    use HasFactory;
    protected $table = 'search_schedulers';

    protected $fillable = [
        'user_id',
        'tracking_id',
        'type',
        'name',
        'url',
        'status',
        'scrape_status',
        'snov_status'
    ];

}
