<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppointmentDocument extends Model
{
    use HasFactory;

    protected $fillable = [
        'appointment_id',
        'value',
        'user_id',
        'document_id'
    ];
}
