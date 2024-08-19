<?php

namespace App\Models;

use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Gallery extends Model
{
    use HasFactory, HasRoles;

    protected $fillable = [
        'title',
        'description',
        'image_path',
    ];

    protected $appends = [
        'image_url',
    ];

    public function getImageUrlAttribute()
    {
        $filePath = public_path('uploads/' . $this->image_path);
        if (file_exists($filePath)) {
            return asset('uploads/' . $this->image_path);
        } else {
            return asset('images/placeholder-image.webp');
        }
    }

    public function scopeFilter(Builder $query)
    {
        $query->when(request('search'), function ($query, $search) {
            $query->where('title', 'like', '%' . $search . '%');
        });
    }
}
