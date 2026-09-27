@extends('layouts.app')

@section('title', 'Beranda Admin')
@section('page_title', 'Dashboard Beranda')

@section('content')
<div class="space-y-8">
    <!-- Welcome Header Widget -->
    <div class="bg-gradient-to-r from-slate-900 via-slate-800 to-indigo-900 rounded-2xl p-6 md:p-8 text-white shadow-xl flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl md:text-3xl font-extrabold tracking-tight">Selamat Datang di Toko Alat Tulis</h1>
            <p class="text-slate-300 mt-2 text-sm md:text-base">Kelola kategori barang, inventori produk, mutasi stok barang masuk/keluar, dan laporan mutasi secara real-time.</p>
        </div>
        <div class="flex-shrink-0 flex gap-3">
            <a href="{{ route('stocks.index') }}" class="px-5 py-3 bg-indigo-600 hover:bg-indigo-500 font-bold text-sm rounded-xl shadow-lg shadow-indigo-600/30 transition duration-150 flex items-center">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                Kelola Persediaan
            </a>
        </div>
    </div>

    <!-- Widgets Grid -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Widget 1: Total Jenis Barang -->
        <div class="bg-white rounded-2xl p-6 border border-slate-100 shadow-sm hover:shadow-md transition duration-200 flex items-center gap-5">
            <div class="w-12 h-12 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center flex-shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                </svg>
            </div>
            <div>
                <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Total Jenis Barang</span>
                <h3 class="text-2xl font-bold text-slate-800 mt-0.5">{{ number_format($totalCategories) }}</h3>
                <p class="text-slate-400 text-xs mt-1">Item barang unik terdaftar</p>
            </div>
        </div>

        <!-- Widget 2: Total Stok Masuk -->
        <div class="bg-white rounded-2xl p-6 border border-slate-100 shadow-sm hover:shadow-md transition duration-200 flex items-center gap-5">
            <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center flex-shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                </svg>
            </div>
            <div>
                <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Total Stok Masuk</span>
                <h3 class="text-2xl font-bold text-slate-800 mt-0.5">{{ number_format($totalStokMasuk) }} <span class="text-xs font-medium text-slate-400">unit</span></h3>
                <p class="text-slate-400 text-xs mt-1">Akumulasi stok masuk</p>
            </div>
        </div>

        <!-- Widget 3: Total Stok Keluar -->
        <div class="bg-white rounded-2xl p-6 border border-slate-100 shadow-sm hover:shadow-md transition duration-200 flex items-center gap-5">
            <div class="w-12 h-12 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center flex-shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                </svg>
            </div>
            <div>
                <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Total Stok Keluar</span>
                <h3 class="text-2xl font-bold text-slate-800 mt-0.5">{{ number_format($totalStokKeluar) }} <span class="text-xs font-medium text-slate-400">unit</span></h3>
                <p class="text-slate-400 text-xs mt-1">Akumulasi stok keluar</p>
            </div>
        </div>
    </div>

    <!-- Spotlight Widget: Stok Tertinggi & Analisa -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Widget: Stok Tertinggi (Spotlight Card) -->
        <div class="bg-gradient-to-br from-indigo-500 to-purple-600 rounded-2xl p-6 text-white shadow-lg shadow-indigo-500/20 lg:col-span-1 flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between mb-4">
                    <span class="bg-indigo-400/30 px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider text-indigo-100">Stok Tertinggi 🔥</span>
                    <svg class="w-8 h-8 text-indigo-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                    </svg>
                </div>
                @if($highestStockProduct)
                    <span class="text-xs text-indigo-200 uppercase font-medium">{{ $highestStockProduct->category->name }}</span>
                    <h3 class="text-2xl font-extrabold tracking-tight mt-1 leading-tight">{{ $highestStockProduct->name }}</h3>
                    <p class="text-xs text-indigo-100/80 mt-1">Kode: {{ $highestStockProduct->code }}</p>
                @else
                    <h3 class="text-lg font-bold mt-2">Belum ada barang</h3>
                    <p class="text-xs text-indigo-100/80 mt-1">Silakan daftarkan produk terlebih dahulu.</p>
                @endif
            </div>

            <div class="mt-8">
                <div class="border-t border-indigo-400/20 pt-4 flex items-baseline justify-between">
                    <div>
                        <span class="text-xs text-indigo-200 block">Jumlah Stok Terbanyak</span>
                        <span class="text-3xl font-extrabold tracking-tight">
                            {{ $highestStockProduct ? number_format($highestStockProduct->stock) : '0' }}
                        </span>
                        <span class="text-xs text-indigo-200">unit</span>
                    </div>
                    @if($highestStockProduct)
                        <div class="text-right">
                            <span class="text-xs text-indigo-200 block">Status Ketersediaan</span>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-indigo-100 text-indigo-800 mt-1">
                                {{ $highestStockProduct->status }}
                            </span>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Widget: Stok Terendah (< 10 Unit) -->
        <div class="bg-white rounded-2xl p-6 border border-slate-100 shadow-sm lg:col-span-2 flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-bold text-slate-800">Peringatan Stok Terendah (&lt; 10 Unit) ⚠️</h3>
                    <span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-rose-50 text-rose-600">
                        {{ $lowStockProducts->count() }} Produk Butuh Restock
                    </span>
                </div>

                @if($lowStockProducts->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="border-b border-slate-100 text-xs font-bold text-slate-400 uppercase">
                                    <th class="py-3">Kode</th>
                                    <th class="py-3">Nama Barang</th>
                                    <th class="py-3">Kategori</th>
                                    <th class="py-3 text-right">Stok</th>
                                    <th class="py-3 text-center">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-50">
                                @foreach($lowStockProducts as $product)
                                    <tr class="text-sm">
                                        <td class="py-3 font-semibold text-slate-600">{{ $product->code }}</td>
                                        <td class="py-3 font-medium text-slate-900">{{ $product->name }}</td>
                                        <td class="py-3 text-slate-500 text-xs">{{ $product->category->name }}</td>
                                        <td class="py-3 text-right font-extrabold {{ $product->stock == 0 ? 'text-rose-600' : 'text-amber-600' }}">
                                            {{ $product->stock }}
                                        </td>
                                        <td class="py-3 text-center">
                                            @if($product->stock == 0)
                                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-bold bg-rose-50 text-rose-600">Habis</span>
                                            @else
                                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-bold bg-amber-50 text-amber-600">Kritis</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="flex flex-col items-center justify-center py-8 text-center">
                        <div class="w-12 h-12 bg-emerald-50 text-emerald-500 rounded-full flex items-center justify-center mb-3">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <h4 class="text-sm font-semibold text-slate-700">Semua Stok Aman</h4>
                        <p class="text-xs text-slate-400 mt-1">Tidak ada produk dengan jumlah stok di bawah 10 unit saat ini.</p>
                    </div>
                @endif
            </div>

            <div class="mt-6 border-t border-slate-100 pt-4 flex justify-end">
                <a href="{{ route('products.index') }}" class="text-xs font-bold text-indigo-600 hover:text-indigo-700 flex items-center transition duration-150">
                    Lihat Semua Daftar Barang
                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
