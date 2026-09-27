<?php

namespace App\Http\Controllers;

use App\Models\StockMutation;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    /**
     * Tampilkan Halaman Laporan Mutasi Barang dengan filter tanggal.
     */
    public function index(Request $request)
    {
        $request->validate([
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        $query = StockMutation::with(['product.category', 'user'])
            ->orderBy('date', 'desc')
            ->orderBy('created_at', 'desc');

        // Filter berdasarkan tanggal mulai
        if ($request->filled('start_date')) {
            $query->where('date', '>=', $request->start_date);
        }

        // Filter berdasarkan tanggal selesai
        if ($request->filled('end_date')) {
            $query->where('date', '<=', $request->end_date);
        }

        $mutations = $query->paginate(15)->withQueryString();

        return view('reports.index', compact('mutations'));
    }
}
