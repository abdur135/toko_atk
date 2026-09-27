<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class MasterController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $type = $request->get('type'); // '', 'kategori', 'barang', 'pengguna'
        $perPage = 15;

        $items = collect();

        if (!$type || $type === 'kategori') {
            $categories = Category::withCount('products')
                ->when($search, fn($q) => $q->where('name', 'like', "%{$search}%"))
                ->orderBy('created_at', 'desc')
                ->get()
                ->map(fn($c) => (object) [
                    'id' => 'cat_' . $c->id,
                    'type' => 'kategori',
                    'type_label' => 'Kategori',
                    'name' => $c->name,
                    'identifier' => $c->slug,
                    'info' => $c->products_count . ' produk',
                    'status' => 'Aktif',
                    'status_color' => 'emerald',
                    'stock' => null,
                    'avatar' => strtoupper(substr($c->name, 0, 1)),
                    'avatar_bg' => 'indigo',
                    'created_at' => $c->created_at,
                    'route_edit' => route('categories.edit', $c),
                    'route_destroy' => route('categories.destroy', $c),
                    'route_show' => route('categories.show', $c),
                    'model_type' => Category::class,
                    'model_id' => $c->id,
                ]);
            $items = $items->merge($categories);
        }

        if (!$type || $type === 'barang') {
            $products = Product::with('category')
                ->when($search, fn($q) => $q->where('name', 'like', "%{$search}%")
                    ->orWhere('code', 'like', "%{$search}%"))
                ->orderBy('created_at', 'desc')
                ->get()
                ->map(fn($p) => (object) [
                    'id' => 'prd_' . $p->id,
                    'type' => 'barang',
                    'type_label' => 'Barang',
                    'name' => $p->name,
                    'identifier' => $p->code,
                    'info' => $p->category->name . ' · Rp ' . number_format($p->price, 0, ',', '.'),
                    'status' => $p->stock > 0 ? ($p->stock < 10 ? 'Kritis' : 'Tersedia') : 'Habis',
                    'status_color' => $p->stock > 0 ? ($p->stock < 10 ? 'amber' : 'emerald') : 'rose',
                    'stock' => $p->stock,
                    'avatar' => strtoupper(substr($p->name, 0, 3)),
                    'avatar_bg' => $p->stock > 0 ? ($p->stock < 10 ? 'amber' : 'emerald') : 'rose',
                    'created_at' => $p->created_at,
                    'route_edit' => route('products.edit', $p),
                    'route_destroy' => route('products.destroy', $p),
                    'route_show' => route('products.show', $p),
                    'model_type' => Product::class,
                    'model_id' => $p->id,
                ]);
            $items = $items->merge($products);
        }

        if (!$type || $type === 'pengguna') {
            $users = User::when($search, fn($q) => $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%"))
                ->orderBy('created_at', 'desc')
                ->get()
                ->map(fn($u) => (object) [
                    'id' => 'usr_' . $u->id,
                    'type' => 'pengguna',
                    'type_label' => 'Pengguna',
                    'name' => $u->name,
                    'identifier' => $u->email,
                    'info' => ucfirst($u->role),
                    'status' => 'Aktif',
                    'status_color' => 'emerald',
                    'stock' => null,
                    'avatar' => strtoupper(substr($u->name, 0, 2)),
                    'avatar_bg' => 'amber',
                    'created_at' => $u->created_at,
                    'route_edit' => route('users.edit', $u),
                    'route_destroy' => route('users.destroy', $u),
                    'route_show' => route('users.show', $u),
                    'model_type' => User::class,
                    'model_id' => $u->id,
                    'is_self' => auth()->id() === $u->id,
                ]);
            $items = $items->merge($users);
        }

        $items = $items->sortByDesc('created_at');

        $page = $request->get('page', 1);
        $offset = ($page - 1) * $perPage;
        $paginated = new LengthAwarePaginator(
            $items->slice($offset, $perPage)->values(),
            $items->count(),
            $perPage,
            $page,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        return view('master.index', [
            'masterData' => $paginated,
            'totalCategories' => Category::count(),
            'totalProducts' => Product::count(),
            'totalUsers' => User::count(),
            'lowStockCount' => Product::where('stock', '<', 10)->count(),
            'search' => $search,
            'activeType' => $type ?: 'semua',
        ]);
    }

    public function batchDelete(Request $request)
    {
        $ids = $request->get('ids', []);
        $count = 0;

        foreach ($ids as $rawId) {
            $parts = explode('_', $rawId, 2);
            if (count($parts) !== 2) continue;

            [$prefix, $modelId] = $parts;

            $modelClass = match ($prefix) {
                'cat' => Category::class,
                'prd' => Product::class,
                'usr' => User::class,
                default => null,
            };

            if (!$modelClass) continue;

            $model = $modelClass::find($modelId);
            if (!$model) continue;

            if ($modelClass === User::class && auth()->id() === (int) $modelId) {
                continue;
            }

            $model->delete();
            $count++;
        }

        return redirect()->route('master.index')
            ->with('success', "{$count} data berhasil dihapus.");
    }
}
