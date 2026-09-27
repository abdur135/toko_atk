@extends('layouts.app')

@section('title', 'Tambah Barang')
@section('page_title', 'Tambah Barang Baru')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="px-6 py-5 border-b border-slate-100 bg-gradient-to-r from-indigo-50 to-slate-50 flex items-center justify-between">
            <div>
                <h3 class="text-lg font-bold text-slate-800">Form Tambah Barang</h3>
                <p class="text-xs text-slate-400 mt-1">Lengkapi data alat tulis baru di bawah ini.</p>
            </div>
            <a href="{{ route('products.index') }}" class="text-xs font-semibold text-slate-500 hover:text-slate-800 transition duration-150">Kembali</a>
        </div>
        <div class="p-6">
            <form action="{{ route('products.store') }}" method="POST" class="space-y-6">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="code" class="block text-sm font-semibold text-slate-700 mb-1.5">Kode Barang <span class="text-rose-500">*</span></label>
                        <input type="text" name="code" id="code" value="{{ old('code') }}" required
                            class="block w-full px-4 py-3 bg-slate-50 border-2 rounded-xl text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition duration-150 text-sm @error('code') border-rose-300 bg-rose-50 @else border-slate-200 focus:border-indigo-500 @enderror"
                            placeholder="Contoh: BKP-001">
                        @error('code') <p class="text-xs text-rose-500 mt-1.5 font-medium">{{ $message }}</p> @enderror
                        @if(!$errors->has('code')) <p class="text-xs text-slate-400 mt-1.5">Gunakan kode unik untuk memudahkan identifikasi barang.</p> @endif
                    </div>
                    <div>
                        <label for="name" class="block text-sm font-semibold text-slate-700 mb-1.5">Nama Barang <span class="text-rose-500">*</span></label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" required
                            class="block w-full px-4 py-3 bg-slate-50 border-2 rounded-xl text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition duration-150 text-sm @error('name') border-rose-300 bg-rose-50 @else border-slate-200 focus:border-indigo-500 @enderror"
                            placeholder="Contoh: Buku Tulis Sidu 40 Lembar">
                        @error('name') <p class="text-xs text-rose-500 mt-1.5 font-medium">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div>
                    <label for="category_id" class="block text-sm font-semibold text-slate-700 mb-1.5">Kategori <span class="text-rose-500">*</span></label>
                    <select name="category_id" id="category_id" required
                        class="block w-full px-4 py-3 bg-slate-50 border-2 rounded-xl text-slate-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition duration-150 text-sm @error('category_id') border-rose-300 bg-rose-50 @else border-slate-200 focus:border-indigo-500 @enderror">
                        <option value="">-- Pilih Kategori --</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }} ({{ $category->products_count ?? 0 }} produk)
                            </option>
                        @endforeach
                    </select>
                    @error('category_id') <p class="text-xs text-rose-500 mt-1.5 font-medium">{{ $message }}</p> @enderror
                    @if($categories->isEmpty())
                        <p class="text-xs text-amber-500 mt-1.5">
                            Belum ada kategori. <a href="{{ route('categories.create') }}" class="font-bold underline">Buat kategori baru</a> terlebih dahulu.
                        </p>
                    @endif
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="price" class="block text-sm font-semibold text-slate-700 mb-1.5">Harga (Rp) <span class="text-rose-500">*</span></label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400 font-semibold text-sm">Rp</span>
                            <input type="number" name="price" id="price" value="{{ old('price') }}" required min="0"
                                class="block w-full pl-10 pr-4 py-3 bg-slate-50 border-2 rounded-xl text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition duration-150 text-sm @error('price') border-rose-300 bg-rose-50 @else border-slate-200 focus:border-indigo-500 @enderror"
                                placeholder="5000">
                        </div>
                        @error('price') <p class="text-xs text-rose-500 mt-1.5 font-medium">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="stock" class="block text-sm font-semibold text-slate-700 mb-1.5">Stok Awal <span class="text-rose-500">*</span></label>
                        <input type="number" name="stock" id="stock" value="{{ old('stock', 0) }}" required min="0"
                            class="block w-full px-4 py-3 bg-slate-50 border-2 rounded-xl text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition duration-150 text-sm @error('stock') border-rose-300 bg-rose-50 @else border-slate-200 focus:border-indigo-500 @enderror">
                        @error('stock') <p class="text-xs text-rose-500 mt-1.5 font-medium">{{ $message }}</p> @enderror
                        @if(!$errors->has('stock')) <p class="text-xs text-slate-400 mt-1.5">Jumlah stok awal dapat diubah nanti melalui mutasi stok.</p> @endif
                    </div>
                </div>

                <div>
                    <label for="description" class="block text-sm font-semibold text-slate-700 mb-1.5">Deskripsi <span class="text-slate-400 font-normal">(opsional)</span></label>
                    <textarea name="description" id="description" rows="3"
                        class="block w-full px-4 py-3 bg-slate-50 border-2 border-slate-200 rounded-xl text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-150 text-sm"
                        placeholder="Deskripsi tambahan tentang barang, misalnya merek, varian, atau ukuran.">{{ old('description') }}</textarea>
                    @error('description') <p class="text-xs text-rose-500 mt-1.5 font-medium">{{ $message }}</p> @enderror
                </div>

                <div class="bg-slate-50 rounded-xl p-4 border border-slate-100">
                    <h4 class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Ringkasan</h4>
                    <div class="text-xs text-slate-500 space-y-1" id="summary">
                        <p>Kode unik akan digunakan sebagai identitas barang.</p>
                        <p>Kategori wajib dipilih untuk pengelompokan yang rapi.</p>
                        <p>Harga dan stok awal dapat disesuaikan kapan saja.</p>
                    </div>
                </div>

                <div class="flex items-center justify-end gap-3 border-t border-slate-100 pt-6">
                    <a href="{{ route('products.index') }}" class="px-5 py-2.5 text-sm font-bold text-slate-500 hover:text-slate-800 transition duration-150">Batal</a>
                    <button type="submit" class="px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl font-bold text-sm shadow-lg shadow-indigo-600/20 transition duration-150">Simpan Barang</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
