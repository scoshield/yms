<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LoadingBay extends Model
{
    use HasFactory, SoftDeletes;
    public $table = 'loading_bay';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
        'started_at', 
        'finished_at'
    ];

    protected $casts = [
        'started_at' => 'date:d/m/y  H:i A',
        'finished_at' => 'date:d/m/y  H:i A',
        'created_at' => 'date:d/m/y  H:i A',
    ];

    protected $fillable = [
        'appointment_id',
        'ref',
        'type',
        'created_at',
        'updated_at',
        'deleted_at',
        'started_at',
        'finished_at',
        'status',
        'started_by',
        'finished_by',
        'start_image_url',
        'finish_image_url'
    ];

    public function appointment(){
        return $this->belongsTo(Appointment::class);
    }

    public function starter()
    {
        return $this->belongsTo(User::class, 'started_by');
    }

    public function finisher()
    {
        return $this->belongsTo(User::class, 'finished_by');
    }
}
