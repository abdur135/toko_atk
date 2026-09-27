<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'code',
        'name',
        'price',
        'stock',
        'description',
    ];

    /**
     * Relasi ke Kategori (Produk memiliki satu Kategori)
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Relasi ke Mutasi Stok (Produk memiliki banyak catatan mutasi stok)
     */
    public function stockMutations()
    {
        return $this->hasMany(StockMutation::class);
    }

    /**
     * Accessor untuk mendapatkan status ketersediaan barang secara otomatis
     * e.g. $product->status
     */
    public function getStatusAttribute(): string
    {
        return $this->stock > 0 ? 'Tersedia' : 'Tidak Tersedia';
    }
}
