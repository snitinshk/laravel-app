<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plans extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'lead_credits',
        'email_accounts',
        'frequency',
        'price',
        'stripe_id',
        'status'
    ];

}
