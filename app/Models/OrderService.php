<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;

class OrderService extends Model
{
    use HasFactory, HasRoles;

    protected $fillable = [
        'service_id',
        'note',
        'date',
    ];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}
