@extends('layouts.mainlayout')

@section('title', 'Profil Saya')

@section('content')
<div class="max-w-4xl mx-auto py-10 px-4">

    {{-- Page Title --}}
    <h1 class="text-3xl font-bold text-[#184d2e] mb-6">Profil Anda</h1>

    {{-- Success / Error Alerts --}}
    @if(session('success'))
        <div class="bg-green-200 text-green-900 px-4 py-2 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-200 text-red-900 px-4 py-2 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    {{-- User Info Card --}}
    <div class="bg-white shadow-md rounded-lg p-6 mb-8">
        <h2 class="text-xl font-semibold text-[#184d2e] mb-3">Informasi Akun</h2>

        <p><strong>Nama:</strong> {{ $user->name }}</p>
        <p><strong>Email:</strong> {{ $user->email }}</p>
        <p><strong>Status:</strong> <span class="capitalize">{{ $user->status }}</span></p>
        <p><strong>Dibuat pada:</strong> {{ $user->created_at->format('d M Y, H:i') }}</p>
    </div>

    {{-- Update Name --}}
    <div class="bg-white shadow-md rounded-lg p-6 mb-8">
        <h2 class="text-xl font-semibold text-[#184d2e] mb-3">Ubah Username</h2>

        <form action="{{ route('user.updateName') }}" method="POST">
            @csrf

            <label class="block font-medium mb-2">Nama Baru</label>
            <input type="text" name="name" value="{{ $user->name }}"
                   class="w-full border rounded px-3 py-2 mb-4">

            <button class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                Simpan Perubahan
            </button>
        </form>
    </div>

    {{-- Update Password --}}
    <div class="bg-white shadow-md rounded-lg p-6 mb-8">
        <h2 class="text-xl font-semibold text-[#184d2e] mb-3">Ubah Password</h2>

        <form action="{{ route('user.updatePassword') }}" method="POST">
            @csrf

            <label class="block font-medium mb-2">Password Lama</label>
            <input type="password" name="current_password"
                   class="w-full border rounded px-3 py-2 mb-4">

            <label class="block font-medium mb-2">Password Baru</label>
            <input type="password" name="new_password"
                   class="w-full border rounded px-3 py-2 mb-4">

            <label class="block font-medium mb-2">Konfirmasi Password Baru</label>
            <input type="password" name="new_password_confirmation"
                   class="w-full border rounded px-3 py-2 mb-4">

            <button class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                Update Password
            </button>
        </form>
    </div>

    {{-- Delete Account --}}
    <div class="bg-red-100 shadow-md rounded-lg p-6">
        <h2 class="text-xl font-semibold text-red-700 mb-3">Hapus Akun</h2>

        <p class="mb-3">Aksi ini tidak dapat dibatalkan.</p>

        <form action="{{ route('user.destroy') }}" method="POST"
              onsubmit="return confirm('Yakin ingin menghapus akun?')">
            @csrf
            @method('DELETE')

            <button class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">
                Hapus Akun
            </button>
        </form>
    </div>

</div>
@endsection
