<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Yard extends Model
{
    use HasFactory;
    public $table = 'yards';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'yard_name',
        'phone',
        'email',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
}
