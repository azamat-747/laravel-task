<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $guarded = false;
    protected $appends = ['amount_formatted'];

    public function orderDetails(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(OrderDetail::class);
    }

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopeFilter($query, $date_from, $date_to): void
    {
        $query
            ->when($date_from, fn ($query) => $query->whereDate('created_at', '>=', $date_from))
            ->when($date_to, fn ($query) => $query->whereDate('created_at', '<=', $date_to));
    }

    public function getAmountFormattedAttribute(): string
    {
        return number_format($this->amount) . ' UZS';
    }

    public function getStatusTextAttribute(): string
    {
        return match ($this->status) {
            1 => 'New',
            2 => 'In process',
            3 => 'Completed',
            default => 'Unknown',
        };
    }
}
