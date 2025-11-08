<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Presensi Siswa</title>
</head>
<body class="bg-gray-100 min-h-screen">
    <nav class="bg-blue-600 text-white p-4">
        <div class="container mx-auto flex justify-between items-center">
            <h1 class="text-xl font-bold">Presensi Siswa</h1>
            <div class="flex items-center space-x-4">
                <span>Halo, {{ Auth::user()->name }}</span>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="bg-blue-800 hover:bg-blue-900 text-white py-1 px-3 rounded">
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <div class="container mx-auto p-4">
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-2xl font-bold mb-4">
                @if (Auth::user()->role === 'admin')
                    Dashboard Admin 👑
                @else
                    Dashboard Siswa 🧑‍💼
                @endif
            </h2>
            <p class="mb-4">Selamat datang di presensi siswa.</p>
                
                <div class="bg-green-100 p-4 rounded-lg">
                    <h3 class="text-lg font-semibold mb-2">Menu Utama</h3>
                    <div class="space-y-2">

                        @if (Auth::user()->role === 'admin')
                            <a href="{{ route('siswa.index') }}" 
                               class="block bg-red-600 hover:bg-red-700 text-white font-semibold py-2 px-4 rounded-lg shadow">
                                ⚙️ Data Siswa (Admin Penuh)
    
                            <a href="{{ route('presensi.index') }}" 
                               class="block bg-yellow-600 hover:bg-yellow-700 text-white font-semibold py-2 px-4 rounded-lg shadow">
                                ✅ Presensi Siswa
                            </a>

                            @else (Auth::user()->role === 'user')
                            <a href="{{ route('presensi.index') }}" 
                               class="block bg-yellow-600 hover:bg-yellow-700 text-white font-semibold py-2 px-4 rounded-lg shadow">
                                ✅ Presensi Siswa
                            </a>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>