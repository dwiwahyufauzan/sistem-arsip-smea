<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Kepala Sekolah - Sistem Arsip SMKN 1 Subang</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-900 text-slate-100 min-h-screen">
    <div class="max-w-7xl mx-auto p-6">
        <div class="flex items-center justify-between pb-6 border-b border-slate-800">
            <div>
                <h1 class="text-2xl font-bold text-white">Dashboard Kepala Sekolah (Pimpinan)</h1>
                <p class="text-slate-400 text-sm">Selamat datang, {{ auth()->user()->name }} ({{ auth()->user()->role_badge }})</p>
            </div>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="px-4 py-2 bg-rose-600 hover:bg-rose-500 rounded-xl text-sm font-semibold transition-all">Keluar</button>
            </form>
        </div>
        <div class="mt-6 p-4 rounded-xl bg-slate-800 border border-slate-700">
            <p class="text-emerald-400 font-medium">Autentikasi role Kepala Sekolah berhasil diverifikasi.</p>
        </div>
    </div>
</body>
</html>
