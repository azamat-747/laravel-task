<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    use HasFactory;

    protected $guarded = false;
    protected $appends = ['price_formatted', 'total_formatted'];

    public function order(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function product(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function getPriceFormattedAttribute(): string
    {
        return number_format($this->price) . ' UZS';
    }

    public function getTotalFormattedAttribute(): string
    {
        return number_format($this->price * $this->quantity) . ' UZS';
    }

}
