<?php

declare(strict_types=1);

namespace FondBot\Drivers\Telegram\Types;

use FondBot\Drivers\Type;

class CallbackQuery extends Type
{
    private $id;
    private $from;
    private $message;
    private $inlineMessageId;
    private $chatInstance;
    private $data;
    private $gameShortName;

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getFrom(): User
    {
        return $this->from;
    }

    public function setFrom(User $from): self
    {
        $this->from = $from;

        return $this;
    }

    public function getMessage(): ?Message
    {
        return $this->message;
    }

    public function setMessage(?Message $message): self
    {
        $this->message = $message;

        return $this;
    }

    public function getInlineMessageId(): ?string
    {
        return $this->inlineMessageId;
    }

    public function setInlineMessageId(?string $inlineMessageId): self
    {
        $this->inlineMessageId = $inlineMessageId;

        return $this;
    }

    public function getChatInstance(): string
    {
        return $this->chatInstance;
    }

    public function setChatInstance(string $chatInstance): self
    {
        $this->chatInstance = $chatInstance;

        return $this;
    }

    public function getData(): ?string
    {
        return $this->data;
    }

    public function setData(?string $data): self
    {
        $this->data = $data;

        return $this;
    }

    public function getGameShortName(): ?string
    {
        return $this->gameShortName;
    }

    public function setGameShortName(?string $gameShortName): self
    {
        $this->gameShortName = $gameShortName;

        return $this;
    }
}
