<?php

use App\Models\User;
use App\Telegram\Conversations\MessageConversation;
use App\Telegram\Helpers\KeyboardHelper;
use SergiX44\Nutgram\Nutgram;

$bot->onCommand('start', function (Nutgram $bot) {
    $telegramUser = $bot->user();

    $user = User::firstOrCreate(
        ['telegram_id' => $telegramUser->id],
        [
            'name' => trim($telegramUser->first_name . ' ' . ($telegramUser->last_name ?? '')),
            'role' => 'user',
        ]
    );

    $bot->sendMessage(
        text: "🏛 TISU Rektor virtual qabulxonasiga xush kelibsiz!\n\n"
            . "Assalomu alaykum, {$user->name}! 👋\n\n"
            . "Bu bot orqali siz bevosita rektorga murojaat yoki shikoyat "
            . "qoldirishingiz mumkin. Har bir xabaringiz ko'rib chiqiladi "
            . "va javob beriladi.\n\n"
            . "📌 Quyidagi bo'limlardan birini tanlang:",
        reply_markup: KeyboardHelper::mainMenu(),
    );
});

$bot->onText('📩 Xabar qoldirish', function (Nutgram $bot) {
    $user = User::where('telegram_id', $bot->userId())->first();
    if (!$user) {
        $bot->sendMessage(text: "Iltimos, avval /start buyrug'ini yuboring.");
        return;
    }

    MessageConversation::begin($bot, $bot->userId(), $bot->chatId(), data: ['murojaat']);
});

$bot->onText('📢 Shikoyat qoldirish', function (Nutgram $bot) {
    $user = User::where('telegram_id', $bot->userId())->first();
    if (!$user) {
        $bot->sendMessage(text: "Iltimos, avval /start buyrug'ini yuboring.");
        return;
    }

    MessageConversation::begin($bot, $bot->userId(), $bot->chatId(), data: ['shikoyat']);
});

$bot->onText('📣 Telegram kanal', function (Nutgram $bot) {
    $bot->sendMessage(
        text: "📣 TISU rasmiy Telegram kanali\n\n"
            . "Universitetning so'nggi yangiliklari, e'lonlar va muhim "
            . "ma'lumotlardan doimo xabardor bo'lib boring.\n\n"
            . "👉 @tisu_2022\n\n"
            . "✅ Obuna bo'ling va hech qanday yangilikni o'tkazib yubormang!",
        reply_markup: KeyboardHelper::mainMenu(),
    );
});

$bot->onText('🌐 Web sahifa', function (Nutgram $bot) {
    $bot->sendMessage(
        text: "🌐 TISU rasmiy veb-sahifasi\n\n"
            . "Universitet haqida to'liq ma'lumot, yangiliklar, "
            . "qabul jarayonlari va boshqa foydali resurslar.\n\n"
            . "🔗 tues.uz\n\n"
            . "📖 Sahifani muntazam kuzatib boring!",
        reply_markup: KeyboardHelper::mainMenu(),
    );
});

$bot->onText('📋 Mening murojaatlarim', function (Nutgram $bot) {
    $user = User::where('telegram_id', $bot->userId())->first();

    if (!$user) {
        $bot->sendMessage(text: "Iltimos, avval /start buyrug'ini yuboring.");
        return;
    }

    $messages = $user->messages()->orderByDesc('writed_at')->limit(10)->get();

    if ($messages->isEmpty()) {
        $bot->sendMessage(
            text: "📋 Mening murojaatlarim\n\n"
                . "Sizda hali hech qanday murojaat yoki shikoyat yo'q.\n\n"
                . "📩 Yangi murojaat qoldirish uchun tegishli tugmani bosing.",
            reply_markup: KeyboardHelper::mainMenu(),
        );
        return;
    }

    $text = "📋 Mening murojaatlarim\n\n";

    foreach ($messages as $index => $message) {
        $number = $index + 1;
        $type = $message->type === 'shikoyat' ? '📢 Shikoyat' : '📩 Murojaat';
        $status = match ($message->status) {
            'kutilmoqda' => '⏳ Kutilmoqda',
            'korildi' => '👁 Ko\'rildi',
            'javob_berildi' => '✅ Javob berildi',
            default => $message->status,
        };
        $date = $message->writed_at?->format('d.m.Y H:i') ?? '-';
        $msg = mb_substr($message->message, 0, 100);

        $text .= "▫️ {$number}. {$type}\n";
        $text .= "   📅 {$date} | {$status}\n";
        $text .= "   💬 {$msg}\n";

        if ($message->response) {
            $text .= "   ↩️ Javob: {$message->response}\n";
        }

        $text .= "\n";
    }

    $bot->sendMessage(
        text: $text,
        reply_markup: KeyboardHelper::mainMenu(),
    );
});
