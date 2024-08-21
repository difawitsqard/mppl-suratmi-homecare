<?php

namespace App\Models;

use App\Models\OrderService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Testimonial extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $dates = ['created_at'];

    protected $fillable = [
        'content',
        'rating',
        'order_service_id',
        'created_at',
    ];

    public function orderService()
    {
        return $this->belongsTo(OrderService::class);
    }

    public function scopeFilter(Builder $query)
    {
        $columns = ['content', 'rating'];
        $query->when(request('search') ?? false, function ($query, $search) use ($columns) {
            $query->where(function ($query) use ($columns, $search) {
                foreach ($columns as $column) {
                    $query->orWhere($column, 'like', '%' . $search . '%');
                }
            })->orWhereHas('orderService.customer', function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%');
            });
        });
    }
}
