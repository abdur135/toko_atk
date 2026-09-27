<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\StockMutation;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Tampilkan Halaman Beranda / Dashboard Admin.
     */
    public function index()
    {
        // 1. Total Jenis Barang (Count unique items)
        $totalCategories = Product::distinct('code')->count('code'); // atau Product::count()

        // 2. Total Stok Masuk (Sum semua transaksi masuk)
        $totalStokMasuk = StockMutation::where('type', 'in')->sum('quantity');

        // 3. Total Stok Keluar (Sum semua transaksi keluar)
        $totalStokKeluar = StockMutation::where('type', 'out')->sum('quantity');

        // 4. Stok Terendah (< 10 unit)
        $lowStockProducts = Product::with('category')
            ->where('stock', '<', 10)
            ->orderBy('stock', 'asc')
            ->get();

        // 5. Stok Tertinggi
        $highestStockProduct = Product::with('category')
            ->orderBy('stock', 'desc')
            ->first();

        return view('dashboard', compact(
            'totalCategories',
            'totalStokMasuk',
            'totalStokKeluar',
            'lowStockProducts',
            'highestStockProduct'
        ));
    }
}
