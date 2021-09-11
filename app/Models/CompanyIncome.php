<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyIncome extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'symbol',
        'date',
        'revenue',
        'eps',
        'link',

    ];
}
