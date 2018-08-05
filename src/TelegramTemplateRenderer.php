<?php

declare(strict_types=1);

namespace FondBot\Drivers\Telegram;

use FondBot\Drivers\Type;
use FondBot\Templates\Keyboard;
use FondBot\Drivers\TemplateRenderer;
use FondBot\Templates\Keyboard\UrlButton;
use FondBot\Templates\Keyboard\PayloadButton;
use FondBot\Drivers\Telegram\Types\ReplyKeyboardMarkup;
use FondBot\Drivers\Telegram\Types\InlineKeyboardMarkup;

class TelegramTemplateRenderer extends TemplateRenderer
{
    /**
     * Render keyboard.
     *
     * @param Keyboard $keyboard
     *
     * @return Type|null
     */
    protected function renderKeyboard(Keyboard $keyboard): ?Type
    {
        $firstButton = collect($keyboard->getButtons())->first();

        if ($firstButton instanceof PayloadButton || $firstButton instanceof UrlButton) {
            return InlineKeyboardMarkup::create($keyboard);
        }

        return ReplyKeyboardMarkup::create($keyboard);
    }
}
