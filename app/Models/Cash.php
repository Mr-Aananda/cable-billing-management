<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cash extends Model
{
    use HasFactory,SoftDeletes;
    // fillable
    protected $fillable = [
        'cash_name',
        'balance',
        'note'
    ];
}
