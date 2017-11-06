<?php

declare(strict_types=1);

namespace FondBot\Drivers\Telegram\Types;

use FondBot\Drivers\Type;

class ReplyKeyboardRemove extends Type
{
    private $removeKeyboard = true;
    private $selective;

    public function getRemoveKeyboard(): bool
    {
        return $this->removeKeyboard;
    }

    public function setRemoveKeyboard(bool $removeKeyboard): self
    {
        $this->removeKeyboard = $removeKeyboard;

        return $this;
    }

    public function getSelective(): ?bool
    {
        return $this->selective;
    }

    public function setSelective(?bool $selective): self
    {
        $this->selective = $selective;

        return $this;
    }
}
