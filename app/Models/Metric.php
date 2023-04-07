<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Metric extends Model
{
    use HasFactory;

    protected $fillable = [
        'counter_id',

        'top', 'left', 'width', 'height',

        'page', 'date',
    ];

    protected $casts = [
        'date' => 'datetime',
    ];
}
