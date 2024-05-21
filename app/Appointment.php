<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Appointment extends Model
{
    use SoftDeletes, HasFactory;

    public $table = 'appointments';

    protected $dates = [
        'appointment_date',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $casts = [
        'appointment_date' => 'date:d/m/y  H:i A',
        'created_at' => 'date:d/m/y  H:i A',
        'security_approved_at' => 'date:d/m/y  H:i A',
        'hod_approved_at' => 'date:d/m/y  H:i A',
    ];

    protected $guarded = [];

    public function yard()
    {
        return $this->belongsTo(Yard::class, 'yard_id');
    }

    public function hauler()
    {
        return $this->belongsTo(Hauler::class, 'hauler_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    protected function serializeDate(\DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function services()
    {
        return $this->belongsToMany(Service::class);
    }

    public function loading_bay_session()
    {
        return $this->hasOne(LoadingBay::class, 'appointment_id');
    }

    public function gate_pass()
    {
        return $this->hasOne(GatePass::class, 'appointment_id');
    }

    public function hod_approver()
    {
        return $this->belongsTo(User::class, 'hod_approved_by');
    }

    public function security_approver()
    {
        return $this->belongsTo(User::class, 'security_approved_by');
    }
}
