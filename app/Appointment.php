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
        'start_time',
        'created_at',
        'updated_at',
        'deleted_at',
        'finish_time',
    ];

    protected $fillable = [
        'start_time',
        'finish_time',
        'yard_id',
        'hauler_id',
        'creator_id',
        'truck_details',
        'driver_name',
        'contact',
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
}
