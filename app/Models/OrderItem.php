<?php

namespace App\Models;

use App\Models\Order;
use App\Models\Products;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderItem extends Model
{
    protected $fillable = [
        'order_id',
        'product_id',
        'quantity',
        'unit_price',
        'subtotal',
    ];

    /**
     * Relasi balik ke Order
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Relasi ke Product (Untuk ambil nama/barcode produk)
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Products::class);
    }
}