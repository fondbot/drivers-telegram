<?php

declare(strict_types=1);

namespace FondBot\Drivers\Telegram;

use FondBot\Drivers\Type;
use FondBot\Templates\Keyboard;
use FondBot\Drivers\TemplateCompiler;
use FondBot\Templates\Keyboard\UrlButton;
use FondBot\Templates\Keyboard\PayloadButton;
use FondBot\Drivers\Telegram\Types\ReplyKeyboardMarkup;
use FondBot\Drivers\Telegram\Types\InlineKeyboardMarkup;

class TelegramTemplateCompiler extends TemplateCompiler
{
    /**
     * Compile keyboard.
     *
     * @param Keyboard $keyboard
     *
     * @return Type|null
     */
    protected function compileKeyboard(Keyboard $keyboard): ?Type
    {
        $firstButton = collect($keyboard->getButtons())->first();

        if ($firstButton instanceof PayloadButton || $firstButton instanceof UrlButton) {
            return InlineKeyboardMarkup::create($keyboard);
        }

        return ReplyKeyboardMarkup::create($keyboard);
    }
}
