<?php

declare(strict_types=1);

namespace FondBot\Drivers\Telegram\Types;

class InlineKeyboardMarkup
{
    private $inlineKeyboard;

    public function getInlineKeyboard(): array
    {
        return $this->inlineKeyboard;
    }

    public function setInlineKeyboard(array $inlineKeyboard): InlineKeyboardMarkup
    {
        $this->inlineKeyboard = $inlineKeyboard;

        return $this;
    }
}
