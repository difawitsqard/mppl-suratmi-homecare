<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderService extends Model
{
    use HasFactory, HasRoles;

    protected $fillable = [
        'customer_id',
        'therapist_id',
        'service_id',
        'note',
        'date',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'date_format',
        'created_at_formatted',
    ];

    public function getStatusAttribute()
    {
        $value = $this->attributes['status'] ?? null;

        if ($value === 'pending') {
            $orderDate = Carbon::parse($this->date);
            $currentDate = Carbon::now();
            if ($orderDate < $currentDate->startOfDay()) {
                return 'canceled';
            }
        }

        return $value;
    }

    protected function getCreatedAtFormattedAttribute()
    {
        return Carbon::parse($this->attributes['created_at'])->translatedFormat('d F Y H:i');
    }

    public function getDateFormatAttribute()
    {
        return Carbon::parse($this->date)->translatedFormat('d F Y H:i');
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function testimonial()
    {
        return $this->hasOne(Testimonial::class);
    }

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id', 'id');
    }

    public function therapist()
    {
        return $this->belongsTo(User::class, 'therapist_id', 'id');
    }

    public function scopeFilter(Builder $query)
    {
        $query->when(request('search') ?? false, function ($query, $search) {
            $query->where(function ($query) use ($search) {
                $query->whereHas('customer', function ($query) use ($search) {
                    $query->where('name', 'like', '%' . $search . '%');
                })
                    ->orWhereHas('therapist', function ($query) use ($search) {
                        $query->where('name', 'like', '%' . $search . '%');
                    })
                    ->orWhereHas('service', function ($query) use ($search) {
                        $query->where('name', 'like', '%' . $search . '%');
                    });
            });
        });
    }
}
