<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockMutation extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'user_id',
        'type', // 'in' atau 'out'
        'quantity',
        'date',
        'notes',
    ];

    /**
     * Relasi ke Produk (Mutasi merujuk ke satu Produk)
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Relasi ke User (Mutasi dicatat oleh satu User/Admin)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
