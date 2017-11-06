<?php

declare(strict_types=1);

namespace FondBot\Drivers\Telegram\Types;

use FondBot\Drivers\Type;

class Update extends Type
{
    private $updateId;
    private $message;
    private $editedMessage;
    private $channelPost;
    private $editedChannelPost;
    private $inlineQuery;
    private $chosenInlineResult;
    private $callbackQuery;
    private $shippingQuery;
    private $preCheckoutQuery;

    public function getUpdateId(): int
    {
        return $this->updateId;
    }

    public function setUpdateId(int $updateId): self
    {
        $this->updateId = $updateId;

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

    public function getEditedMessage(): ?Message
    {
        return $this->editedMessage;
    }

    public function setEditedMessage(?Message $editedMessage): self
    {
        $this->editedMessage = $editedMessage;

        return $this;
    }

    public function getChannelPost(): ?Message
    {
        return $this->channelPost;
    }

    public function setChannelPost(?Message $channelPost): self
    {
        $this->channelPost = $channelPost;

        return $this;
    }

    public function getEditedChannelPost(): ?Message
    {
        return $this->editedChannelPost;
    }

    public function setEditedChannelPost(?Message $editedChannelPost): self
    {
        $this->editedChannelPost = $editedChannelPost;

        return $this;
    }

    public function getInlineQuery(): ?InlineQuery
    {
        return $this->inlineQuery;
    }

    public function setInlineQuery(?InlineQuery $inlineQuery): self
    {
        $this->inlineQuery = $inlineQuery;

        return $this;
    }

    public function getChosenInlineResult(): ?ChosenInlineResult
    {
        return $this->chosenInlineResult;
    }

    public function setChosenInlineResult(?ChosenInlineResult $chosenInlineResult): self
    {
        $this->chosenInlineResult = $chosenInlineResult;

        return $this;
    }

    public function getCallbackQuery(): ?CallbackQuery
    {
        return $this->callbackQuery;
    }

    public function setCallbackQuery(?CallbackQuery $callbackQuery): self
    {
        $this->callbackQuery = $callbackQuery;

        return $this;
    }

    public function getShippingQuery(): ?ShippingQuery
    {
        return $this->shippingQuery;
    }

    public function setShippingQuery(?ShippingQuery $shippingQuery): self
    {
        $this->shippingQuery = $shippingQuery;

        return $this;
    }

    public function getPreCheckoutQuery(): ?PreCheckoutQuery
    {
        return $this->preCheckoutQuery;
    }

    public function setPreCheckoutQuery(?PreCheckoutQuery $preCheckoutQuery): self
    {
        $this->preCheckoutQuery = $preCheckoutQuery;

        return $this;
    }
}
