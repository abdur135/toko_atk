@extends('layouts.app')

@section('title', 'Laporan Mutasi Barang')
@section('page_title', 'Laporan Histori Persediaan')

@section('content')
<div class="space-y-6">
    <!-- Filter Card -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
        <h3 class="text-sm font-bold text-slate-700 uppercase tracking-wider mb-4 flex items-center">
            <svg class="w-4 h-4 mr-2 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 8.293A1 1 0 013 7.586V4z"></path>
            </svg>
            Filter Periode Mutasi
        </h3>
        
        <form action="{{ route('reports.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-6 items-end">
            <!-- Tanggal Mulai -->
            <div>
                <label for="start_date" class="block text-sm font-semibold text-slate-700 mb-1.5">Tanggal Mulai</label>
                <input type="date" name="start_date" id="start_date" value="{{ request('start_date') }}"
                    class="block w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm transition duration-150">
            </div>

            <!-- Tanggal Selesai -->
            <div>
                <label for="end_date" class="block text-sm font-semibold text-slate-700 mb-1.5">Tanggal Selesai</label>
                <input type="date" name="end_date" id="end_date" value="{{ request('end_date') }}"
                    class="block w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm transition duration-150">
            </div>

            <!-- Filter Buttons -->
            <div class="flex gap-3">
                <button type="submit"
                    class="flex-1 py-3 px-4 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl font-bold text-sm shadow-md shadow-indigo-600/10 transition duration-150 text-center">
                    Terapkan Filter
                </button>
                @if(request()->filled('start_date') || request()->filled('end_date'))
                    <a href="{{ route('reports.index') }}"
                        class="py-3 px-4 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-xl font-bold text-sm transition duration-150 text-center">
                        Reset
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Log/History Table Card -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <!-- Card Header -->
        <div class="px-6 py-5 border-b border-slate-100 flex items-center justify-between">
            <div>
                <h3 class="text-lg font-bold text-slate-800">Riwayat Mutasi Persediaan</h3>
                <p class="text-xs text-slate-400 mt-1">Daftar lengkap transaksi keluar-masuk stok barang toko.</p>
            </div>
            <span class="px-3 py-1 bg-slate-100 text-slate-600 font-semibold rounded-full text-xs">
                Total: {{ $mutations->total() }} Transaksi
            </span>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-slate-100 bg-slate-50/55 text-xs font-bold text-slate-400 uppercase">
                        <th class="py-3.5 px-6">Tanggal</th>
                        <th class="py-3.5 px-6">Petugas</th>
                        <th class="py-3.5 px-6">Barang</th>
                        <th class="py-3.5 px-6">Kategori</th>
                        <th class="py-3.5 px-6 text-center">Jenis</th>
                        <th class="py-3.5 px-6 text-right">Jumlah</th>
                        <th class="py-3.5 px-6">Keterangan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($mutations as $mutation)
                        <tr class="text-sm hover:bg-slate-50/50 transition duration-150">
                            <!-- Tanggal -->
                            <td class="py-4 px-6 font-semibold text-slate-600 whitespace-nowrap">
                                {{ \Carbon\Carbon::parse($mutation->date)->isoFormat('D MMM YYYY') }}
                            </td>
                            <!-- Petugas -->
                            <td class="py-4 px-6">
                                <div class="flex items-center">
                                    <div class="w-7 h-7 rounded-full bg-slate-100 text-slate-600 flex items-center justify-center font-bold text-xs mr-2">
                                        {{ strtoupper(substr($mutation->user->name, 0, 1)) }}
                                    </div>
                                    <span class="font-medium text-slate-700">{{ $mutation->user->name }}</span>
                                </div>
                            </td>
                            <!-- Barang -->
                            <td class="py-4 px-6">
                                <div>
                                    <span class="font-bold text-slate-800 block leading-tight">{{ $mutation->product->name }}</span>
                                    <span class="text-xs text-slate-400">{{ $mutation->product->code }}</span>
                                </div>
                            </td>
                            <!-- Kategori -->
                            <td class="py-4 px-6 text-xs font-medium text-slate-500">
                                {{ $mutation->product->category->name }}
                            </td>
                            <!-- Jenis Mutasi (Masuk/Keluar) -->
                            <td class="py-4 px-6 text-center whitespace-nowrap">
                                @if($mutation->type === 'in')
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-emerald-50 text-emerald-600">
                                        <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 13l-7 7-7-7m14-6l-7 7-7-7"></path>
                                        </svg>
                                        Masuk
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-rose-50 text-rose-600">
                                        <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 11l7-7 7 7M5 19l7-7 7 7"></path>
                                        </svg>
                                        Keluar
                                    </span>
                                @endif
                            </td>
                            <!-- Jumlah -->
                            <td class="py-4 px-6 text-right font-extrabold text-slate-800">
                                {{ number_format($mutation->quantity) }} <span class="text-xs font-medium text-slate-400">unit</span>
                            </td>
                            <!-- Keterangan -->
                            <td class="py-4 px-6 text-xs text-slate-500 max-w-xs truncate" title="{{ $mutation->notes }}">
                                {{ $mutation->notes ?? '-' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-12 text-center">
                                <div class="w-12 h-12 bg-slate-50 text-slate-400 rounded-full flex items-center justify-center mx-auto mb-3">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                    </svg>
                                </div>
                                <h4 class="text-sm font-semibold text-slate-700">Tidak ada riwayat mutasi</h4>
                                <p class="text-xs text-slate-400 mt-1">Belum ada data transaksi persediaan yang sesuai dengan filter.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination Links -->
        @if($mutations->hasPages())
            <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/50 flex items-center justify-between">
                {{ $mutations->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
