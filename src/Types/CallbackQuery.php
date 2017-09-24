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

    public function setId(string $id): CallbackQuery
    {
        $this->id = $id;

        return $this;
    }

    public function getFrom(): User
    {
        return $this->from;
    }

    public function setFrom(User $from): CallbackQuery
    {
        $this->from = $from;

        return $this;
    }

    public function getMessage(): ?Message
    {
        return $this->message;
    }

    public function setMessage(?Message $message): CallbackQuery
    {
        $this->message = $message;

        return $this;
    }

    public function getInlineMessageId(): ?string
    {
        return $this->inlineMessageId;
    }

    public function setInlineMessageId(?string $inlineMessageId): CallbackQuery
    {
        $this->inlineMessageId = $inlineMessageId;

        return $this;
    }

    public function getChatInstance(): string
    {
        return $this->chatInstance;
    }

    public function setChatInstance(string $chatInstance): CallbackQuery
    {
        $this->chatInstance = $chatInstance;

        return $this;
    }

    public function getData(): ?string
    {
        return $this->data;
    }

    public function setData(?string $data): CallbackQuery
    {
        $this->data = $data;

        return $this;
    }

    public function getGameShortName(): ?string
    {
        return $this->gameShortName;
    }

    public function setGameShortName(?string $gameShortName): CallbackQuery
    {
        $this->gameShortName = $gameShortName;

        return $this;
    }
}
