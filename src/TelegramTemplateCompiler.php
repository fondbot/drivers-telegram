<?php

declare(strict_types=1);

namespace FondBot\Drivers\Telegram;

use FondBot\Templates\Keyboard;
use FondBot\Drivers\TemplateCompiler;
use FondBot\Templates\Keyboard\UrlButton;
use FondBot\Templates\Keyboard\PayloadButton;
use unreal4u\TelegramAPI\Telegram\Types\KeyboardButton;
use unreal4u\TelegramAPI\Telegram\Types\ReplyKeyboardMarkup;
use unreal4u\TelegramAPI\Telegram\Types\Inline\Keyboard\Button as InlineKeyboardButton;
use unreal4u\TelegramAPI\Telegram\Types\Inline\Keyboard\Markup as InlineKeyboardMarkup;

class TelegramTemplateCompiler extends TemplateCompiler
{
    /**
     * Compile keyboard.
     *
     * @param Keyboard $keyboard
     *
     * @return mixed
     */
    protected function compileKeyboard(Keyboard $keyboard)
    {
        $firstButton = collect($keyboard->getButtons())->first();

        if ($firstButton instanceof PayloadButton || $firstButton instanceof UrlButton) {
            return $this->compileInlineKeyboard($keyboard);
        }

        return $this->compileReplyKeyboard($keyboard);
    }

    protected function compileInlineKeyboard(Keyboard $keyboard): InlineKeyboardMarkup
    {
        $inlineKeyboardMarkup = new InlineKeyboardMarkup();

        foreach ($keyboard->getButtons() as $button) {
            $inlineKeyboardButton = new InlineKeyboardButton();
            $inlineKeyboardButton->text = $button->getLabel();
            $inlineKeyboardButton->switch_inline_query = $button->getParameters()->get('switch_inline_query');
            $inlineKeyboardButton->switch_inline_query_current_chat = $button->getParameters()->get('switch_inline_query_current_chat');
            $inlineKeyboardButton->pay = $button->getParameters()->get('pay');

            if ($button instanceof PayloadButton) {
                $inlineKeyboardButton->callback_data = $button->getPayload();
            }

            if ($button instanceof UrlButton) {
                $inlineKeyboardButton->url = $button->getUrl();
            }

            $inlineKeyboardMarkup->inline_keyboard[] = [$inlineKeyboardButton];
        }

        return $inlineKeyboardMarkup;
    }

    protected function compileReplyKeyboard(Keyboard $keyboard): ReplyKeyboardMarkup
    {
        $replyKeyboardMarkup = new ReplyKeyboardMarkup();
        $replyKeyboardMarkup->resize_keyboard = $keyboard->getParameters()->get('resize_keyboard', true);
        $replyKeyboardMarkup->one_time_keyboard = $keyboard->getParameters()->get('one_time_keyboard', true);

        foreach ($keyboard->getButtons() as $button) {
            $keyboardButton = new KeyboardButton();
            $keyboardButton->text = $button->getLabel();
            $keyboardButton->request_contact = $button->getParameters()->get('request_contact', false);
            $keyboardButton->request_location = $button->getParameters()->get('request_location', false);

            $replyKeyboardMarkup->keyboard[] = [$keyboardButton];
        }

        return $replyKeyboardMarkup;
    }
}
