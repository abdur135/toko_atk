@extends('layouts.app')

@section('title', 'Edit Kategori')
@section('page_title', 'Edit Kategori')

@section('content')
<div class="max-w-xl mx-auto">
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="px-6 py-5 border-b border-slate-100 bg-gradient-to-r from-amber-50 to-slate-50 flex items-center justify-between">
            <div>
                <h3 class="text-lg font-bold text-slate-800">Edit Kategori</h3>
                <p class="text-xs text-slate-400 mt-1">Perbarui nama kategori <span class="font-semibold text-slate-600">"{{ $category->name }}"</span>.</p>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('categories.show', $category) }}" class="text-xs font-semibold text-indigo-600 hover:text-indigo-800 transition duration-150 flex items-center">
                    <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                    Lihat Detail
                </a>
                <a href="{{ route('categories.index') }}" class="text-xs font-semibold text-slate-500 hover:text-slate-800 transition duration-150">Kembali</a>
            </div>
        </div>
        <div class="p-6">
            <form action="{{ route('categories.update', $category) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')
                <div>
                    <label for="name" class="block text-sm font-semibold text-slate-700 mb-1.5">Nama Kategori</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $category->name) }}" required autofocus
                        class="block w-full px-4 py-3 bg-slate-50 border-2 border-slate-200 rounded-xl text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm transition duration-150
                        @error('name') border-rose-300 bg-rose-50 @enderror">
                    @error('name')
                        <p class="text-xs text-rose-500 mt-1.5 font-medium">{{ $message }}</p>
                    @enderror
                    @if(!$errors->has('name'))
                        <p class="text-xs text-slate-400 mt-1.5">
                            Slug saat ini: <span class="font-mono text-indigo-600">{{ $category->slug }}</span>
                        </p>
                    @endif
                </div>

                <div class="bg-amber-50 rounded-xl p-4 border border-amber-100">
                    <h4 class="text-xs font-bold text-amber-700 uppercase tracking-wider mb-2 flex items-center">
                        <svg class="w-3.5 h-3.5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Informasi
                    </h4>
                    <p class="text-xs text-amber-700">Mengubah nama kategori akan memperbarui slug secara otomatis. Pastikan tidak ada duplikasi nama dengan kategori lain.</p>
                </div>

                <div class="flex items-center justify-end gap-3 border-t border-slate-100 pt-6">
                    <a href="{{ route('categories.index') }}" class="px-5 py-2.5 text-sm font-bold text-slate-500 hover:text-slate-800 transition duration-150">Batal</a>
                    <button type="submit" class="px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl font-bold text-sm shadow-lg shadow-indigo-600/20 transition duration-150">Perbarui Kategori</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
