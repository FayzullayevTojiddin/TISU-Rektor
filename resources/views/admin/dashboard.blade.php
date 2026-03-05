@extends('layouts.admin')

@section('title', 'Dashboard')
@section('header', 'Dashboard')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="bg-white rounded-xl border border-gray-200 p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500">Jami murojaatlar</p>
                <p class="text-3xl font-bold text-gray-900 mt-1">{{ $totalMessages }}</p>
            </div>
            <div class="w-12 h-12 bg-blue-50 rounded-lg flex items-center justify-center">
                <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl border border-gray-200 p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500">Kutilmoqda</p>
                <p class="text-3xl font-bold text-orange-600 mt-1">{{ $pendingMessages }}</p>
            </div>
            <div class="w-12 h-12 bg-orange-50 rounded-lg flex items-center justify-center">
                <svg class="w-6 h-6 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl border border-gray-200 p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500">Javob berilgan</p>
                <p class="text-3xl font-bold text-green-600 mt-1">{{ $answeredMessages }}</p>
            </div>
            <div class="w-12 h-12 bg-green-50 rounded-lg flex items-center justify-center">
                <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl border border-gray-200 p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500">Bugungi xabarlar</p>
                <p class="text-3xl font-bold text-purple-600 mt-1">{{ $todayMessages }}</p>
            </div>
            <div class="w-12 h-12 bg-purple-50 rounded-lg flex items-center justify-center">
                <svg class="w-6 h-6 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
    <div class="bg-white rounded-xl border border-gray-200 p-6">
        <h3 class="text-sm font-medium text-gray-500 mb-4">Turi bo'yicha</h3>
        <div class="space-y-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-3 h-3 bg-blue-500 rounded-full"></div>
                    <span class="text-sm text-gray-700">Murojaatlar</span>
                </div>
                <span class="text-sm font-semibold text-gray-900">{{ $totalMurojaat }}</span>
            </div>
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-3 h-3 bg-red-500 rounded-full"></div>
                    <span class="text-sm text-gray-700">Shikoyatlar</span>
                </div>
                <span class="text-sm font-semibold text-gray-900">{{ $totalShikoyat }}</span>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl border border-gray-200 p-6">
        <h3 class="text-sm font-medium text-gray-500 mb-4">Foydalanuvchilar</h3>
        <p class="text-3xl font-bold text-gray-900">{{ $totalUsers }}</p>
        <p class="text-sm text-gray-500 mt-1">Ro'yxatdan o'tgan talabalar</p>
    </div>

    <div class="bg-white rounded-xl border border-gray-200 p-6">
        <h3 class="text-sm font-medium text-gray-500 mb-4">Javob berish ko'rsatkichi</h3>
        @php $rate = $totalMessages > 0 ? round(($answeredMessages / $totalMessages) * 100) : 0; @endphp
        <p class="text-3xl font-bold text-gray-900">{{ $rate }}%</p>
        <div class="w-full bg-gray-200 rounded-full h-2 mt-3">
            <div class="bg-green-500 h-2 rounded-full transition-all" style="width: {{ $rate }}%"></div>
        </div>
    </div>
</div>

<div class="bg-white rounded-xl border border-gray-200">
    <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
        <h3 class="font-semibold text-gray-800">Oxirgi murojaatlar</h3>
        <a href="{{ route('admin.messages.index') }}" class="text-sm text-blue-600 hover:text-blue-800 transition">
            Hammasini ko'rish →
        </a>
    </div>

    @if($recentMessages->isEmpty())
        <div class="px-6 py-12 text-center text-gray-400">
            Hali hech qanday murojaat yo'q
        </div>
    @else
        <div class="divide-y divide-gray-100">
            @foreach($recentMessages as $message)
                <a href="{{ route('admin.messages.show', $message) }}" class="flex items-center gap-4 px-6 py-4 hover:bg-gray-50 transition">
                    <div class="flex-shrink-0">
                        @if($message->status === 'kutilmoqda')
                            <div class="w-2.5 h-2.5 bg-orange-400 rounded-full"></div>
                        @elseif($message->status === 'korildi')
                            <div class="w-2.5 h-2.5 bg-blue-400 rounded-full"></div>
                        @else
                            <div class="w-2.5 h-2.5 bg-green-400 rounded-full"></div>
                        @endif
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center gap-2">
                            <span class="text-sm font-medium text-gray-900">{{ $message->writer?->name ?? 'Noma\'lum' }}</span>
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium {{ $message->type === 'shikoyat' ? 'bg-red-50 text-red-700' : 'bg-blue-50 text-blue-700' }}">
                                {{ $message->type === 'shikoyat' ? 'Shikoyat' : 'Murojaat' }}
                            </span>
                        </div>
                        <p class="text-sm text-gray-500 truncate mt-0.5">{{ $message->message }}</p>
                    </div>
                    <div class="flex-shrink-0 text-xs text-gray-400">
                        {{ $message->writed_at?->format('d.m.Y H:i') }}
                    </div>
                </a>
            @endforeach
        </div>
    @endif
</div>
@endsection
