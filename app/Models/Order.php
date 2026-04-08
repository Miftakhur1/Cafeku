<?php

namespace App\Models;

use App\Models\OrderItem;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes; // Aktifkan karena di migration ada softDeletes()

    protected $fillable = [
        'order_number',
        'customer_name',
        'service_type',
        'table_number',
        'phone',
        'address',
        'status',
        'payment_method',
        'total_price',
    ];

    /**
     * Relasi ke detail item (Satu pesanan punya banyak item)
     */
    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class, 'order_id');
    }
}