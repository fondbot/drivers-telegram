<?php

declare(strict_types=1);

namespace FondBot\Drivers\Telegram;

use FondBot\Drivers\Commands\SendRequest;
use FondBot\Drivers\Telegram\Commands\SendRequestAdapter;
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
use FondBot\Drivers\Telegram\Commands\SendMessageAdapter;
use FondBot\Drivers\Telegram\Commands\SendAttachmentAdapter;

class TelegramDriver extends Driver
{
    private $guzzle;

    public function __construct(Client $guzzle)
    {
        $this->guzzle = $guzzle;
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
            } elseif ($command instanceof SendRequest) {
                $this->handleSendRequestCommand($command);
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
        $message = new SendMessageAdapter($command);

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
        $adapter = new SendAttachmentAdapter($command);

        $this->guzzle->post($this->getBaseUrl().'/'.$adapter->getEndpoint(), $adapter->toArray());
    }

    /**
     * Send request to Telegram.
     *
     * @param SendRequest $command
     */
    private function handleSendRequestCommand(SendRequest $command): void
    {
        $adapter = new SendRequestAdapter($command);

        $this->guzzle->post($this->getBaseUrl().'/'.$adapter->getEndpoint(), $adapter->toArray());
    }

    private function getBaseUrl(): string
    {
        return 'https://api.telegram.org/bot'.$this->getParameter('token');
    }
}
