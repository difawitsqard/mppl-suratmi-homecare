<?php

namespace App\Models;

use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Faq extends Model
{
    use HasFactory, HasRoles;

    protected $fillable = [
        'question',
        'answer',
    ];

    public function scopeFilter(Builder $query)
    {
        $query->when(request('search'), function ($query, $search) {
            $query->where('question', 'like', '%' . $search . '%')
                ->orWhere('answer', 'like', '%' . $search . '%');
        });
    }
}
