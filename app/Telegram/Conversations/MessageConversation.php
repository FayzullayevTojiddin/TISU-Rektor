<?php

namespace App\Telegram\Conversations;

use App\Models\Message;
use App\Models\User;
use App\Telegram\Helpers\KeyboardHelper;
use SergiX44\Nutgram\Conversations\Conversation;
use SergiX44\Nutgram\Nutgram;

class MessageConversation extends Conversation
{
    protected string $type = 'murojaat';
    protected ?string $fullName = null;

    public function start(Nutgram $bot, string $type = 'murojaat'): void
    {
        $this->type = $type;

        $bot->sendMessage(
            text: "👤 *Iltimos, to'liq ism\-familiyangizni kiriting:*\n\n_Masalan: Aliyev Vali G'aniyevich_",
            parse_mode: 'MarkdownV2',
        );

        $this->next('handleName');
    }

    public function handleName(Nutgram $bot): void
    {
        $name = $bot->message()->text;

        if (empty($name) || mb_strlen($name) < 3) {
            $bot->sendMessage(
                text: "⚠️ Iltimos, to'liq ism-familiyangizni kiriting.",
            );
            return;
        }

        $this->fullName = $name;

        $user = User::where('telegram_id', $bot->userId())->first();
        if ($user) {
            $user->update(['info' => $name]);
        }

        $label = $this->type === 'shikoyat' ? 'shikoyatingizni' : 'murojaatingizni';

        $bot->sendMessage(
            text: "✍️ Endi {$label} yozing.\n\nXabaringizni batafsil yozishga harakat qiling.",
        );

        $this->next('handleMessage');
    }

    public function handleMessage(Nutgram $bot): void
    {
        $text = $bot->message()->text;

        if (empty($text) || mb_strlen($text) < 5) {
            $bot->sendMessage(
                text: "⚠️ Xabar juda qisqa. Iltimos, batafsil yozing.",
            );
            return;
        }

        $user = User::where('telegram_id', $bot->userId())->first();

        Message::create([
            'type' => $this->type,
            'writed_by' => $user->id,
            'message' => $text,
            'writed_at' => now(),
            'status' => 'kutilmoqda',
        ]);

        $label = $this->type === 'shikoyat' ? 'Shikoyatingiz' : 'Murojaatingiz';
        $typeLabel = ucfirst($this->type);

        $bot->sendMessage(
            text: "✅ {$label} muvaffaqiyatli qabul qilindi!\n\n"
                . "👤 Kimdan: {$this->fullName}\n"
                . "📝 Turi: {$typeLabel}\n\n"
                . "⏳ Javob berilganda sizga xabar yuboriladi.",
            reply_markup: KeyboardHelper::mainMenu(),
        );

        $this->end();
    }
}
