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
        'started_at' => 'date:m/d/Y',
        'finished_at' => 'date:m/d/Y',
        'created_at' => 'date:m/d/Y',
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
        'status'
    ];

    public function appointment(){
        return $this->belongsTo(Appointment::class);
    }
}
