<?php

declare(strict_types=1);

namespace FondBot\Drivers\Telegram;

use GuzzleHttp\Client;
use FondBot\Drivers\User;
use FondBot\Drivers\Driver;
use FondBot\Conversation\Keyboard;
use FondBot\Drivers\OutgoingMessage;
use FondBot\Drivers\ReceivedMessage;
use FondBot\Drivers\Exceptions\InvalidRequest;
use FondBot\Drivers\Extensions\WebhookInstallation;

class TelegramDriver extends Driver implements WebhookInstallation
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
     * Initialize webhook in the external service.
     *
     * @param string $url
     */
    public function installWebhook(string $url): void
    {
        $this->guzzle->post($this->getBaseUrl() . '/setWebhook', [
            'form_params' => [
                'url' => $url,
            ],
        ]);
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
            (string)$from['id'],
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
     * Send reply to participant.
     *
     * @param User $sender
     * @param string $text
     * @param Keyboard|null $keyboard
     *
     * @return OutgoingMessage
     */
    public function sendMessage(User $sender, string $text, Keyboard $keyboard = null): OutgoingMessage
    {
        $message = new TelegramOutgoingMessage($sender, $text, $keyboard);

        $this->guzzle->post($this->getBaseUrl() . '/sendMessage', [
            'form_params' => $message->toArray(),
        ]);

        return $message;
    }

    private function getBaseUrl(): string
    {
        return 'https://api.telegram.org/bot' . $this->getParameter('token');
    }
}
