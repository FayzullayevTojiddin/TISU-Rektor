<?php

namespace App\Telegram\Helpers;

use SergiX44\Nutgram\Telegram\Types\Keyboard\KeyboardButton;
use SergiX44\Nutgram\Telegram\Types\Keyboard\ReplyKeyboardMarkup;

class KeyboardHelper
{
    public static function mainMenu(): ReplyKeyboardMarkup
    {
        return ReplyKeyboardMarkup::make(resize_keyboard: true)
            ->addRow(
                KeyboardButton::make('📩 Xabar qoldirish'),
                KeyboardButton::make('📢 Shikoyat qoldirish'),
            )
            ->addRow(
                KeyboardButton::make('📣 Telegram kanal'),
                KeyboardButton::make('🌐 Web sahifa'),
            )
            ->addRow(
                KeyboardButton::make('📋 Mening murojaatlarim'),
            );
    }
}
