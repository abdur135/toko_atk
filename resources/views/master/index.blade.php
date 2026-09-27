@extends('layouts.app')

@section('title', 'Master Data')
@section('page_title', 'Master Data')

@section('content')
<div class="space-y-6">
    @php
        $typeIcons = [
            'kategori' => '📁',
            'barang' => '✏️',
            'pengguna' => '👤',
        ];
        $typeBadgeColors = [
            'kategori' => 'bg-indigo-50 text-indigo-600',
            'barang' => 'bg-emerald-50 text-emerald-600',
            'pengguna' => 'bg-amber-50 text-amber-600',
        ];
    @endphp

    <div class="grid grid-cols-1 md:grid-cols-4 gap-5">
        <div class="bg-white rounded-2xl p-5 border border-slate-100 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center text-xl font-bold">📦</div>
            <div>
                <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Kategori</span>
                <h3 class="text-2xl font-extrabold text-slate-800 mt-0.5">{{ $totalCategories }}</h3>
            </div>
        </div>
        <div class="bg-white rounded-2xl p-5 border border-slate-100 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-xl font-bold">✏️</div>
            <div>
                <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Barang</span>
                <h3 class="text-2xl font-extrabold text-slate-800 mt-0.5">{{ $totalProducts }}</h3>
            </div>
        </div>
        <div class="bg-white rounded-2xl p-5 border border-slate-100 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center text-xl font-bold">👥</div>
            <div>
                <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Pengguna</span>
                <h3 class="text-2xl font-extrabold text-slate-800 mt-0.5">{{ $totalUsers }}</h3>
            </div>
        </div>
        <div class="bg-white rounded-2xl p-5 border border-slate-100 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center text-xl font-bold">⚠️</div>
            <div>
                <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Stok Menipis</span>
                <h3 class="text-2xl font-extrabold text-rose-600 mt-0.5">{{ $lowStockCount }}</h3>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-4 flex flex-col md:flex-row gap-4 items-center justify-between">
        <form method="GET" action="{{ route('master.index') }}" class="flex items-center gap-3 w-full md:w-auto">
            <div class="relative flex-1 md:w-80">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </span>
                <input type="text" name="search" value="{{ $search }}" placeholder="Cari barang, kategori, atau pengguna..." class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
            </div>
            <select name="type" onchange="this.form.submit()" class="px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-600 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                <option value="">Semua Tipe</option>
                <option value="kategori" {{ $activeType == 'kategori' ? 'selected' : '' }}>Kategori</option>
                <option value="barang" {{ $activeType == 'barang' ? 'selected' : '' }}>Barang</option>
                <option value="pengguna" {{ $activeType == 'pengguna' ? 'selected' : '' }}>Pengguna</option>
            </select>
            @if($search || $activeType !== 'semua')
                <a href="{{ route('master.index') }}" class="px-4 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-xl font-bold text-sm transition">Reset</a>
            @endif
        </form>
        <div class="relative" id="tambahBaruDropdown">
            <button onclick="toggleTambahBaru()" class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl font-bold text-sm shadow-md shadow-indigo-600/20 transition flex items-center gap-2 whitespace-nowrap">
                <span class="text-lg leading-none">+</span> Tambah Baru
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
            </button>
            <div id="tambahBaruMenu" class="absolute right-0 mt-2 w-56 bg-white border border-slate-200 rounded-xl shadow-xl z-50 py-2 hidden">
                <a href="{{ route('categories.create') }}" class="flex items-center px-4 py-3 text-sm font-semibold text-slate-700 hover:bg-indigo-50 hover:text-indigo-600 transition">
                    <span class="mr-3 text-lg">📁</span> Kategori Baru
                </a>
                <a href="{{ route('products.create') }}" class="flex items-center px-4 py-3 text-sm font-semibold text-slate-700 hover:bg-indigo-50 hover:text-indigo-600 transition">
                    <span class="mr-3 text-lg">✏️</span> Barang Baru
                </a>
                <a href="{{ route('users.create') }}" class="flex items-center px-4 py-3 text-sm font-semibold text-slate-700 hover:bg-indigo-50 hover:text-indigo-600 transition">
                    <span class="mr-3 text-lg">👤</span> Pengguna Baru
                </a>
            </div>
        </div>
    </div>

    <div class="flex gap-1 mb-2 border-b border-slate-200">
        <a href="{{ route('master.index', array_merge(request()->except(['type', 'page']), ['type' => ''])) }}"
            class="px-5 py-3 text-sm font-bold {{ $activeType == 'semua' ? 'text-indigo-600 border-b-2 border-indigo-600' : 'text-slate-500 hover:text-slate-800' }} transition border-b-2 border-transparent -mb-[1px]">Semua</a>
        <a href="{{ route('master.index', array_merge(request()->except(['type', 'page']), ['type' => 'kategori'])) }}"
            class="px-5 py-3 text-sm font-bold {{ $activeType == 'kategori' ? 'text-indigo-600 border-b-2 border-indigo-600' : 'text-slate-500 hover:text-slate-800' }} transition border-b-2 border-transparent -mb-[1px]">Kategori</a>
        <a href="{{ route('master.index', array_merge(request()->except(['type', 'page']), ['type' => 'barang'])) }}"
            class="px-5 py-3 text-sm font-bold {{ $activeType == 'barang' ? 'text-indigo-600 border-b-2 border-indigo-600' : 'text-slate-500 hover:text-slate-800' }} transition border-b-2 border-transparent -mb-[1px]">Barang</a>
        <a href="{{ route('master.index', array_merge(request()->except(['type', 'page']), ['type' => 'pengguna'])) }}"
            class="px-5 py-3 text-sm font-bold {{ $activeType == 'pengguna' ? 'text-indigo-600 border-b-2 border-indigo-600' : 'text-slate-500 hover:text-slate-800' }} transition border-b-2 border-transparent -mb-[1px]">Pengguna</a>
    </div>

    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
        <form id="batchForm" method="POST" action="{{ route('master.batch-delete') }}" onsubmit="return confirm('Yakin ingin menghapus data terpilih?')">
            @csrf
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-100 text-xs font-bold text-slate-400 uppercase tracking-wider">
                            <th class="py-4 px-5 w-12">
                                <input type="checkbox" id="selectAll" class="rounded border-slate-300">
                            </th>
                            <th class="py-4 px-5">Tipe</th>
                            <th class="py-4 px-5">Nama / Identitas</th>
                            <th class="py-4 px-5">Informasi</th>
                            <th class="py-4 px-5">Status</th>
                            <th class="py-4 px-5">Dibuat</th>
                            <th class="py-4 px-5 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($masterData as $item)
                            <tr class="text-sm hover:bg-slate-50/70 transition duration-150">
                                <td class="py-4 px-5">
                                    <input type="checkbox" name="ids[]" value="{{ $item->id }}" class="row-checkbox rounded border-slate-300">
                                </td>
                                <td class="py-4 px-5">
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold {{ $typeBadgeColors[$item->type] ?? 'bg-slate-50 text-slate-600' }}">
                                        {{ $typeIcons[$item->type] ?? '' }} {{ $item->type_label }}
                                    </span>
                                </td>
                                <td class="py-4 px-5">
                                    <div class="flex items-center gap-3">
                                        <div class="w-9 h-9 rounded-lg flex items-center justify-center font-bold text-xs flex-shrink-0
                                            @if($item->type === 'kategori') bg-indigo-100 text-indigo-600 rounded-lg
                                            @elseif($item->type === 'barang') {{ $item->status_color === 'rose' ? 'bg-rose-100 text-rose-600' : ($item->status_color === 'amber' ? 'bg-amber-100 text-amber-600' : 'bg-emerald-100 text-emerald-600') }} rounded-lg
                                            @else bg-amber-100 text-amber-600 rounded-full
                                            @endif">
                                            {{ $item->avatar }}
                                        </div>
                                        <div>
                                            <a href="{{ $item->route_show }}" class="font-bold text-slate-800 hover:text-indigo-600 transition">{{ $item->name }}</a>
                                            <span class="text-xs text-slate-400 block font-mono">{{ $item->identifier }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-4 px-5 text-xs text-slate-500">{{ $item->info }}</td>
                                <td class="py-4 px-5">
                                    @php
                                        $sc = $item->status_color;
                                    @endphp
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold
                                        @if($sc === 'emerald') bg-emerald-50 text-emerald-600
                                        @elseif($sc === 'amber') bg-amber-50 text-amber-600
                                        @else bg-rose-50 text-rose-600 @endif">
                                        <span class="w-1.5 h-1.5 rounded-full mr-1.5
                                            @if($sc === 'emerald') bg-emerald-500
                                            @elseif($sc === 'amber') bg-amber-500
                                            @else bg-rose-500 @endif">
                                        </span>
                                        {{ $item->status }}
                                        @if($item->stock !== null)
                                            <span class="ml-1 font-normal">({{ $item->stock }})</span>
                                        @endif
                                    </span>
                                </td>
                                <td class="py-4 px-5 text-xs text-slate-400">{{ $item->created_at->isoFormat('D MMM YYYY') }}</td>
                                <td class="py-4 px-5 text-right">
                                    <div class="flex items-center justify-end gap-1">
                                        <a href="{{ $item->route_edit }}" class="px-3 py-1.5 text-xs font-bold text-indigo-600 hover:bg-indigo-50 rounded-lg transition flex items-center gap-1">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                            Edit
                                        </a>
                                        @if(!isset($item->is_self) || !$item->is_self)
                                            <form action="{{ $item->route_destroy }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus?')" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="px-3 py-1.5 text-xs font-bold text-rose-600 hover:bg-rose-50 rounded-lg transition flex items-center gap-1">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                    Hapus
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="py-16 text-center">
                                    <div class="w-16 h-16 bg-slate-50 text-slate-300 rounded-full flex items-center justify-center mx-auto mb-4">
                                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                                    </div>
                                    <h4 class="text-base font-bold text-slate-700">Tidak ada data ditemukan</h4>
                                    <p class="text-sm text-slate-400 mt-1">Coba ubah kata kunci pencarian atau filter tipe.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="px-5 py-4 border-t border-slate-100 bg-slate-50/50 flex items-center justify-between text-xs text-slate-500">
                <div class="flex items-center gap-4">
                    <span><span id="selectedCount" class="font-semibold text-slate-700">0</span> item dipilih</span>
                    <button type="submit" id="batchDeleteBtn" disabled class="font-semibold text-rose-600 hover:text-rose-700 hover:bg-rose-50 px-3 py-1.5 rounded-lg transition disabled:opacity-40 disabled:cursor-not-allowed">
                        Hapus Terpilih
                    </button>
                </div>
                @if($masterData->hasPages())
                    <div class="flex items-center gap-3">
                        <span class="text-slate-400">Menampilkan {{ $masterData->firstItem() }}-{{ $masterData->lastItem() }} dari {{ $masterData->total() }}</span>
                        <div class="flex gap-1">
                            @if($masterData->onFirstPage())
                                <span class="px-3 py-1.5 bg-white border border-slate-200 rounded-lg font-bold text-slate-300 text-xs">←</span>
                            @else
                                <a href="{{ $masterData->previousPageUrl() }}" class="px-3 py-1.5 bg-white border border-slate-200 rounded-lg font-bold text-slate-600 hover:bg-slate-100 transition text-xs">←</a>
                            @endif
                            @foreach($masterData->getUrlRange(1, $masterData->lastPage()) as $page => $url)
                                @if($page == $masterData->currentPage())
                                    <span class="px-3 py-1.5 bg-indigo-600 text-white rounded-lg font-bold text-xs">{{ $page }}</span>
                                @else
                                    <a href="{{ $url }}" class="px-3 py-1.5 bg-white border border-slate-200 rounded-lg font-bold text-slate-600 hover:bg-slate-100 transition text-xs">{{ $page }}</a>
                                @endif
                            @endforeach
                            @if($masterData->hasMorePages())
                                <a href="{{ $masterData->nextPageUrl() }}" class="px-3 py-1.5 bg-white border border-slate-200 rounded-lg font-bold text-slate-600 hover:bg-slate-100 transition text-xs">→</a>
                            @else
                                <span class="px-3 py-1.5 bg-white border border-slate-200 rounded-lg font-bold text-slate-300 text-xs">→</span>
                            @endif
                        </div>
                    </div>
                @else
                    <span class="text-slate-400">Total {{ $masterData->total() }} data</span>
                @endif
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
function toggleTambahBaru() {
    const menu = document.getElementById('tambahBaruMenu');
    menu.classList.toggle('hidden');
}

document.addEventListener('click', function(e) {
    const dropdown = document.getElementById('tambahBaruDropdown');
    if (dropdown && !dropdown.contains(e.target)) {
        document.getElementById('tambahBaruMenu')?.classList.add('hidden');
    }
});

document.addEventListener('DOMContentLoaded', function() {
    const selectAll = document.getElementById('selectAll');
    const checkboxes = document.querySelectorAll('.row-checkbox');
    const selectedCount = document.getElementById('selectedCount');
    const batchBtn = document.getElementById('batchDeleteBtn');

    function updateSelected() {
        const checked = document.querySelectorAll('.row-checkbox:checked').length;
        selectedCount.textContent = checked;
        batchBtn.disabled = checked === 0;
    }

    selectAll.addEventListener('change', function() {
        checkboxes.forEach(cb => cb.checked = this.checked);
        updateSelected();
    });

    checkboxes.forEach(cb => {
        cb.addEventListener('change', updateSelected);
    });

    updateSelected();
});
</script>
@endpush
