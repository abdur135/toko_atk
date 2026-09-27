@extends('layouts.app')

@section('title', 'Catat Mutasi Stok')
@section('page_title', 'Mutasi Stok Barang')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <!-- Header Form -->
        <div class="px-6 py-5 border-b border-slate-100 bg-slate-50 flex items-center justify-between">
            <div>
                <h3 class="text-lg font-bold text-slate-800">Form Catat Mutasi Stok</h3>
                <p class="text-xs text-slate-400 mt-1">Tambahkan stok masuk dari supplier atau kurangi stok keluar karena penjualan/rusak.</p>
            </div>
            <a href="{{ route('dashboard') }}" class="text-xs font-semibold text-slate-500 hover:text-slate-800 transition duration-150">Kembali</a>
        </div>

        <!-- Body Form -->
        <div class="p-6">
            <form action="{{ route('stocks.store') }}" method="POST" class="space-y-6">
                @csrf

                <!-- Pilih Barang -->
                <div>
                    <label for="product_id" class="block text-sm font-semibold text-slate-700 mb-1.5">Pilih Alat Tulis / Barang</label>
                    <div class="relative">
                        <select name="product_id" id="product_id" required
                            class="block w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm transition duration-150">
                            <option value="">-- Pilih Barang --</option>
                            @foreach($products as $product)
                                <option value="{{ $product->id }}" {{ old('product_id') == $product->id ? 'selected' : '' }}>
                                    {{ $product->code }} - {{ $product->name }} (Stok saat ini: {{ $product->stock }} unit)
                                </option>
                            @endforeach
                        </select>
                    </div>
                    @error('product_id')
                        <p class="text-xs text-rose-500 mt-1 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Jenis Mutasi -->
                    <div>
                        <label for="type" class="block text-sm font-semibold text-slate-700 mb-1.5">Jenis Transaksi</label>
                        <div class="grid grid-cols-2 gap-4">
                            <label class="flex items-center justify-center p-3 border border-slate-200 bg-slate-50 rounded-xl cursor-pointer hover:bg-slate-100 transition duration-150 [&:has(input:checked)]:border-indigo-600 [&:has(input:checked)]:bg-indigo-50 [&:has(input:checked)]:text-indigo-700">
                                <input type="radio" name="type" value="in" class="sr-only" required {{ old('type', 'in') == 'in' ? 'checked' : '' }}>
                                <svg class="w-4 h-4 mr-2 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 13l-7 7-7-7m14-6l-7 7-7-7"></path>
                                </svg>
                                <span class="text-sm font-bold">Barang Masuk</span>
                            </label>
                            <label class="flex items-center justify-center p-3 border border-slate-200 bg-slate-50 rounded-xl cursor-pointer hover:bg-slate-100 transition duration-150 [&:has(input:checked)]:border-indigo-600 [&:has(input:checked)]:bg-indigo-50 [&:has(input:checked)]:text-indigo-700">
                                <input type="radio" name="type" value="out" class="sr-only" required {{ old('type') == 'out' ? 'checked' : '' }}>
                                <svg class="w-4 h-4 mr-2 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 11l7-7 7 7M5 19l7-7 7 7"></path>
                                </svg>
                                <span class="text-sm font-bold">Barang Keluar</span>
                            </label>
                        </div>
                        @error('type')
                            <p class="text-xs text-rose-500 mt-1 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Jumlah / Quantity -->
                    <div>
                        <label for="quantity" class="block text-sm font-semibold text-slate-700 mb-1.5">Jumlah (Unit)</label>
                        <input type="number" name="quantity" id="quantity" value="{{ old('quantity') }}" required min="1"
                            class="block w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm transition duration-150"
                            placeholder="Contoh: 15">
                        @error('quantity')
                            <p class="text-xs text-rose-500 mt-1 font-medium">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Tanggal Mutasi -->
                <div>
                    <label for="date" class="block text-sm font-semibold text-slate-700 mb-1.5">Tanggal Mutasi</label>
                    <input type="date" name="date" id="date" value="{{ old('date', date('Y-m-d')) }}" required
                        class="block w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm transition duration-150">
                    @error('date')
                        <p class="text-xs text-rose-500 mt-1 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Keterangan / Notes -->
                <div>
                    <label for="notes" class="block text-sm font-semibold text-slate-700 mb-1.5">Keterangan / Catatan Tambahan (Opsional)</label>
                    <textarea name="notes" id="notes" rows="3"
                        class="block w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm transition duration-150"
                        placeholder="Masukkan alasan mutasi (misal: 'Restock dari distributor Jaya', 'Barang rusak/pecah', dll)">{{ old('notes') }}</textarea>
                    @error('notes')
                        <p class="text-xs text-rose-500 mt-1 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Action Buttons -->
                <div class="flex items-center justify-end gap-3 border-t border-slate-100 pt-6">
                    <button type="reset" class="px-5 py-2.5 text-sm font-bold text-slate-500 hover:text-slate-800 transition duration-150">Reset</button>
                    <button type="submit"
                        class="px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl font-bold text-sm shadow-md shadow-indigo-600/10 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition duration-150">
                        Simpan Transaksi Mutasi
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
