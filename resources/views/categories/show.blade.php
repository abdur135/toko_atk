@extends('layouts.app')

@section('title', 'Detail Kategori')
@section('page_title', 'Detail Kategori')

@section('content')
<div class="space-y-6">
    <div class="max-w-3xl mx-auto">
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
            <div class="px-6 py-5 border-b border-slate-100 bg-gradient-to-r from-indigo-50 to-slate-50 flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <div class="w-14 h-14 rounded-xl bg-indigo-100 text-indigo-600 flex items-center justify-center font-bold text-xl">
                        {{ strtoupper(substr($category->name, 0, 2)) }}
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-slate-800">{{ $category->name }}</h3>
                        <p class="text-xs text-slate-400 mt-0.5 font-mono">Slug: {{ $category->slug }}</p>
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    <a href="{{ route('categories.edit', $category) }}" class="px-4 py-2 bg-amber-600 hover:bg-amber-700 text-white rounded-xl font-bold text-xs transition duration-150 flex items-center">
                        <svg class="w-3.5 h-3.5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                        Edit
                    </a>
                    <a href="{{ route('categories.index') }}" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-xl font-bold text-xs transition duration-150">Kembali</a>
                </div>
            </div>

            <div class="p-6 space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-slate-50 rounded-xl p-5">
                        <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Informasi Kategori</span>
                        <div class="mt-4 space-y-3">
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-slate-500">Nama</span>
                                <span class="text-sm font-semibold text-slate-800">{{ $category->name }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-slate-500">Slug</span>
                                <span class="text-sm font-mono font-semibold text-slate-800">{{ $category->slug }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-slate-500">Dibuat</span>
                                <span class="text-sm font-semibold text-slate-800">{{ $category->created_at->isoFormat('D MMMM YYYY, HH:mm') }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-slate-500">Diperbarui</span>
                                <span class="text-sm font-semibold text-slate-800">{{ $category->updated_at->isoFormat('D MMMM YYYY, HH:mm') }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="bg-indigo-50 rounded-xl p-5">
                        <span class="text-xs font-semibold text-indigo-400 uppercase tracking-wider">Statistik Produk</span>
                        <div class="mt-4 space-y-3">
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-indigo-600">Total Produk</span>
                                <span class="text-lg font-bold text-indigo-800">{{ $category->products->count() }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-indigo-600">Total Nilai Stok</span>
                                <span class="text-lg font-bold text-indigo-800">Rp {{ number_format($category->products->sum(function($p) { return $p->price * $p->stock; }), 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-indigo-600">Barang Tersedia</span>
                                <span class="text-lg font-bold text-emerald-600">{{ $category->products->where('stock', '>', 0)->count() }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div>
                    <div class="flex items-center justify-between mb-4">
                        <h4 class="text-sm font-bold text-slate-700 uppercase tracking-wider">Daftar Produk</h4>
                        <a href="{{ route('products.create') }}" class="text-xs font-bold text-indigo-600 hover:text-indigo-700 transition duration-150">+ Tambah Produk Baru</a>
                    </div>
                    @if($category->products->count() > 0)
                        <div class="overflow-x-auto border border-slate-100 rounded-xl">
                            <table class="w-full text-left border-collapse">
                                <thead>
                                    <tr class="border-b border-slate-100 bg-slate-50/80 text-xs font-bold text-slate-400 uppercase">
                                        <th class="py-3.5 px-5">Kode</th>
                                        <th class="py-3.5 px-5">Nama Barang</th>
                                        <th class="py-3.5 px-5 text-right">Harga</th>
                                        <th class="py-3.5 px-5 text-right">Stok</th>
                                        <th class="py-3.5 px-5 text-center">Status</th>
                                        <th class="py-3.5 px-5 text-right">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-50">
                                    @foreach($category->products as $product)
                                        <tr class="text-sm hover:bg-slate-50/30 transition duration-150">
                                            <td class="py-3.5 px-5 font-mono font-semibold text-slate-600">{{ $product->code }}</td>
                                            <td class="py-3.5 px-5 font-medium text-slate-800">{{ $product->name }}</td>
                                            <td class="py-3.5 px-5 text-right text-slate-600">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                                            <td class="py-3.5 px-5 text-right font-bold {{ $product->stock > 0 ? 'text-slate-800' : 'text-rose-600' }}">{{ $product->stock }}</td>
                                            <td class="py-3.5 px-5 text-center">
                                                @if($product->stock > 0)
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-emerald-50 text-emerald-600">
                                                        <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full mr-1.5"></span>
                                                        Tersedia
                                                    </span>
                                                @else
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-rose-50 text-rose-600">
                                                        <span class="w-1.5 h-1.5 bg-rose-500 rounded-full mr-1.5"></span>
                                                        Habis
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="py-3.5 px-5 text-right">
                                                <a href="{{ route('products.show', $product) }}" class="text-xs font-bold text-indigo-600 hover:text-indigo-800 transition duration-150">Detail</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-10 bg-slate-50 rounded-xl border border-dashed border-slate-200">
                            <div class="w-12 h-12 bg-white text-slate-400 rounded-full flex items-center justify-center mx-auto mb-3 shadow-sm">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                </svg>
                            </div>
                            <h4 class="text-sm font-bold text-slate-700">Belum ada produk</h4>
                            <p class="text-xs text-slate-400 mt-1">Kategori ini belum memiliki produk apapun.</p>
                        </div>
                    @endif
                </div>

                @if(auth()->id())
                <div class="border-t border-slate-100 pt-6 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <form action="{{ route('categories.edit', $category) }}" method="GET">
                            <button type="submit" class="px-4 py-2 bg-amber-600 hover:bg-amber-700 text-white rounded-xl font-bold text-xs transition duration-150">Edit Kategori</button>
                        </form>
                        <form action="{{ route('categories.destroy', $category) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus kategori \'{{ $category->name }}\'? Tindakan ini tidak dapat dibatalkan.');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-4 py-2 bg-rose-600 hover:bg-rose-700 text-white rounded-xl font-bold text-xs transition duration-150">Hapus Kategori</button>
                        </form>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
