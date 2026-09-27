@extends('layouts.app')

@section('title', 'Daftar Barang')
@section('page_title', 'Daftar Barang')

@section('content')
<div class="space-y-6">
    @php
        $totalProducts = $products->count();
        $totalStock = $products->sum('stock');
        $totalValue = $products->sum(function($p) { return $p->price * $p->stock; });
        $available = $products->where('stock', '>', 0)->count();
    @endphp

    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white rounded-2xl p-6 border border-slate-100 shadow-sm flex items-center gap-5">
            <div class="w-12 h-12 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
            </div>
            <div>
                <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Total Barang</span>
                <h3 class="text-2xl font-bold text-slate-800 mt-0.5">{{ $totalProducts }}</h3>
                <p class="text-slate-400 text-xs mt-1">Item terdaftar</p>
            </div>
        </div>
        <div class="bg-white rounded-2xl p-6 border border-slate-100 shadow-sm flex items-center gap-5">
            <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <div>
                <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Total Stok</span>
                <h3 class="text-2xl font-bold text-slate-800 mt-0.5">{{ number_format($totalStock) }}</h3>
                <p class="text-slate-400 text-xs mt-1">Unit keseluruhan</p>
            </div>
        </div>
        <div class="bg-white rounded-2xl p-6 border border-slate-100 shadow-sm flex items-center gap-5">
            <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <div>
                <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Total Nilai</span>
                <h3 class="text-2xl font-bold text-slate-800 mt-0.5">Rp {{ number_format($totalValue, 0, ',', '.') }}</h3>
                <p class="text-slate-400 text-xs mt-1">Nilai inventaris</p>
            </div>
        </div>
        <div class="bg-white rounded-2xl p-6 border border-slate-100 shadow-sm flex items-center gap-5">
            <div class="w-12 h-12 rounded-xl {{ $available == $totalProducts ? 'bg-emerald-50 text-emerald-600' : 'bg-amber-50 text-amber-600' }} flex items-center justify-center">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <div>
                <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Tersedia</span>
                <h3 class="text-2xl font-bold text-slate-800 mt-0.5">{{ $available }}/{{ $totalProducts }}</h3>
                <p class="text-slate-400 text-xs mt-1">Barang siap jual</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="px-6 py-5 border-b border-slate-100 flex items-center justify-between">
            <div>
                <h3 class="text-lg font-bold text-slate-800">Semua Barang</h3>
                <p class="text-xs text-slate-400 mt-1">Kelola seluruh inventaris alat tulis.</p>
            </div>
            <a href="{{ route('products.create') }}" class="px-4 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl font-bold text-sm shadow-md shadow-indigo-600/10 transition duration-150 flex items-center">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                Tambah Barang
            </a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-slate-100 bg-slate-50/55 text-xs font-bold text-slate-400 uppercase">
                        <th class="py-3.5 px-5">Kode</th>
                        <th class="py-3.5 px-5">Nama Barang</th>
                        <th class="py-3.5 px-5">Kategori</th>
                        <th class="py-3.5 px-5 text-right">Harga</th>
                        <th class="py-3.5 px-5 text-right">Stok</th>
                        <th class="py-3.5 px-5 text-center">Status</th>
                        <th class="py-3.5 px-5">Dibuat</th>
                        <th class="py-3.5 px-5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($products as $product)
                        <tr class="text-sm hover:bg-slate-50/50 transition duration-150">
                            <td class="py-4 px-5 font-mono font-semibold text-slate-600">{{ $product->code }}</td>
                            <td class="py-4 px-5">
                                <div class="flex items-center">
                                    <div class="w-7 h-7 rounded-lg bg-slate-100 text-slate-600 flex items-center justify-center font-bold text-xs mr-2.5 flex-shrink-0">
                                        {{ strtoupper(substr($product->name, 0, 1)) }}
                                    </div>
                                    <span class="font-medium text-slate-800">{{ $product->name }}</span>
                                </div>
                            </td>
                            <td class="py-4 px-5">
                                <a href="{{ route('categories.show', $product->category) }}" class="text-xs font-medium text-indigo-600 hover:text-indigo-800 hover:underline">{{ $product->category->name }}</a>
                            </td>
                            <td class="py-4 px-5 text-right font-medium text-slate-600">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                            <td class="py-4 px-5 text-right">
                                <span class="font-bold {{ $product->stock > 10 ? 'text-slate-800' : ($product->stock > 0 ? 'text-amber-600' : 'text-rose-600') }}">
                                    {{ $product->stock }}
                                </span>
                            </td>
                            <td class="py-4 px-5 text-center">
                                @if($product->stock > 0)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-emerald-50 text-emerald-600">
                                        <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full mr-1.5"></span>
                                        Tersedia
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-rose-50 text-rose-600">
                                        <span class="w-1.5 h-1.5 bg-rose-500 rounded-full mr-1.5"></span>
                                        Tidak Tersedia
                                    </span>
                                @endif
                            </td>
                            <td class="py-4 px-5 text-xs text-slate-400">{{ $product->created_at->isoFormat('D MMM YYYY') }}</td>
                            <td class="py-4 px-5 text-right">
                                <div class="flex items-center justify-end gap-1">
                                    <a href="{{ route('products.show', $product) }}" class="px-3 py-1.5 text-xs font-bold text-indigo-600 hover:bg-indigo-50 rounded-lg transition duration-150 flex items-center">
                                        <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                        Detail
                                    </a>
                                    <a href="{{ route('products.edit', $product) }}" class="px-3 py-1.5 text-xs font-bold text-amber-600 hover:bg-amber-50 rounded-lg transition duration-150">Edit</a>
                                    <form action="{{ route('products.destroy', $product) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus barang \'{{ $product->name }}\'? Data mutasi terkait juga akan dihapus.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-3 py-1.5 text-xs font-bold text-rose-600 hover:bg-rose-50 rounded-lg transition duration-150">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="py-12 text-center">
                                <div class="w-14 h-14 bg-slate-50 text-slate-300 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                                </div>
                                <h4 class="text-base font-bold text-slate-700">Belum ada barang</h4>
                                <p class="text-sm text-slate-400 mt-1 max-w-xs mx-auto">Tambahkan barang pertama ke dalam sistem untuk mulai mengelola inventaris.</p>
                                <a href="{{ route('products.create') }}" class="inline-flex items-center mt-5 px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl font-bold text-sm shadow-md shadow-indigo-600/10 transition duration-150">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    Tambah Barang
                                </a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
