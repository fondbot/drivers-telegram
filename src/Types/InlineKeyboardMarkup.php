<?php

declare(strict_types=1);

namespace FondBot\Drivers\Telegram\Types;

use FondBot\Drivers\Type;
use FondBot\Templates\Keyboard;
use Illuminate\Support\Collection;

class InlineKeyboardMarkup extends Type
{
    private $inlineKeyboard;

    public static function create(Keyboard $keyboard)
    {
        return (new static)
            ->setInlineKeyboard(InlineKeyboardButton::createFromTemplate($keyboard->getButtons()));
    }

    /**
     * @return InlineKeyboardButton[]|Collection
     */
    public function getInlineKeyboard()
    {
        return $this->inlineKeyboard;
    }

    /**
     * @param InlineKeyboardButton[] $inlineKeyboard
     *
     * @return InlineKeyboardMarkup
     */
    public function setInlineKeyboard($inlineKeyboard): InlineKeyboardMarkup
    {
        $this->inlineKeyboard = $inlineKeyboard;

        return $this;
    }

    public function toNative()
    {
        $keyboard = collect($this->inlineKeyboard)
            ->transform(function (InlineKeyboardButton $value) {
                return $value->toNative();
            })
            ->toArray();

        return ['inline_keyboard' => [$keyboard]];
    }
}
