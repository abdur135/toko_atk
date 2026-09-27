@extends('layouts.app')

@section('title', 'Persediaan Barang')
@section('page_title', 'Persediaan Barang')

@section('content')
<div class="space-y-6">
    <div class="grid grid-cols-1 md:grid-cols-4 gap-5">
        <div class="bg-white rounded-2xl p-5 border border-slate-100 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center text-xl font-bold">📦</div>
            <div>
                <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Barang</span>
                <h3 class="text-2xl font-extrabold text-slate-800 mt-0.5">{{ $totalItems }}</h3>
                <p class="text-xs text-slate-400 mt-0.5">Item terdaftar</p>
            </div>
        </div>
        <div class="bg-white rounded-2xl p-5 border border-slate-100 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-cyan-50 text-cyan-600 flex items-center justify-center text-xl font-bold">📊</div>
            <div>
                <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Stok</span>
                <h3 class="text-2xl font-extrabold text-slate-800 mt-0.5">{{ number_format($totalStock) }}</h3>
                <p class="text-xs text-slate-400 mt-0.5">Unit keseluruhan</p>
            </div>
        </div>
        <div class="bg-white rounded-2xl p-5 border border-slate-100 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-xl font-bold">📥</div>
            <div>
                <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Masuk</span>
                <h3 class="text-2xl font-extrabold text-slate-800 mt-0.5">{{ number_format($totalMasuk) }}</h3>
                <p class="text-xs text-slate-400 mt-0.5">Unit masuk</p>
            </div>
        </div>
        <div class="bg-white rounded-2xl p-5 border border-slate-100 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center text-xl font-bold">📤</div>
            <div>
                <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Keluar</span>
                <h3 class="text-2xl font-extrabold text-slate-800 mt-0.5">{{ number_format($totalKeluar) }}</h3>
                <p class="text-xs text-slate-400 mt-0.5">Unit keluar</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="px-6 py-5 border-b border-slate-100 flex items-center justify-between">
            <div>
                <h3 class="text-lg font-bold text-slate-800">Riwayat Mutasi Persediaan</h3>
                <p class="text-xs text-slate-400 mt-1">Daftar transaksi barang masuk dan keluar.</p>
            </div>
            <a href="{{ route('stocks.create') }}" class="px-4 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl font-bold text-sm shadow-md shadow-indigo-600/20 transition flex items-center gap-2">
                <span class="text-lg leading-none">+</span> Catat Mutasi Baru
            </a>
        </div>

        <div class="flex gap-1 px-6 pt-4 border-b border-slate-200">
            <button onclick="switchTab('semua')" id="tab-semua" class="tab-btn px-5 py-3 text-sm font-bold text-indigo-600 border-b-2 border-indigo-600 transition -mb-[1px]">Semua</button>
            <button onclick="switchTab('masuk')" id="tab-masuk" class="tab-btn px-5 py-3 text-sm font-semibold text-slate-500 hover:text-slate-800 transition border-b-2 border-transparent -mb-[1px]">Barang Masuk</button>
            <button onclick="switchTab('keluar')" id="tab-keluar" class="tab-btn px-5 py-3 text-sm font-semibold text-slate-500 hover:text-slate-800 transition border-b-2 border-transparent -mb-[1px]">Barang Keluar</button>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-100 text-xs font-bold text-slate-400 uppercase tracking-wider">
                        <th class="py-4 px-5">Tanggal</th>
                        <th class="py-4 px-5">Barang</th>
                        <th class="py-4 px-5">Kategori</th>
                        <th class="py-4 px-5 text-center">Jenis</th>
                        <th class="py-4 px-5 text-right">Jumlah</th>
                        <th class="py-4 px-5">Petugas</th>
                        <th class="py-4 px-5 text-center">Status Stok</th>
                        <th class="py-4 px-5">Keterangan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($mutations as $m)
                        <tr class="text-sm hover:bg-slate-50/70 transition duration-150 mutation-row" data-type="{{ $m->type }}">
                            <td class="py-4 px-5 font-semibold text-slate-600 whitespace-nowrap">{{ \Carbon\Carbon::parse($m->date)->isoFormat('D MMM YYYY') }}</td>
                            <td class="py-4 px-5">
                                <div>
                                    <a href="{{ route('products.show', $m->product) }}" class="font-bold text-slate-800 hover:text-indigo-600 transition">{{ $m->product->name }}</a>
                                    <span class="text-xs text-slate-400 block font-mono">{{ $m->product->code }}</span>
                                </div>
                            </td>
                            <td class="py-4 px-5 text-xs text-slate-500">{{ $m->product->category->name }}</td>
                            <td class="py-4 px-5 text-center">
                                @if($m->type === 'in')
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-emerald-50 text-emerald-600">
                                        <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 13l-7 7-7-7m14-6l-7 7-7-7"></path></svg>
                                        Masuk
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-rose-50 text-rose-600">
                                        <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 11l7-7 7 7M5 19l7-7 7 7"></path></svg>
                                        Keluar
                                    </span>
                                @endif
                            </td>
                            <td class="py-4 px-5 text-right font-extrabold text-slate-800">{{ number_format($m->quantity) }} <span class="text-xs font-medium text-slate-400">unit</span></td>
                            <td class="py-4 px-5">
                                <div class="flex items-center">
                                    <div class="w-7 h-7 rounded-full bg-slate-100 text-slate-600 flex items-center justify-center font-bold text-xs mr-2">{{ strtoupper(substr($m->user->name, 0, 1)) }}</div>
                                    <span class="text-slate-600">{{ $m->user->name }}</span>
                                </div>
                            </td>
                            <td class="py-4 px-5 text-center">
                                @php $stok = $m->product->stock; @endphp
                                @if($stok > 0)
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-emerald-50 text-emerald-600">
                                        <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full mr-1.5"></span>
                                        Tersedia ({{ $stok }})
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-rose-50 text-rose-600">
                                        <span class="w-1.5 h-1.5 bg-rose-500 rounded-full mr-1.5"></span>
                                        Tidak Tersedia
                                    </span>
                                @endif
                            </td>
                            <td class="py-4 px-5 text-xs text-slate-500 max-w-[180px] truncate" title="{{ $m->notes }}">{{ $m->notes ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="py-16 text-center">
                                <div class="w-16 h-16 bg-slate-50 text-slate-300 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path></svg>
                                </div>
                                <h4 class="text-base font-bold text-slate-700">Belum ada mutasi stok</h4>
                                <p class="text-sm text-slate-400 mt-1">Catat mutasi stok pertama untuk mulai melacak persediaan barang.</p>
                                <a href="{{ route('stocks.create') }}" class="inline-flex items-center mt-4 px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl font-bold text-sm shadow-md shadow-indigo-600/20 transition">
                                    <span class="text-lg leading-none mr-2">+</span> Catat Mutasi Baru
                                </a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($mutations->hasPages())
            <div class="px-5 py-4 border-t border-slate-100 bg-slate-50/50 flex items-center justify-between">
                <div class="flex items-center gap-1">
                    @if($mutations->onFirstPage())
                        <span class="px-3 py-1.5 bg-white border border-slate-200 rounded-lg font-bold text-slate-300 text-xs">←</span>
                    @else
                        <a href="{{ $mutations->previousPageUrl() }}" class="px-3 py-1.5 bg-white border border-slate-200 rounded-lg font-bold text-slate-600 hover:bg-slate-100 transition text-xs">←</a>
                    @endif
                    @foreach($mutations->getUrlRange(1, $mutations->lastPage()) as $page => $url)
                        @if($page == $mutations->currentPage())
                            <span class="px-3 py-1.5 bg-indigo-600 text-white rounded-lg font-bold text-xs">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}" class="px-3 py-1.5 bg-white border border-slate-200 rounded-lg font-bold text-slate-600 hover:bg-slate-100 transition text-xs">{{ $page }}</a>
                        @endif
                    @endforeach
                    @if($mutations->hasMorePages())
                        <a href="{{ $mutations->nextPageUrl() }}" class="px-3 py-1.5 bg-white border border-slate-200 rounded-lg font-bold text-slate-600 hover:bg-slate-100 transition text-xs">→</a>
                    @else
                        <span class="px-3 py-1.5 bg-white border border-slate-200 rounded-lg font-bold text-slate-300 text-xs">→</span>
                    @endif
                </div>
                <span class="text-xs text-slate-400">{{ $mutations->firstItem() }}-{{ $mutations->lastItem() }} dari {{ $mutations->total() }}</span>
            </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
function switchTab(tab) {
    document.querySelectorAll('.tab-btn').forEach(b => {
        b.classList.remove('text-indigo-600', 'border-indigo-600', 'font-bold');
        b.classList.add('text-slate-500', 'border-transparent', 'font-semibold');
    });
    const btn = document.getElementById('tab-' + tab);
    if (btn) {
        btn.classList.remove('text-slate-500', 'border-transparent', 'font-semibold');
        btn.classList.add('text-indigo-600', 'border-indigo-600', 'font-bold');
    }
    const typeMap = { 'semua': '', 'masuk': 'in', 'keluar': 'out' };
    const targetType = typeMap[tab];
    document.querySelectorAll('.mutation-row').forEach(row => {
        row.style.display = (!targetType || row.dataset.type === targetType) ? '' : 'none';
    });
}
</script>
@endpush
