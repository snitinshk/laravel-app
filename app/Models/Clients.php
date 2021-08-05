<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Clients extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'contact_name',
        'email_address',
        'phone_number',
        'status'
    ];


}
