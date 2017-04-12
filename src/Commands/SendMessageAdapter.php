<?php

declare(strict_types=1);

namespace FondBot\Drivers\Telegram\Commands;

use FondBot\Drivers\Commands\SendMessage;
use FondBot\Conversation\Buttons\UrlButton;
use FondBot\Conversation\Buttons\PayloadButton;
use FondBot\Drivers\Telegram\Buttons\RequestContactButton;

class SendMessageAdapter
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
        if ($this->command->keyboard !== null) {
            $type = $this->detectKeyboardType();

            $keyboard = [];
            switch ($type) {
                case self::KEYBOARD_REPLY:
                    $keyboard = $this->compileReplyKeyboard();
                    break;
                case self::KEYBOARD_INLINE:
                    $keyboard = $this->compileInlineKeyboard();
                    break;
            }

            return $keyboard;
        }

        return null;
    }

    /**
     * Compile reply keyboard markup.
     *
     * @return array
     */
    private function compileReplyKeyboard(): array
    {
        $buttons = [];
        foreach ($this->command->keyboard->getButtons() as $button) {
            $parameters = ['text' => $button->getLabel()];

            if ($button instanceof RequestContactButton) {
                $parameters['request_contact'] = true;
            }

            $buttons[] = $parameters;
        }

        return [
            'keyboard' => [$buttons],
            'one_time_keyboard' => true,
        ];
    }

    /**
     * Compile inline keyboard markup.
     *
     * @return array
     */
    private function compileInlineKeyboard(): array
    {
        $buttons = [];
        foreach ($this->command->keyboard->getButtons() as $button) {
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

    private function detectKeyboardType(): string
    {
        $button = collect($this->command->keyboard->getButtons())->first();

        if ($button instanceof PayloadButton || $button instanceof UrlButton) {
            return self::KEYBOARD_INLINE;
        }

        return self::KEYBOARD_REPLY;
    }
}
