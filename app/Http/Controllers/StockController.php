<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\StockMutation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StockController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->orderBy('name')->get();
        $totalItems = $products->count();
        $totalStock = $products->sum('stock');
        $totalMasuk = StockMutation::where('type', 'in')->sum('quantity');
        $totalKeluar = StockMutation::where('type', 'out')->sum('quantity');

        $mutations = StockMutation::with('product.category', 'user')
            ->orderBy('date', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('stocks.index', compact(
            'products', 'totalItems', 'totalStock', 'totalMasuk', 'totalKeluar', 'mutations'
        ));
    }

    public function create()
    {
        $products = Product::orderBy('name')->get();
        return view('stocks.create', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'type' => 'required|in:in,out',
            'quantity' => 'required|integer|min:1',
            'date' => 'required|date',
            'notes' => 'nullable|string',
        ]);

        $product = Product::findOrFail($request->product_id);

        if ($request->type === 'out' && $product->stock < $request->quantity) {
            return back()->withErrors([
                'quantity' => 'Stok tidak mencukupi! Stok saat ini untuk ' . $product->name . ' adalah ' . $product->stock . ' unit.',
            ])->withInput();
        }

        DB::transaction(function () use ($request, $product) {
            StockMutation::create([
                'product_id' => $request->product_id,
                'user_id' => auth()->id(),
                'type' => $request->type,
                'quantity' => $request->quantity,
                'date' => $request->date,
                'notes' => $request->notes,
            ]);

            if ($request->type === 'in') {
                $product->increment('stock', $request->quantity);
            } else {
                $product->decrement('stock', $request->quantity);
            }
        });

        $message = $request->type === 'in' ? 'Stok masuk berhasil dicatat.' : 'Stok keluar berhasil dicatat.';

        return redirect()->route('stocks.index')
            ->with('success', $message);
    }
}
