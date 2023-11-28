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
    ];

    protected $fillable = [
        // 'start_time',
        // 'finish_time',
        'appointment_date',
        'yard_id',
        'purpose',
        'hauler_id',
        'creator_id',
        'truck_details',
        'driver_name',
        'contact_details',
        'file_number',
        'container_number',
        'status',
        'comments',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

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

    public function loading_bay_session(){
        return $this->hasOne(LoadingBay::class, 'appointment_id');
    }
}
