<?php

declare(strict_types=1);

namespace FondBot\Drivers\Telegram\Types;

class ReplyKeyboardRemove
{
    private $removeKeyboard = true;
    private $selective;

    public function getRemoveKeyboard(): bool
    {
        return $this->removeKeyboard;
    }

    public function setRemoveKeyboard(bool $removeKeyboard): ReplyKeyboardRemove
    {
        $this->removeKeyboard = $removeKeyboard;

        return $this;
    }

    public function getSelective(): ?bool
    {
        return $this->selective;
    }

    public function setSelective(?bool $selective): ReplyKeyboardRemove
    {
        $this->selective = $selective;

        return $this;
    }
}
