<?php

declare(strict_types=1);

namespace FondBot\Drivers\Telegram;

use GuzzleHttp\Client;
use FondBot\Drivers\Chat;
use FondBot\Drivers\User;
use FondBot\Drivers\Driver;
use FondBot\Drivers\Command;
use FondBot\Drivers\ReceivedMessage;
use FondBot\Drivers\Commands\SendMessage;
use GuzzleHttp\Exception\ClientException;
use FondBot\Drivers\Commands\SendAttachment;
use FondBot\Drivers\Exceptions\InvalidRequest;
use FondBot\Drivers\ReceivedMessage\Attachment;

class TelegramDriver extends Driver
{
    private $guzzle;

    public function __construct(Client $guzzle)
    {
        $this->guzzle = $guzzle;
    }

    /**
     * Configuration parameters.
     *
     * @return array
     */
    public function getConfig(): array
    {
        return [
            'token',
        ];
    }

    /**
     * Verify incoming request data.
     *
     * @throws InvalidRequest
     */
    public function verifyRequest(): void
    {
        if ($this->hasRequest('callback_query')) {
            return;
        }

        if (
            !$this->hasRequest('message') ||
            !$this->hasRequest('message.from')
        ) {
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
        $chat = $this->getRequest('message.chat');

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
        if ($this->hasRequest('callback_query')) {
            $from = $this->getRequest('callback_query.from');
        } else {
            $from = $this->getRequest('message.from');
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
            $this->getRequest()
        );
    }

    /**
     * Handle command.
     *
     * @param Command $command
     *
     * @throws InvalidRequest
     */
    public function handle(Command $command): void
    {
        try {
            if ($command instanceof SendMessage) {
                $this->handleSendMessageCommand($command);
            } elseif ($command instanceof SendAttachment) {
                $this->handleSendAttachmentCommand($command);
            }
        } catch (ClientException $exception) {
            if ($exception->getCode() === 400) {
                throw new InvalidRequest($exception->getMessage());
            }
        }
    }

    /**
     * Send message to recipient.
     *
     * @param SendMessage $command
     */
    private function handleSendMessageCommand(SendMessage $command): void
    {
        $message = new TelegramOutgoingMessage($command);

        $this->guzzle->post($this->getBaseUrl().'/sendMessage', [
            'form_params' => $message->toArray(),
        ]);
    }

    /**
     * Send attachment to recipient.
     *
     * @param SendAttachment $command
     */
    private function handleSendAttachmentCommand(SendAttachment $command): void
    {
        switch ($command->attachment->getType()) {
            case Attachment::TYPE_IMAGE:
                $this->guzzle->post($this->getBaseUrl().'/sendPhoto', [
                    'multipart' => [
                        [
                            'name' => 'chat_id',
                            'contents' => $command->chat->getId(),
                        ],
                        [
                            'name' => 'photo',
                            'contents' => fopen($command->attachment->getPath(), 'rb'),
                        ],
                    ],
                ]);
                break;
        }
    }

    private function getBaseUrl(): string
    {
        return 'https://api.telegram.org/bot'.$this->getParameter('token');
    }
}
