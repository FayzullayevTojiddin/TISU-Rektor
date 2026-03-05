<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Message;
use Illuminate\Http\Request;
use SergiX44\Nutgram\Nutgram;

class MessageController extends Controller
{
    public function index(Request $request)
    {
        $query = Message::with('writer')->orderByDesc('writed_at');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('message', 'like', "%{$search}%")
                    ->orWhereHas('writer', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    });
            });
        }

        $messages = $query->paginate(20)->withQueryString();

        return view('admin.messages.index', compact('messages'));
    }

    public function show(Message $message)
    {
        $message->load('writer', 'replier');

        if ($message->status === 'kutilmoqda') {
            $message->update(['status' => 'korildi']);
        }

        return view('admin.messages.show', compact('message'));
    }

    public function reply(Request $request, Message $message, Nutgram $bot)
    {
        $request->validate([
            'response' => 'required|string|min:3',
        ]);

        $message->update([
            'response' => $request->response,
            'reply_by' => auth()->id(),
            'responsed_at' => now(),
            'status' => 'javob_berildi',
        ]);

        if ($message->writer && $message->writer->telegram_id) {
            $typeLabel = $message->type === 'shikoyat' ? 'shikoyatingizga' : 'murojaatingizga';
            $bot->sendMessage(
                text: "📬 Sizning {$typeLabel} javob berildi!\n\n"
                    . "💬 Xabaringiz: {$message->message}\n\n"
                    . "↩️ Javob: {$request->response}",
                chat_id: $message->writer->telegram_id,
            );
        }

        return redirect()->route('admin.messages.show', $message)
            ->with('success', 'Javob muvaffaqiyatli yuborildi!');
    }
}
