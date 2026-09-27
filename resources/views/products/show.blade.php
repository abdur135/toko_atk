@extends('layouts.app')

@section('title', 'Detail Barang')
@section('page_title', 'Detail Barang')

@section('content')
<div class="space-y-6">
    <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
            <div class="px-6 py-5 border-b border-slate-100 bg-gradient-to-r from-indigo-50 to-slate-50 flex items-center justify-between">
                <div>
                    <div class="flex items-center gap-3">
                        <span class="px-3 py-1 bg-indigo-100 text-indigo-700 rounded-lg font-mono font-bold text-xs">{{ $product->code }}</span>
                        <h3 class="text-xl font-bold text-slate-800">{{ $product->name }}</h3>
                    </div>
                    <p class="text-xs text-slate-400 mt-1.5">
                        Kategori: <a href="{{ route('categories.show', $product->category) }}" class="text-indigo-600 hover:text-indigo-800 font-semibold hover:underline">{{ $product->category->name }}</a>
                        &middot; Dibuat: {{ $product->created_at->isoFormat('D MMM YYYY, HH:mm') }}
                    </p>
                </div>
                <div class="flex items-center gap-2">
                    <a href="{{ route('stocks.index') }}" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl font-bold text-xs transition duration-150 flex items-center">
                        <svg class="w-3.5 h-3.5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path></svg>
                        Persediaan
                    </a>
                    <a href="{{ route('products.edit', $product) }}" class="px-4 py-2 bg-amber-600 hover:bg-amber-700 text-white rounded-xl font-bold text-xs transition duration-150 flex items-center">
                        <svg class="w-3.5 h-3.5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                        Edit
                    </a>
                    <a href="{{ route('products.index') }}" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-xl font-bold text-xs transition duration-150">Kembali</a>
                </div>
            </div>

            <div class="p-6 space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div class="bg-slate-50 rounded-xl p-5 text-center">
                        <span class="text-xs font-semibold text-slate-400 uppercase">Harga Jual</span>
                        <h4 class="text-2xl font-extrabold text-slate-800 mt-2">Rp {{ number_format($product->price, 0, ',', '.') }}</h4>
                    </div>
                    <div class="bg-slate-50 rounded-xl p-5 text-center">
                        <span class="text-xs font-semibold text-slate-400 uppercase">Stok Saat Ini</span>
                        <h4 class="text-2xl font-extrabold {{ $product->stock > 0 ? 'text-emerald-600' : 'text-rose-600' }} mt-2">{{ $product->stock }} <span class="text-sm font-medium text-slate-400">unit</span></h4>
                    </div>
                    <div class="bg-slate-50 rounded-xl p-5 text-center">
                        <span class="text-xs font-semibold text-slate-400 uppercase">Nilai Stok</span>
                        <h4 class="text-2xl font-extrabold text-slate-800 mt-2">Rp {{ number_format($product->price * $product->stock, 0, ',', '.') }}</h4>
                    </div>
                    <div class="bg-slate-50 rounded-xl p-5 text-center">
                        <span class="text-xs font-semibold text-slate-400 uppercase">Status</span>
                        <h4 class="mt-2">
                            @if($product->stock > 0)
                                <span class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-bold bg-emerald-50 text-emerald-600">
                                    <span class="w-2 h-2 bg-emerald-500 rounded-full mr-2"></span>
                                    Tersedia
                                </span>
                            @else
                                <span class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-bold bg-rose-50 text-rose-600">
                                    <span class="w-2 h-2 bg-rose-500 rounded-full mr-2"></span>
                                    Tidak Tersedia
                                </span>
                            @endif
                        </h4>
                    </div>
                </div>

                @if($product->description)
                    <div class="bg-slate-50 rounded-xl p-5">
                        <h5 class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Deskripsi</h5>
                        <p class="text-sm text-slate-600 leading-relaxed">{{ $product->description }}</p>
                    </div>
                @endif

                <div>
                    <div class="flex items-center justify-between mb-4">
                        <h5 class="text-sm font-bold text-slate-700 uppercase tracking-wider flex items-center">
                            <svg class="w-4 h-4 mr-2 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                            Riwayat Mutasi Stok
                        </h5>
                        <span class="text-xs text-slate-400">{{ $product->stockMutations->count() }} transaksi</span>
                    </div>
                    @if($product->stockMutations->count() > 0)
                        <div class="overflow-x-auto border border-slate-100 rounded-xl">
                            <table class="w-full text-left border-collapse">
                                <thead>
                                    <tr class="border-b border-slate-100 bg-slate-50/80 text-xs font-bold text-slate-400 uppercase">
                                        <th class="py-3.5 px-5">Tanggal</th>
                                        <th class="py-3.5 px-5">Petugas</th>
                                        <th class="py-3.5 px-5 text-center">Jenis</th>
                                        <th class="py-3.5 px-5 text-right">Jumlah</th>
                                        <th class="py-3.5 px-5">Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-50">
                                    @foreach($product->stockMutations as $mutation)
                                        <tr class="text-sm hover:bg-slate-50/30 transition duration-150">
                                            <td class="py-3.5 px-5 font-semibold text-slate-600 whitespace-nowrap">{{ \Carbon\Carbon::parse($mutation->date)->isoFormat('D MMM YYYY') }}</td>
                                            <td class="py-3.5 px-5">
                                                <div class="flex items-center">
                                                    <div class="w-6 h-6 rounded-full bg-slate-100 text-slate-600 flex items-center justify-center font-bold text-xs mr-2">{{ strtoupper(substr($mutation->user->name, 0, 1)) }}</div>
                                                    <span class="text-slate-600">{{ $mutation->user->name }}</span>
                                                </div>
                                            </td>
                                            <td class="py-3.5 px-5 text-center">
                                                @if($mutation->type === 'in')
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-emerald-50 text-emerald-600">
                                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 13l-7 7-7-7m14-6l-7 7-7-7"></path></svg>
                                                        Masuk
                                                    </span>
                                                @else
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-rose-50 text-rose-600">
                                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 11l7-7 7 7M5 19l7-7 7 7"></path></svg>
                                                        Keluar
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="py-3.5 px-5 text-right font-extrabold text-slate-800">{{ number_format($mutation->quantity) }} <span class="text-xs font-medium text-slate-400">unit</span></td>
                                            <td class="py-3.5 px-5 text-xs text-slate-500 max-w-[200px] truncate" title="{{ $mutation->notes }}">{{ $mutation->notes ?? '-' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-10 bg-slate-50 rounded-xl border border-dashed border-slate-200">
                            <div class="w-12 h-12 bg-white text-slate-400 rounded-full flex items-center justify-center mx-auto mb-3 shadow-sm">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path></svg>
                            </div>
                            <h4 class="text-sm font-bold text-slate-700">Belum ada riwayat mutasi</h4>
                            <p class="text-xs text-slate-400 mt-1">Catat mutasi stok untuk mulai melacak pergerakan barang ini.</p>
                            <a href="{{ route('stocks.index') }}" class="inline-flex items-center mt-4 px-4 py-2 bg-indigo-600 text-white rounded-xl font-bold text-xs transition duration-150">Kelola Persediaan</a>
                        </div>
                    @endif
                </div>

                <div class="border-t border-slate-100 pt-6 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <form action="{{ route('products.edit', $product) }}" method="GET">
                            <button type="submit" class="px-4 py-2 bg-amber-600 hover:bg-amber-700 text-white rounded-xl font-bold text-xs transition duration-150">Edit Barang</button>
                        </form>
                        <form action="{{ route('products.destroy', $product) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus \'{{ $product->name }}\'? Tindakan ini tidak dapat dibatalkan.');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-4 py-2 bg-rose-600 hover:bg-rose-700 text-white rounded-xl font-bold text-xs transition duration-150">Hapus Barang</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
