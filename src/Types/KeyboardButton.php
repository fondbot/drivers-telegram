<?php

declare(strict_types=1);

namespace FondBot\Drivers\Telegram\Types;

use FondBot\Drivers\Type;
use FondBot\Templates\Keyboard\ReplyButton;

class KeyboardButton extends Type
{
    private $text;
    private $requestContact;
    private $requestLocation;

    public static function create(ReplyButton $replyButton)
    {
        return (new static)
            ->setText($replyButton->getLabel())
            ->setRequestContact($replyButton->getParameters()->get('request_contact'))
            ->setRequestLocation($replyButton->getParameters()->get('request_location'));
    }

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
