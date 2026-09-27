@extends('layouts.app')

@section('title', 'Tambah Kategori')
@section('page_title', 'Tambah Kategori Baru')

@section('content')
<div class="max-w-xl mx-auto">
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="px-6 py-5 border-b border-slate-100 bg-gradient-to-r from-indigo-50 to-slate-50 flex items-center justify-between">
            <div>
                <h3 class="text-lg font-bold text-slate-800">Form Tambah Kategori</h3>
                <p class="text-xs text-slate-400 mt-1">Buat kategori baru untuk pengelompokan barang.</p>
            </div>
            <a href="{{ route('categories.index') }}" class="text-xs font-semibold text-slate-500 hover:text-slate-800 transition duration-150">Kembali</a>
        </div>
        <div class="p-6">
            <form action="{{ route('categories.store') }}" method="POST" class="space-y-6">
                @csrf
                <div>
                    <label for="name" class="block text-sm font-semibold text-slate-700 mb-1.5">Nama Kategori</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" required autofocus
                        onkeyup="document.getElementById('slugPreview').textContent = this.value.toLowerCase().replace(/\s+/g, '-').replace(/[^a-z0-9-]/g, '')"
                        class="block w-full px-4 py-3 bg-slate-50 border-2 border-slate-200 rounded-xl text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm transition duration-150"
                        placeholder="Contoh: Pensil, Buku, Penghapus">
                    <p class="text-xs text-slate-400 mt-1.5 flex items-center">
                        <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Slug akan dibuat otomatis: <span id="slugPreview" class="font-mono text-indigo-600 ml-1">-</span>
                    </p>
                    @error('name')
                        <p class="text-xs text-rose-500 mt-1.5 font-medium flex items-center">
                            <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div class="bg-slate-50 rounded-xl p-4 border border-slate-100">
                    <h4 class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Tips</h4>
                    <ul class="text-xs text-slate-500 space-y-1">
                        <li class="flex items-start">
                            <svg class="w-3.5 h-3.5 text-emerald-500 mr-1.5 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            Gunakan nama yang singkat dan deskriptif, misalnya "Pensil", "Buku Tulis", "Spidol".
                        </li>
                        <li class="flex items-start">
                            <svg class="w-3.5 h-3.5 text-emerald-500 mr-1.5 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            Hindari duplikasi nama kategori agar tidak membingungkan.
                        </li>
                        <li class="flex items-start">
                            <svg class="w-3.5 h-3.5 text-emerald-500 mr-1.5 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            Kategori dapat diubah atau dihapus kapan saja melalui menu daftar kategori.
                        </li>
                    </ul>
                </div>

                <div class="flex items-center justify-end gap-3 border-t border-slate-100 pt-6">
                    <a href="{{ route('categories.index') }}" class="px-5 py-2.5 text-sm font-bold text-slate-500 hover:text-slate-800 transition duration-150">Batal</a>
                    <button type="submit" class="px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl font-bold text-sm shadow-lg shadow-indigo-600/20 transition duration-150">Simpan Kategori</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
