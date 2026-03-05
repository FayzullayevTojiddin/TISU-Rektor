@extends('layouts.admin')

@section('title', 'Murojaat #' . $message->id)
@section('header', 'Murojaat #' . $message->id)

@section('content')
<div class="max-w-4xl">
    <a href="{{ route('admin.messages.index') }}" class="inline-flex items-center gap-2 text-sm text-dark-400 hover:text-white mb-6 transition">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
        </svg>
        Murojaatlarga qaytish
    </a>

    <div class="bg-dark-900 rounded-xl border border-dark-700/50 mb-6">
        <div class="px-6 py-4 border-b border-dark-700/50 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium {{ $message->type === 'shikoyat' ? 'bg-red-500/10 text-red-400 border border-red-500/20' : 'bg-indigo-500/10 text-indigo-400 border border-indigo-500/20' }}">
                    {{ $message->type === 'shikoyat' ? 'Shikoyat' : 'Murojaat' }}
                </span>
                @if($message->status === 'kutilmoqda')
                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-orange-500/10 text-orange-400 border border-orange-500/20">Kutilmoqda</span>
                @elseif($message->status === 'korildi')
                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-blue-500/10 text-blue-400 border border-blue-500/20">Ko'rildi</span>
                @else
                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">Javob berildi</span>
                @endif
            </div>
            <span class="text-sm text-dark-500">{{ $message->writed_at?->format('d.m.Y H:i') }}</span>
        </div>

        <div class="px-6 py-5">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                <div>
                    <p class="text-xs text-dark-500 mb-1">Yuboruvchi</p>
                    <p class="text-sm font-medium text-white">{{ $message->writer?->name ?? 'Noma\'lum' }}</p>
                </div>
                <div>
                    <p class="text-xs text-dark-500 mb-1">Guruh</p>
                    <p class="text-sm font-medium text-white">{{ $message->writer?->group ?? '—' }}</p>
                </div>
                <div>
                    <p class="text-xs text-dark-500 mb-1">Telefon</p>
                    <p class="text-sm font-medium text-white">{{ $message->writer?->phone ?? '—' }}</p>
                </div>
            </div>

            <div class="border-t border-dark-700/50 pt-5">
                <p class="text-xs text-dark-500 mb-2">Xabar matni</p>
                <div class="bg-dark-950 rounded-lg p-4 text-sm text-dark-200 leading-relaxed border border-dark-700/50">
                    {{ $message->message }}
                </div>
            </div>
        </div>
    </div>

    @if($message->response)
        <div class="bg-emerald-500/5 rounded-xl border border-emerald-500/20 mb-6">
            <div class="px-6 py-4 border-b border-emerald-500/20 flex items-center justify-between">
                <h3 class="font-semibold text-emerald-400">Berilgan javob</h3>
                <span class="text-sm text-emerald-500/60">{{ $message->responsed_at?->format('d.m.Y H:i') }}</span>
            </div>
            <div class="px-6 py-5">
                @if($message->replier)
                    <p class="text-xs text-emerald-500/60 mb-2">Javob bergan: {{ $message->replier->name }}</p>
                @endif
                <div class="bg-dark-900 rounded-lg p-4 text-sm text-dark-200 leading-relaxed border border-emerald-500/10">
                    {{ $message->response }}
                </div>
            </div>
        </div>
    @endif

    @if($message->status !== 'javob_berildi')
        <div class="bg-dark-900 rounded-xl border border-dark-700/50">
            <div class="px-6 py-4 border-b border-dark-700/50">
                <h3 class="font-semibold text-white">Javob yozish</h3>
            </div>
            <div class="px-6 py-5">
                <form action="{{ route('admin.messages.reply', $message) }}" method="POST">
                    @csrf

                    <textarea name="response" rows="4" required placeholder="Javobingizni yozing..."
                              class="w-full px-4 py-3 bg-dark-950 border border-dark-700 rounded-lg text-sm text-white placeholder-dark-500 focus:ring-2 focus:ring-accent-500 focus:border-accent-500 outline-none transition resize-none">{{ old('response') }}</textarea>

                    @error('response')
                        <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                    @enderror

                    <div class="flex items-center justify-between mt-4">
                        <p class="text-xs text-dark-500">Javob telegram orqali yuboruvchiga yetkaziladi</p>
                        <button type="submit" class="px-6 py-2.5 bg-accent-600 text-white rounded-lg text-sm font-medium hover:bg-accent-500 transition">
                            Javob yuborish
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
@endsection
