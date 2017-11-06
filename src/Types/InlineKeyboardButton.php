<?php

declare(strict_types=1);

namespace FondBot\Drivers\Telegram\Types;

use FondBot\Drivers\Type;
use FondBot\Templates\Keyboard\UrlButton;
use FondBot\Templates\Keyboard\PayloadButton;

class InlineKeyboardButton extends Type
{
    private $text;
    private $url;
    private $callbackData;
    private $switchInlineQuery;
    private $switchInlineQueryCurrentChat;
    private $callbackGame;
    private $pay;

    /**
     * @param PayloadButton|UrlButton $button
     *
     * @return static
     */
    public static function create($button)
    {
        if ($button instanceof PayloadButton) {
            return (new static)
                ->setText($button->getLabel())
                ->setUrl($button->getParameters()->get('url'))
                ->setCallbackData($button->getPayload())
                ->setSwitchInlineQuery($button->getParameters()->get('switch_inline_query'))
                ->setSwitchInlineQueryCurrentChat($button->getParameters()->get('switch_inline_query_current_chat'))
                ->setCallbackGame($button->getParameters()->get('callback_game'))
                ->setPay($button->getParameters()->get('pay'));
        }

        if ($button instanceof UrlButton) {
            return (new static)
                ->setText($button->getLabel())
                ->setUrl($button->getUrl());
        }

        return null;
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function setText(string $text): self
    {
        $this->text = $text;

        return $this;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(?string $url): self
    {
        $this->url = $url;

        return $this;
    }

    public function getCallbackData(): ?string
    {
        return $this->callbackData;
    }

    public function setCallbackData(?string $callbackData): self
    {
        $this->callbackData = $callbackData;

        return $this;
    }

    public function getSwitchInlineQuery(): ?string
    {
        return $this->switchInlineQuery;
    }

    public function setSwitchInlineQuery(?string $switchInlineQuery): self
    {
        $this->switchInlineQuery = $switchInlineQuery;

        return $this;
    }

    public function getSwitchInlineQueryCurrentChat(): ?string
    {
        return $this->switchInlineQueryCurrentChat;
    }

    public function setSwitchInlineQueryCurrentChat(?string $switchInlineQueryCurrentChat): self
    {
        $this->switchInlineQueryCurrentChat = $switchInlineQueryCurrentChat;

        return $this;
    }

    public function getCallbackGame(): ?CallbackGame
    {
        return $this->callbackGame;
    }

    public function setCallbackGame(?CallbackGame $callbackGame): self
    {
        $this->callbackGame = $callbackGame;

        return $this;
    }

    public function getPay(): ?bool
    {
        return $this->pay;
    }

    public function setPay(?bool $pay): self
    {
        $this->pay = $pay;

        return $this;
    }

    public function toNative()
    {
        return collect([
            'text' => $this->text,
            'url' => $this->url,
            'callback_data' => $this->callbackData,
            'switch_inline_query' => $this->switchInlineQuery,
            'switch_inline_query_current_chat' => $this->switchInlineQueryCurrentChat,
            'callback_game' => $this->callbackGame,
            'pay' => $this->pay,
        ])
            ->filter(function ($value) {
                return $value !== null;
            })
            ->toArray();
    }
}
