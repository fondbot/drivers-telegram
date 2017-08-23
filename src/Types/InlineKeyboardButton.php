<?php

declare(strict_types=1);

namespace FondBot\Drivers\Telegram\Types;

class InlineKeyboardButton
{
    private $text;
    private $url;
    private $callbackData;
    private $switchInlineQuery;
    private $switchInlineQueryCurrentChat;
    private $callbackGame;
    private $pay;

    public function getText(): string
    {
        return $this->text;
    }

    public function setText(string $text): InlineKeyboardButton
    {
        $this->text = $text;

        return $this;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(?string $url): InlineKeyboardButton
    {
        $this->url = $url;

        return $this;
    }

    public function getCallbackData(): ?string
    {
        return $this->callbackData;
    }

    public function setCallbackData(?string $callbackData): InlineKeyboardButton
    {
        $this->callbackData = $callbackData;

        return $this;
    }

    public function getSwitchInlineQuery(): ?string
    {
        return $this->switchInlineQuery;
    }

    public function setSwitchInlineQuery(?string $switchInlineQuery): InlineKeyboardButton
    {
        $this->switchInlineQuery = $switchInlineQuery;

        return $this;
    }

    public function getSwitchInlineQueryCurrentChat(): ?string
    {
        return $this->switchInlineQueryCurrentChat;
    }

    public function setSwitchInlineQueryCurrentChat(?string $switchInlineQueryCurrentChat): InlineKeyboardButton
    {
        $this->switchInlineQueryCurrentChat = $switchInlineQueryCurrentChat;

        return $this;
    }

    public function getCallbackGame(): ?CallbackGame
    {
        return $this->callbackGame;
    }

    public function setCallbackGame(?CallbackGame $callbackGame): InlineKeyboardButton
    {
        $this->callbackGame = $callbackGame;

        return $this;
    }

    public function getPay(): ?bool
    {
        return $this->pay;
    }

    public function setPay(?bool $pay): InlineKeyboardButton
    {
        $this->pay = $pay;

        return $this;
    }
}
