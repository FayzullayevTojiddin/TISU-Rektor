@extends('layouts.admin')

@section('title', 'Murojaatlar')
@section('header', 'Murojaatlar')

@section('content')
<div class="bg-white rounded-xl border border-gray-200 mb-6">
    <div class="px-6 py-4 border-b border-gray-200">
        <form action="{{ route('admin.messages.index') }}" method="GET" class="flex flex-wrap items-center gap-3">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Qidirish..."
                   class="px-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none w-64">

            <select name="type" class="px-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none">
                <option value="">Barcha turlar</option>
                <option value="murojaat" {{ request('type') === 'murojaat' ? 'selected' : '' }}>Murojaat</option>
                <option value="shikoyat" {{ request('type') === 'shikoyat' ? 'selected' : '' }}>Shikoyat</option>
            </select>

            <select name="status" class="px-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none">
                <option value="">Barcha holatlar</option>
                <option value="kutilmoqda" {{ request('status') === 'kutilmoqda' ? 'selected' : '' }}>Kutilmoqda</option>
                <option value="korildi" {{ request('status') === 'korildi' ? 'selected' : '' }}>Ko'rildi</option>
                <option value="javob_berildi" {{ request('status') === 'javob_berildi' ? 'selected' : '' }}>Javob berildi</option>
            </select>

            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm hover:bg-blue-700 transition">
                Filtrlash
            </button>

            @if(request()->hasAny(['search', 'type', 'status']))
                <a href="{{ route('admin.messages.index') }}" class="px-4 py-2 text-gray-600 hover:text-gray-800 text-sm transition">
                    Tozalash
                </a>
            @endif
        </form>
    </div>

    @if($messages->isEmpty())
        <div class="px-6 py-12 text-center text-gray-400">
            Murojaatlar topilmadi
        </div>
    @else
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-gray-200 text-left">
                        <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Holat</th>
                        <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Yuboruvchi</th>
                        <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Turi</th>
                        <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Xabar</th>
                        <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Sana</th>
                        <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($messages as $message)
                        <tr class="hover:bg-gray-50 transition {{ $message->status === 'kutilmoqda' ? 'bg-orange-50/50' : '' }}">
                            <td class="px-6 py-4">
                                @if($message->status === 'kutilmoqda')
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-orange-100 text-orange-700">Kutilmoqda</span>
                                @elseif($message->status === 'korildi')
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-700">Ko'rildi</span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-green-100 text-green-700">Javob berildi</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm font-medium text-gray-900">{{ $message->writer?->name ?? 'Noma\'lum' }}</div>
                                @if($message->writer?->group)
                                    <div class="text-xs text-gray-500">{{ $message->writer->group }}</div>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium {{ $message->type === 'shikoyat' ? 'bg-red-50 text-red-700' : 'bg-blue-50 text-blue-700' }}">
                                    {{ $message->type === 'shikoyat' ? 'Shikoyat' : 'Murojaat' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 max-w-xs">
                                <p class="text-sm text-gray-600 truncate">{{ $message->message }}</p>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                                {{ $message->writed_at?->format('d.m.Y H:i') }}
                            </td>
                            <td class="px-6 py-4">
                                <a href="{{ route('admin.messages.show', $message) }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium transition">
                                    Ko'rish
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @if($messages->hasPages())
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $messages->links() }}
            </div>
        @endif
    @endif
</div>
@endsection
