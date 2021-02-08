<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Leads extends Model
{
    use HasFactory;
    protected $fillable = [
        'Fname',
        'Lname',
        'Email',
        'Mobile',
        'Email',
        'City',
        'Status'
    ];

}
