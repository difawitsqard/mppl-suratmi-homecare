<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
    ];

    public function scopeFilter($query)
    {
        $columns = ['name', 'description'];
        $query->when(request('search') ?? false, function ($query, $search) use ($columns) {
            $query->where(function ($query) use ($columns, $search) {
                foreach ($columns as $column) {
                    $query->orWhere($column, 'like', '%' . $search . '%');
                }
            });
        });
    }
}
