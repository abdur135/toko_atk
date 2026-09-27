@extends('layouts.app')

@section('title', 'Edit Pengguna')
@section('page_title', 'Edit Pengguna')

@section('content')
<div class="max-w-xl mx-auto">
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="px-6 py-5 border-b border-slate-100 bg-gradient-to-r from-amber-50 to-slate-50 flex items-center justify-between">
            <div>
                <h3 class="text-lg font-bold text-slate-800">Edit Pengguna</h3>
                <p class="text-xs text-slate-400 mt-1">Perbarui data pengguna <span class="font-semibold text-slate-600">"{{ $user->name }}"</span>.</p>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('users.show', $user) }}" class="text-xs font-semibold text-indigo-600 hover:text-indigo-800 transition duration-150 flex items-center">
                    <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                    Lihat Detail
                </a>
                <a href="{{ route('users.index') }}" class="text-xs font-semibold text-slate-500 hover:text-slate-800 transition duration-150">Kembali</a>
            </div>
        </div>
        <div class="p-6">
            <form action="{{ route('users.update', $user) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')
                <div>
                    <label for="name" class="block text-sm font-semibold text-slate-700 mb-1.5">Nama Lengkap <span class="text-rose-500">*</span></label>
                    <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" required autofocus
                        class="block w-full px-4 py-3 bg-slate-50 border-2 rounded-xl text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition duration-150 text-sm @error('name') border-rose-300 bg-rose-50 @else border-slate-200 focus:border-indigo-500 @enderror">
                    @error('name') <p class="text-xs text-rose-500 mt-1.5 font-medium">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="email" class="block text-sm font-semibold text-slate-700 mb-1.5">Alamat Email <span class="text-rose-500">*</span></label>
                    <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" required
                        class="block w-full px-4 py-3 bg-slate-50 border-2 rounded-xl text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition duration-150 text-sm @error('email') border-rose-300 bg-rose-50 @else border-slate-200 focus:border-indigo-500 @enderror">
                    @error('email') <p class="text-xs text-rose-500 mt-1.5 font-medium">{{ $message }}</p> @enderror
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="password" class="block text-sm font-semibold text-slate-700 mb-1.5">Kata Sandi Baru</label>
                        <input type="password" name="password" id="password"
                            class="block w-full px-4 py-3 bg-slate-50 border-2 border-slate-200 rounded-xl text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition duration-150 text-sm"
                            placeholder="Kosongkan jika tidak diubah">
                        @error('password') <p class="text-xs text-rose-500 mt-1.5 font-medium">{{ $message }}</p> @enderror
                        @if(!$errors->has('password')) <p class="text-xs text-slate-400 mt-1.5">Kosongkan jika tidak ingin mengubah kata sandi.</p> @endif
                    </div>
                    <div>
                        <label for="password_confirmation" class="block text-sm font-semibold text-slate-700 mb-1.5">Konfirmasi Sandi Baru</label>
                        <input type="password" name="password_confirmation" id="password_confirmation"
                            class="block w-full px-4 py-3 bg-slate-50 border-2 border-slate-200 rounded-xl text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition duration-150 text-sm">
                    </div>
                </div>
                <div>
                    <label for="role" class="block text-sm font-semibold text-slate-700 mb-1.5">Role / Hak Akses <span class="text-rose-500">*</span></label>
                    <div class="grid grid-cols-2 gap-4">
                        <label class="flex items-center justify-center p-3.5 border border-slate-200 bg-slate-50 rounded-xl cursor-pointer hover:bg-slate-100 transition duration-150 [&:has(input:checked)]:border-indigo-600 [&:has(input:checked)]:bg-indigo-50 [&:has(input:checked)]:text-indigo-700">
                            <input type="radio" name="role" value="staff" class="sr-only" required {{ (old('role', $user->role) == 'staff') ? 'checked' : '' }}>
                            <svg class="w-4 h-4 mr-2 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                            <span class="text-sm font-bold">Staff</span>
                        </label>
                        <label class="flex items-center justify-center p-3.5 border border-slate-200 bg-slate-50 rounded-xl cursor-pointer hover:bg-slate-100 transition duration-150 [&:has(input:checked)]:border-indigo-600 [&:has(input:checked)]:bg-indigo-50 [&:has(input:checked)]:text-indigo-700">
                            <input type="radio" name="role" value="admin" class="sr-only" required {{ (old('role', $user->role) == 'admin') ? 'checked' : '' }}>
                            <svg class="w-4 h-4 mr-2 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <span class="text-sm font-bold">Admin</span>
                        </label>
                    </div>
                    @error('role') <p class="text-xs text-rose-500 mt-1.5 font-medium">{{ $message }}</p> @enderror
                </div>
                @if(auth()->id() === $user->id)
                    <div class="bg-amber-50 rounded-xl p-4 border border-amber-100">
                        <h4 class="text-xs font-bold text-amber-700 uppercase tracking-wider mb-2 flex items-center">
                            <svg class="w-3.5 h-3.5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            Perhatian
                        </h4>
                        <p class="text-xs text-amber-700">Anda sedang mengedit akun Anda sendiri. Hati-hati dalam mengubah role atau data login.</p>
                    </div>
                @endif
                <div class="flex items-center justify-end gap-3 border-t border-slate-100 pt-6">
                    <a href="{{ route('users.index') }}" class="px-5 py-2.5 text-sm font-bold text-slate-500 hover:text-slate-800 transition duration-150">Batal</a>
                    <button type="submit" class="px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl font-bold text-sm shadow-lg shadow-indigo-600/20 transition duration-150">Perbarui Pengguna</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
