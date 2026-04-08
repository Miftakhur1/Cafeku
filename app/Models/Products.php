<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Categories;

class Products extends Model
{
    protected $table = 'products';

    protected $fillable = [
        'categorie_id',
        'name',
        'slug',
        'description',
        'price',
        'stock',
        'image',
    ];

    public function categorie()
    {
        return $this->belongsTo(Categories::class, 'categorie_id');
    }
    public function orderItems()
    {
        return $this->hasMany(orderItem::class, 'product_id');
    }

    public function getImageUrlAttribute()
    {
        if (!$this->image) {
            return asset('storage/umkm/americano.jpg');
        }

        if (filter_var($this->image, FILTER_VALIDATE_URL)) {
            return $this->image;
        }

        $imagePath = ltrim($this->image, '/');
        $candidates = [
            $imagePath,
            'umkm/' . $imagePath,
            'products/' . $imagePath,
            'umkm/products/' . $imagePath,
        ];

        foreach ($candidates as $candidate) {
            if (file_exists(storage_path('app/public/' . $candidate))) {
                return asset('storage/' . $candidate);
            }
        }

        return asset('storage/umkm/americano.jpg');
    }
}
