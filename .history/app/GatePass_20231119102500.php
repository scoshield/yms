<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GatePass extends Model
{
    use HasFactory;
    use SoftDeletes;

    public $table = 'appointments';

    protected $fillable = [
        'appointment_id',
        'ref',
        'print_request_count',
        'created_by',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function appointment(){
        return $this->belongsTo(Appointment::class);
    }
}
