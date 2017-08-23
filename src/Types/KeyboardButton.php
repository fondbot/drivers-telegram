<?php

declare(strict_types=1);

namespace FondBot\Drivers\Telegram\Types;

class KeyboardButton
{
    private $text;
    private $requestContact;
    private $requestLocation;

    public function getText(): string
    {
        return $this->text;
    }

    public function setText(string $text): KeyboardButton
    {
        $this->text = $text;

        return $this;
    }

    public function getRequestContact(): ?bool
    {
        return $this->requestContact;
    }

    public function setRequestContact(?bool $requestContact): KeyboardButton
    {
        $this->requestContact = $requestContact;

        return $this;
    }

    public function getRequestLocation(): ?bool
    {
        return $this->requestLocation;
    }

    public function setRequestLocation(?bool $requestLocation): KeyboardButton
    {
        $this->requestLocation = $requestLocation;

        return $this;
    }
}
