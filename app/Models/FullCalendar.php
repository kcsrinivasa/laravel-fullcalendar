<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FullCalendar extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'start', 'end','colorCode'
    ];
}
