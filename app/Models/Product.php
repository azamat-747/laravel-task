<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $guarded = false;

    protected $casts = [
        'status' => 'boolean'
    ];

    public function orderDetails(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(OrderDetail::class);
    }
    public function scopeStatus($query) {
        return $query->where('status', true);
    }
}
