@extends('layouts.app')

@section('title', 'Detail Pengguna')
@section('page_title', 'Detail Pengguna')

@section('content')
<div class="space-y-6">
    <div class="max-w-3xl mx-auto">
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
            <div class="px-6 py-5 border-b border-slate-100 bg-gradient-to-r from-indigo-50 to-slate-50 flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <div class="w-14 h-14 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center font-bold text-xl">
                        {{ strtoupper(substr($user->name, 0, 2)) }}
                    </div>
                    <div>
                        <div class="flex items-center gap-2">
                            <h3 class="text-xl font-bold text-slate-800">{{ $user->name }}</h3>
                            @if(auth()->id() === $user->id)
                                <span class="px-2 py-0.5 text-[10px] font-bold bg-indigo-100 text-indigo-600 rounded-full">Anda</span>
                            @endif
                        </div>
                        <p class="text-xs text-slate-400 mt-0.5">{{ $user->email }}</p>
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    <a href="{{ route('users.edit', $user) }}" class="px-4 py-2 bg-amber-600 hover:bg-amber-700 text-white rounded-xl font-bold text-xs transition duration-150 flex items-center">
                        <svg class="w-3.5 h-3.5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                        Edit
                    </a>
                    <a href="{{ route('users.index') }}" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-xl font-bold text-xs transition duration-150">Kembali</a>
                </div>
            </div>

            <div class="p-6 space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="bg-slate-50 rounded-xl p-5 text-center">
                        <span class="text-xs font-semibold text-slate-400 uppercase">Role</span>
                        <h4 class="mt-2">
                            @if($user->role === 'admin')
                                <span class="inline-flex items-center px-4 py-1.5 rounded-full text-sm font-bold bg-indigo-50 text-indigo-600">
                                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    Admin
                                </span>
                            @else
                                <span class="inline-flex items-center px-4 py-1.5 rounded-full text-sm font-bold bg-slate-100 text-slate-600">
                                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                    Staff
                                </span>
                            @endif
                        </h4>
                    </div>
                    <div class="bg-slate-50 rounded-xl p-5 text-center">
                        <span class="text-xs font-semibold text-slate-400 uppercase">Bergabung Sejak</span>
                        <h4 class="text-lg font-extrabold text-slate-800 mt-2">{{ $user->created_at->isoFormat('D MMMM YYYY') }}</h4>
                        <p class="text-xs text-slate-400 mt-1">{{ $user->created_at->isoFormat('HH:mm') }} WIB</p>
                    </div>
                    <div class="bg-slate-50 rounded-xl p-5 text-center">
                        <span class="text-xs font-semibold text-slate-400 uppercase">Terakhir Diperbarui</span>
                        <h4 class="text-lg font-extrabold text-slate-800 mt-2">{{ $user->updated_at->isoFormat('D MMMM YYYY') }}</h4>
                        <p class="text-xs text-slate-400 mt-1">{{ $user->updated_at->isoFormat('HH:mm') }} WIB</p>
                    </div>
                </div>

                <div class="border-t border-slate-100 pt-6 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <form action="{{ route('users.edit', $user) }}" method="GET">
                            <button type="submit" class="px-4 py-2 bg-amber-600 hover:bg-amber-700 text-white rounded-xl font-bold text-xs transition duration-150">Edit Pengguna</button>
                        </form>
                        @if(auth()->id() !== $user->id)
                            <form action="{{ route('users.destroy', $user) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus pengguna \'{{ $user->name }}\'? Tindakan ini tidak dapat dibatalkan.');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-4 py-2 bg-rose-600 hover:bg-rose-700 text-white rounded-xl font-bold text-xs transition duration-150">Hapus Pengguna</button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
