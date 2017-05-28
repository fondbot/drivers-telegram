<?php

declare(strict_types=1);

namespace FondBot\Drivers\Telegram;

use GuzzleHttp\Client;
use FondBot\Drivers\Chat;
use FondBot\Drivers\User;
use FondBot\Drivers\Driver;
use FondBot\Drivers\CommandHandler;
use FondBot\Drivers\ReceivedMessage;
use FondBot\Drivers\TemplateCompiler;
use FondBot\Drivers\Exceptions\InvalidRequest;

class TelegramDriver extends Driver
{
    private $guzzle;

    public function __construct(Client $guzzle)
    {
        $this->guzzle = $guzzle;
    }

    public function getBaseUrl(): string
    {
        return 'https://api.telegram.org/bot'.$this->getParameter('token');
    }

    /**
     * Get template compiler instance.
     *
     * @return TemplateCompiler
     */
    public function getTemplateCompiler(): TemplateCompiler
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
        return new TelegramCommandHandler($this, $this->guzzle);
    }

    /**
     * Verify incoming request data.
     *
     * @throws InvalidRequest
     */
    public function verifyRequest(): void
    {
        if ($this->request->hasParameters('callback_query')) {
            return;
        }

        if (!$this->request->hasParameters(['message', 'message.from'])) {
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
        $chat = $this->request->getParameter('message.chat');

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
        if ($this->request->hasParameters('callback_query')) {
            $from = $this->request->getParameter('callback_query.from');
        } else {
            $from = $this->request->getParameter('message.from');
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
            $this->guzzle,
            $this->getParameter('token'),
            $this->request->getParameters()
        );
    }
}
