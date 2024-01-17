<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $guarded = false;

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function scopeFilter($query, $date_from, $date_to): void
    {
        $query
            ->when($date_from, fn ($query) => $query->whereDate('created_at', '>=', $date_from))
            ->when($date_to, fn ($query) => $query->whereDate('created_at', '<=', $date_to));
    }
}
