<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Scheduler extends Model
{
    use HasFactory;

    protected $table = 'scheduler';
    public $timestamps = false;

    protected $fillable = [
        'tracking_id',
        'snov'
    ];

}
