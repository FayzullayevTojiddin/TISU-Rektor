<!DOCTYPE html>
<html lang="uz">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel') — TISU Rektor</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        dark: { 50: '#f8fafc', 100: '#f1f5f9', 200: '#e2e8f0', 300: '#94a3b8', 400: '#64748b', 500: '#475569', 600: '#334155', 700: '#1e293b', 800: '#1a1f2e', 900: '#111827', 950: '#0a0e1a' },
                        accent: { 400: '#818cf8', 500: '#6366f1', 600: '#4f46e5' }
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-dark-950 min-h-screen text-gray-200">

<div class="flex min-h-screen">
    <aside class="w-64 bg-dark-900 border-r border-dark-700/50 flex flex-col fixed h-full">
        <div class="px-6 py-5 border-b border-dark-700/50">
            <h1 class="text-lg font-bold tracking-wide text-white">TISU Rektor</h1>
            <p class="text-dark-400 text-xs mt-1">Boshqaruv paneli</p>
        </div>

        <nav class="flex-1 px-4 py-6 space-y-1">
            <a href="{{ route('admin.dashboard') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm transition
                      {{ request()->routeIs('admin.dashboard') ? 'bg-accent-600/20 text-accent-400 border border-accent-500/20' : 'text-dark-300 hover:bg-dark-800 hover:text-white border border-transparent' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                </svg>
                Dashboard
            </a>

            <a href="{{ route('admin.messages.index') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm transition
                      {{ request()->routeIs('admin.messages.*') && !request('status') ? 'bg-accent-600/20 text-accent-400 border border-accent-500/20' : 'text-dark-300 hover:bg-dark-800 hover:text-white border border-transparent' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
                Murojaatlar
                @php $pending = \App\Models\Message::where('status', 'kutilmoqda')->count(); @endphp
                @if($pending > 0)
                    <span class="ml-auto bg-red-500/90 text-white text-xs font-bold px-2 py-0.5 rounded-full">{{ $pending }}</span>
                @endif
            </a>

            <a href="{{ route('admin.messages.index', ['status' => 'kutilmoqda']) }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm transition pl-11
                      {{ request('status') === 'kutilmoqda' ? 'text-orange-400' : 'text-dark-400 hover:text-dark-200' }}">
                Yangi xabarlar
            </a>

            <a href="{{ route('admin.messages.index', ['status' => 'javob_berildi']) }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm transition pl-11
                      {{ request('status') === 'javob_berildi' ? 'text-green-400' : 'text-dark-400 hover:text-dark-200' }}">
                Javob berilganlar
            </a>
        </nav>

        <div class="px-4 py-4 border-t border-dark-700/50">
            <div class="flex items-center gap-3 px-3 py-2">
                <div class="w-8 h-8 bg-accent-600 rounded-full flex items-center justify-center text-sm font-bold text-white">
                    {{ mb_substr(auth()->user()->name, 0, 1) }}
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium truncate text-white">{{ auth()->user()->name }}</p>
                    <p class="text-xs text-dark-400 truncate">{{ auth()->user()->email }}</p>
                </div>
            </div>
            <form action="{{ route('logout') }}" method="POST" class="mt-2">
                @csrf
                <button type="submit" class="w-full flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-dark-400 hover:bg-dark-800 hover:text-red-400 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                    </svg>
                    Chiqish
                </button>
            </form>
        </div>
    </aside>

    <main class="flex-1 ml-64">
        <header class="bg-dark-900/80 backdrop-blur-sm border-b border-dark-700/50 px-8 py-4 sticky top-0 z-10">
            <h2 class="text-xl font-semibold text-white">@yield('header')</h2>
        </header>

        <div class="p-8">
            @if(session('success'))
                <div class="mb-6 bg-green-500/10 border border-green-500/20 text-green-400 px-4 py-3 rounded-lg text-sm">
                    {{ session('success') }}
                </div>
            @endif

            @yield('content')
        </div>
    </main>
</div>

</body>
</html>
