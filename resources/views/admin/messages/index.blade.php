@extends('layouts.admin')

@section('title', 'Murojaatlar')
@section('header', 'Murojaatlar')

@section('content')
<div class="bg-dark-900 rounded-xl border border-dark-700/50 mb-6">
    <div class="px-6 py-4 border-b border-dark-700/50">
        <form action="{{ route('admin.messages.index') }}" method="GET" class="flex flex-wrap items-center gap-3">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Qidirish..."
                   class="px-4 py-2 bg-dark-950 border border-dark-700 rounded-lg text-sm text-white placeholder-dark-500 focus:ring-2 focus:ring-accent-500 focus:border-accent-500 outline-none w-64">

            <select name="type" class="px-4 py-2 bg-dark-950 border border-dark-700 rounded-lg text-sm text-white focus:ring-2 focus:ring-accent-500 focus:border-accent-500 outline-none">
                <option value="">Barcha turlar</option>
                <option value="murojaat" {{ request('type') === 'murojaat' ? 'selected' : '' }}>Murojaat</option>
                <option value="shikoyat" {{ request('type') === 'shikoyat' ? 'selected' : '' }}>Shikoyat</option>
            </select>

            <select name="status" class="px-4 py-2 bg-dark-950 border border-dark-700 rounded-lg text-sm text-white focus:ring-2 focus:ring-accent-500 focus:border-accent-500 outline-none">
                <option value="">Barcha holatlar</option>
                <option value="kutilmoqda" {{ request('status') === 'kutilmoqda' ? 'selected' : '' }}>Kutilmoqda</option>
                <option value="korildi" {{ request('status') === 'korildi' ? 'selected' : '' }}>Ko'rildi</option>
                <option value="javob_berildi" {{ request('status') === 'javob_berildi' ? 'selected' : '' }}>Javob berildi</option>
            </select>

            <button type="submit" class="px-4 py-2 bg-accent-600 text-white rounded-lg text-sm hover:bg-accent-500 transition">
                Filtrlash
            </button>

            @if(request()->hasAny(['search', 'type', 'status']))
                <a href="{{ route('admin.messages.index') }}" class="px-4 py-2 text-dark-400 hover:text-white text-sm transition">
                    Tozalash
                </a>
            @endif
        </form>
    </div>

    @if($messages->isEmpty())
        <div class="px-6 py-12 text-center text-dark-500">
            Murojaatlar topilmadi
        </div>
    @else
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-dark-700/50 text-left">
                        <th class="px-6 py-3 text-xs font-medium text-dark-400 uppercase tracking-wider">Holat</th>
                        <th class="px-6 py-3 text-xs font-medium text-dark-400 uppercase tracking-wider">Yuboruvchi</th>
                        <th class="px-6 py-3 text-xs font-medium text-dark-400 uppercase tracking-wider">Turi</th>
                        <th class="px-6 py-3 text-xs font-medium text-dark-400 uppercase tracking-wider">Xabar</th>
                        <th class="px-6 py-3 text-xs font-medium text-dark-400 uppercase tracking-wider">Sana</th>
                        <th class="px-6 py-3 text-xs font-medium text-dark-400 uppercase tracking-wider"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-dark-700/30">
                    @foreach($messages as $message)
                        <tr class="hover:bg-dark-800/50 transition {{ $message->status === 'kutilmoqda' ? 'bg-orange-500/5' : '' }}">
                            <td class="px-6 py-4">
                                @if($message->status === 'kutilmoqda')
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-orange-500/10 text-orange-400 border border-orange-500/20">Kutilmoqda</span>
                                @elseif($message->status === 'korildi')
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-blue-500/10 text-blue-400 border border-blue-500/20">Ko'rildi</span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">Javob berildi</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm font-medium text-white">{{ $message->writer?->name ?? 'Noma\'lum' }}</div>
                                @if($message->writer?->group)
                                    <div class="text-xs text-dark-400">{{ $message->writer->group }}</div>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium {{ $message->type === 'shikoyat' ? 'bg-red-500/10 text-red-400' : 'bg-indigo-500/10 text-indigo-400' }}">
                                    {{ $message->type === 'shikoyat' ? 'Shikoyat' : 'Murojaat' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 max-w-xs">
                                <p class="text-sm text-dark-300 truncate">{{ $message->message }}</p>
                            </td>
                            <td class="px-6 py-4 text-sm text-dark-400 whitespace-nowrap">
                                {{ $message->writed_at?->format('d.m.Y H:i') }}
                            </td>
                            <td class="px-6 py-4">
                                <a href="{{ route('admin.messages.show', $message) }}" class="text-accent-400 hover:text-accent-400/80 text-sm font-medium transition">
                                    Ko'rish
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @if($messages->hasPages())
            <div class="px-6 py-4 border-t border-dark-700/50">
                {{ $messages->links() }}
            </div>
        @endif
    @endif
</div>
@endsection
