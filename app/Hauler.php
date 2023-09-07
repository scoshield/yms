<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hauler extends Model
{
    use HasFactory;
    public $table = 'haulers';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'name',
        'phone',
        'email',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
}
