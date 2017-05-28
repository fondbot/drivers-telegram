<?php

declare(strict_types=1);

namespace FondBot\Drivers\Telegram;

use FondBot\Templates\Keyboard;
use FondBot\Drivers\TemplateCompiler;
use FondBot\Templates\Keyboard\Button;
use FondBot\Templates\Keyboard\UrlButton;
use FondBot\Templates\Keyboard\ReplyButton;
use FondBot\Templates\Keyboard\PayloadButton;
use FondBot\Drivers\Telegram\Templates\RequestContactButton;
use FondBot\Drivers\Telegram\Templates\RequestLocationButton;

class TelegramTemplateCompiler extends TemplateCompiler
{
    private const KEYBOARD_REPLY = 'keyboard';
    private const KEYBOARD_INLINE = 'inline_keyboard';

    private $keyboardButtons = [
        self::KEYBOARD_REPLY => [
            'ReplyButton',
            'RequestContactButton',
            'RequestLocationButton',
        ],
        self::KEYBOARD_INLINE => [
            'PayloadButton',
            'UrlButton',
        ],
    ];

    public function compileKeyboard(Keyboard $keyboard): ?array
    {
        $type = $this->detectKeyboardType($keyboard);

        $buttons = collect($keyboard->getButtons())
            ->filter(function (Button $button) use ($type) {
                return in_array($button->getName(), $this->keyboardButtons[$type], true);
            })
            ->map(function (Button $button) {
                return $this->compile($button);
            })
            ->toArray();

        switch ($type) {
            case self::KEYBOARD_REPLY:
                return [
                    'keyboard' => $buttons,
                    'resize_keyboard' => true,
                    'one_time_keyboard' => true,
                ];
            case self::KEYBOARD_INLINE:
                return [
                    'inline_keyboard' => $buttons,
                ];
        }

        return null;
    }

    public function compilePayloadButton(PayloadButton $button): array
    {
        return [['text' => $button->getLabel(), 'callback_data' => $button->getPayload()]];
    }

    public function compileReplyButton(ReplyButton $button): array
    {
        return [$button->getLabel()];
    }

    public function compileUrlButton(UrlButton $button): array
    {
        return [['text' => $button->getLabel(), 'url' => $button->getUrl()]];
    }

    public function compileRequestContactButton(RequestContactButton $button): array
    {
        return [['text' => $button->getLabel(), 'request_contact' => true]];
    }

    public function compileRequestLocationButton(RequestLocationButton $button): array
    {
        return [['text' => $button->getLabel(), 'request_location' => true]];
    }

    private function detectKeyboardType(Keyboard $keyboard): string
    {
        $button = collect($keyboard->getButtons())->first();

        if ($button instanceof PayloadButton || $button instanceof UrlButton) {
            return self::KEYBOARD_INLINE;
        }

        return self::KEYBOARD_REPLY;
    }
}
