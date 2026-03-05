@extends('layouts.admin')

@section('title', 'Murojaat #' . $message->id)
@section('header', 'Murojaat #' . $message->id)

@section('content')
<div class="max-w-4xl">
    <a href="{{ route('admin.messages.index') }}" class="inline-flex items-center gap-2 text-sm text-gray-500 hover:text-gray-700 mb-6 transition">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
        </svg>
        Murojaatlarga qaytish
    </a>

    <div class="bg-white rounded-xl border border-gray-200 mb-6">
        <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium {{ $message->type === 'shikoyat' ? 'bg-red-100 text-red-700' : 'bg-blue-100 text-blue-700' }}">
                    {{ $message->type === 'shikoyat' ? 'Shikoyat' : 'Murojaat' }}
                </span>
                @if($message->status === 'kutilmoqda')
                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-orange-100 text-orange-700">Kutilmoqda</span>
                @elseif($message->status === 'korildi')
                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-700">Ko'rildi</span>
                @else
                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-green-100 text-green-700">Javob berildi</span>
                @endif
            </div>
            <span class="text-sm text-gray-400">{{ $message->writed_at?->format('d.m.Y H:i') }}</span>
        </div>

        <div class="px-6 py-5">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                <div>
                    <p class="text-xs text-gray-500 mb-1">Yuboruvchi</p>
                    <p class="text-sm font-medium text-gray-900">{{ $message->writer?->name ?? 'Noma\'lum' }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500 mb-1">Guruh</p>
                    <p class="text-sm font-medium text-gray-900">{{ $message->writer?->group ?? '—' }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500 mb-1">Telefon</p>
                    <p class="text-sm font-medium text-gray-900">{{ $message->writer?->phone ?? '—' }}</p>
                </div>
            </div>

            <div class="border-t border-gray-100 pt-5">
                <p class="text-xs text-gray-500 mb-2">Xabar matni</p>
                <div class="bg-gray-50 rounded-lg p-4 text-sm text-gray-800 leading-relaxed">
                    {{ $message->message }}
                </div>
            </div>
        </div>
    </div>

    @if($message->response)
        <div class="bg-green-50 rounded-xl border border-green-200 mb-6">
            <div class="px-6 py-4 border-b border-green-200 flex items-center justify-between">
                <h3 class="font-semibold text-green-800">Berilgan javob</h3>
                <span class="text-sm text-green-600">{{ $message->responsed_at?->format('d.m.Y H:i') }}</span>
            </div>
            <div class="px-6 py-5">
                @if($message->replier)
                    <p class="text-xs text-green-600 mb-2">Javob bergan: {{ $message->replier->name }}</p>
                @endif
                <div class="bg-white rounded-lg p-4 text-sm text-gray-800 leading-relaxed border border-green-100">
                    {{ $message->response }}
                </div>
            </div>
        </div>
    @endif

    @if($message->status !== 'javob_berildi')
        <div class="bg-white rounded-xl border border-gray-200">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="font-semibold text-gray-800">Javob yozish</h3>
            </div>
            <div class="px-6 py-5">
                <form action="{{ route('admin.messages.reply', $message) }}" method="POST">
                    @csrf

                    <textarea name="response" rows="4" required placeholder="Javobingizni yozing..."
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition resize-none">{{ old('response') }}</textarea>

                    @error('response')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror

                    <div class="flex items-center justify-between mt-4">
                        <p class="text-xs text-gray-400">Javob telegram orqali yuboruvchiga yetkaziladi</p>
                        <button type="submit" class="px-6 py-2.5 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700 transition">
                            Javob yuborish
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
@endsection
