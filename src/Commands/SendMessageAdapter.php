<?php

declare(strict_types=1);

namespace FondBot\Drivers\Telegram\Commands;

use FondBot\Templates\Keyboard;
use FondBot\Contracts\Arrayable;
use FondBot\Drivers\Commands\SendMessage;
use FondBot\Templates\Keyboard\UrlButton;
use FondBot\Templates\Keyboard\ReplyButton;
use FondBot\Templates\Keyboard\PayloadButton;
use FondBot\Drivers\Telegram\Templates\Keyboard\Buttons\RequestContactButton;
use FondBot\Drivers\Telegram\Templates\Keyboard\Buttons\RequestLocationButton;

class SendMessageAdapter implements Arrayable
{
    private const KEYBOARD_REPLY = 'keyboard';
    private const KEYBOARD_INLINE = 'inline_keyboard';

    private $command;

    public function __construct(SendMessage $command)
    {
        $this->command = $command;
    }

    /**
     * Get the instance as an array.
     *
     * @return array
     */
    public function toArray(): array
    {
        $payload = [
            'chat_id' => $this->command->chat->getId(),
            'text' => $this->command->text,
        ];

        if ($replyMarkup = $this->getReplyMarkup()) {
            $payload['reply_markup'] = json_encode($this->getReplyMarkup());
        }

        return $payload;
    }

    private function getReplyMarkup(): ?array
    {
        if ($this->command->template instanceof Keyboard) {
            /** @var Keyboard $keyboard */
            $keyboard = $this->command->template;

            $type = $this->detectKeyboardType($keyboard);

            $payload = [];
            switch ($type) {
                case self::KEYBOARD_REPLY:
                    $payload = $this->compileReplyKeyboard($keyboard);
                    break;
                case self::KEYBOARD_INLINE:
                    $payload = $this->compileInlineKeyboard($keyboard);
                    break;
            }

            return $payload;
        }

        return null;
    }

    /**
     * Compile reply keyboard markup.
     *
     * @param Keyboard $keyboard
     *
     * @return array
     */
    private function compileReplyKeyboard(Keyboard $keyboard): array
    {
        $buttons = [];

        foreach ($keyboard->getButtons() as $button) {
            if ($button instanceof ReplyButton) {
                $buttons[] = [$button->getLabel()];
            } elseif ($button instanceof RequestContactButton) {
                $buttons[] = [['text' => $button->getLabel(), 'request_contact' => true]];
            } elseif ($button instanceof RequestLocationButton) {
                $buttons[] = [['text' => $button->getLabel(), 'request_location' => true]];
            }
        }

        return [
            'keyboard' => $buttons,
            'resize_keyboard' => true,
            'one_time_keyboard' => true,
        ];
    }

    /**
     * Compile inline keyboard markup.
     *
     * @param Keyboard $keyboard
     *
     * @return array
     */
    private function compileInlineKeyboard(Keyboard $keyboard): array
    {
        $buttons = [];
        foreach ($keyboard->getButtons() as $button) {
            $parameters = ['text' => $button->getLabel()];

            if ($button instanceof UrlButton) {
                $parameters['url'] = $button->getUrl();
            } elseif ($button instanceof PayloadButton) {
                $parameters['callback_data'] = $button->getPayload();
            }

            $buttons[] = $parameters;
        }

        return [
            'inline_keyboard' => [$buttons],
        ];
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
