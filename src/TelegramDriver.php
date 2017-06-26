<?php

declare(strict_types=1);

namespace FondBot\Drivers\Telegram;

use FondBot\Helpers\Arr;
use FondBot\Drivers\Chat;
use FondBot\Drivers\User;
use FondBot\Drivers\Driver;
use FondBot\Drivers\CommandHandler;
use FondBot\Drivers\ReceivedMessage;
use FondBot\Drivers\TemplateCompiler;
use FondBot\Drivers\Exceptions\InvalidRequest;

class TelegramDriver extends Driver
{
    /**
     * Get gateway display name.
     *
     * This can be used for various system where human-friendly name is required.
     *
     * @return string
     */
    public function getName(): string
    {
        return 'Telegram';
    }

    /**
     * Get driver short name.
     *
     * This name is used as an alias for configuration.
     *
     * @return string
     */
    public function getShortName(): string
    {
        return 'telegram';
    }

    /**
     * Define driver default parameters.
     *
     * Example: ['token' => '', 'apiVersion' => '1.0']
     *
     * @return array
     */
    public function getDefaultParameters(): array
    {
        return [
            'token' => '',
        ];
    }

    /**
     * Get template compiler instance.
     *
     * @return TemplateCompiler|null
     */
    public function getTemplateCompiler(): ?TemplateCompiler
    {
        return new TelegramTemplateCompiler;
    }

    /**
     * Get request builder instance.
     *
     * @return CommandHandler
     */
    public function getCommandHandler(): CommandHandler
    {
        return new TelegramCommandHandler($this);
    }

    /**
     * Verify incoming request data.
     *
     * @throws InvalidRequest
     */
    public function verifyRequest(): void
    {
        if (Arr::has($this->getRequestJson(), ['callback_query'])) {
            return;
        }

        if (!Arr::has($this->getRequestJson(), ['message', 'message.from'])) {
            throw new InvalidRequest('Invalid payload');
        }
    }

    /**
     * Get chat.
     *
     * @return Chat
     */
    public function getChat(): Chat
    {
        $chat = Arr::get($this->getRequestJson(), 'message.chat');

        return new Chat(
            (string) $chat['id'],
            $chat['title'] ?? '',
            $chat['type']
        );
    }

    /**
     * Get message sender.
     *
     * @return User
     */
    public function getUser(): User
    {
        if (Arr::has($this->getRequestJson(), ['callback_query'])) {
            $from = Arr::get($this->getRequestJson(), 'callback_query.from');
        } else {
            $from = Arr::get($this->getRequestJson(), 'message.from');
        }

        $name = [$from['first_name'] ?? null, $from['last_name'] ?? null];
        $name = implode(' ', $name);
        $name = trim($name);

        return new User(
            (string) $from['id'],
            $name,
            $from['username'] ?? null
        );
    }

    /**
     * Get message received from sender.
     *
     * @return ReceivedMessage
     */
    public function getMessage(): ReceivedMessage
    {
        return new TelegramReceivedMessage(
            $this->httpClient,
            $this->parameters->get('token'),
            $this->getRequestJson()
        );
    }

    public function getBaseUrl(): string
    {
        return 'https://api.telegram.org/bot'.$this->parameters->get('token');
    }
}
