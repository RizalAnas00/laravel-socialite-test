<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shirt extends Model
{
    /** @use HasFactory<\Database\Factories\ShirtFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'size',
        'code',
        'stock',
        'price',
        'description'
    ];
}
