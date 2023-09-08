<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InventoryItem extends Model
{
    use SoftDeletes, HasFactory;

    public $table = 'inventory_items';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'category',
        'yard_id',
        'creator_id',
        'department_id',
        'ref',
        'um_number',
        'rtn_port',
        'size',
        'status',
        'structural_status',
        'inspected',
        'inspection_status',
        'general_condition',
        'refurbished',
        'creator',
        'cnumbers_visible',
        'year_manufactured',
        'type',
        'remarks',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function yard()
    {
        return $this->belongsTo(Yard::class, 'yard_id');
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

}
