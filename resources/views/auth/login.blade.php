<!DOCTYPE html>
<html lang="uz">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kirish — TISU Rektor</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#0a0e1a] min-h-screen flex items-center justify-center p-4">

<div class="w-full max-w-md">
    <div class="text-center mb-8">
        <h1 class="text-3xl font-bold text-white">TISU Rektor</h1>
        <p class="text-gray-500 mt-2">Boshqaruv paneliga kirish</p>
    </div>

    <div class="bg-[#111827] rounded-2xl border border-gray-800 p-8">
        @if($errors->any())
            <div class="mb-6 bg-red-500/10 border border-red-500/20 text-red-400 px-4 py-3 rounded-lg text-sm">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('login') }}" method="POST" class="space-y-5">
            @csrf

            <div>
                <label for="email" class="block text-sm font-medium text-gray-400 mb-1.5">Email</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" required autofocus
                       class="w-full px-4 py-2.5 bg-[#0a0e1a] border border-gray-700 rounded-lg text-white placeholder-gray-600 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition text-sm">
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-gray-400 mb-1.5">Parol</label>
                <input type="password" name="password" id="password" required
                       class="w-full px-4 py-2.5 bg-[#0a0e1a] border border-gray-700 rounded-lg text-white placeholder-gray-600 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition text-sm">
            </div>

            <button type="submit"
                    class="w-full bg-indigo-600 hover:bg-indigo-500 text-white font-medium py-2.5 px-4 rounded-lg transition text-sm">
                Kirish
            </button>
        </form>
    </div>
</div>

</body>
</html>
