<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = [
        'name',
        'description',
        'price',
        'start_date',
        'end_date',
        'status',
    ];
}
