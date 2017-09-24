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

    public function setUpdateId(int $updateId): Update
    {
        $this->updateId = $updateId;

        return $this;
    }

    public function getMessage(): ?Message
    {
        return $this->message;
    }

    public function setMessage(?Message $message): Update
    {
        $this->message = $message;

        return $this;
    }

    public function getEditedMessage(): ?Message
    {
        return $this->editedMessage;
    }

    public function setEditedMessage(?Message $editedMessage): Update
    {
        $this->editedMessage = $editedMessage;

        return $this;
    }

    public function getChannelPost(): ?Message
    {
        return $this->channelPost;
    }

    public function setChannelPost(?Message $channelPost): Update
    {
        $this->channelPost = $channelPost;

        return $this;
    }

    public function getEditedChannelPost(): ?Message
    {
        return $this->editedChannelPost;
    }

    public function setEditedChannelPost(?Message $editedChannelPost): Update
    {
        $this->editedChannelPost = $editedChannelPost;

        return $this;
    }

    public function getInlineQuery(): ?InlineQuery
    {
        return $this->inlineQuery;
    }

    public function setInlineQuery(?InlineQuery $inlineQuery): Update
    {
        $this->inlineQuery = $inlineQuery;

        return $this;
    }

    public function getChosenInlineResult(): ?ChosenInlineResult
    {
        return $this->chosenInlineResult;
    }

    public function setChosenInlineResult(?ChosenInlineResult $chosenInlineResult): Update
    {
        $this->chosenInlineResult = $chosenInlineResult;

        return $this;
    }

    public function getCallbackQuery(): ?CallbackQuery
    {
        return $this->callbackQuery;
    }

    public function setCallbackQuery(?CallbackQuery $callbackQuery): Update
    {
        $this->callbackQuery = $callbackQuery;

        return $this;
    }

    public function getShippingQuery(): ?ShippingQuery
    {
        return $this->shippingQuery;
    }

    public function setShippingQuery(?ShippingQuery $shippingQuery): Update
    {
        $this->shippingQuery = $shippingQuery;

        return $this;
    }

    public function getPreCheckoutQuery(): ?PreCheckoutQuery
    {
        return $this->preCheckoutQuery;
    }

    public function setPreCheckoutQuery(?PreCheckoutQuery $preCheckoutQuery): Update
    {
        $this->preCheckoutQuery = $preCheckoutQuery;

        return $this;
    }
}
