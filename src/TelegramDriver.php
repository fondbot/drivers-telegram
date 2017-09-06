<?php

declare(strict_types=1);

namespace FondBot\Drivers\Telegram;

use GuzzleHttp\Client;
use FondBot\Channels\Chat;
use FondBot\Channels\User;
use FondBot\Events\Unknown;
use FondBot\Channels\Driver;
use FondBot\Contracts\Event;
use Illuminate\Http\Request;
use FondBot\Contracts\Template;
use FondBot\Templates\Attachment;
use FondBot\Drivers\Telegram\Types\Update;
use FondBot\Drivers\Telegram\Factories\MessageReceivedFactory;

class TelegramDriver extends Driver
{
    private $client;

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
     * Create event based on incoming request.
     *
     * @param Request $request
     *
     * @return Event
     */
    public function createEvent(Request $request): Event
    {
        $update = Update::fromJson($request->all());

        if ($message = $update->getMessage()) {
            return MessageReceivedFactory::create($message);
        }

        return new Unknown;
    }

    /**
     * Send message.
     *
     * @param Chat $chat
     * @param User $recipient
     * @param string $text
     * @param Template|null $template
     */
    public function sendMessage(Chat $chat, User $recipient, string $text, Template $template = null): void
    {
        if ($template !== null) {
            $replyMarkup = $this->compileTemplate($template);
        }

        $this->client()->sendMessage($chat->getId(), $text, null, null, null, null, $replyMarkup ?? null);
    }

    /**
     * Send attachment.
     *
     * @param Chat $chat
     * @param User $recipient
     * @param Attachment $attachment
     */
    public function sendAttachment(Chat $chat, User $recipient, Attachment $attachment): void
    {
        $type = $attachment->getType();

        if ($type === 'photo') {
            $this->client()->sendPhoto($chat->getId(), $photo);

            return;
        }

        switch ($attachment->getType()) {
            case Attachment::TYPE_IMAGE:
                $type = 'photo';
                $endpoint = 'sendPhoto';
                break;
            case Attachment::TYPE_AUDIO:
                $type = 'audio';
                $endpoint = 'sendAudio';
                break;
            case Attachment::TYPE_VIDEO:
                $type = 'video';
                $endpoint = 'sendVideo';
                break;
            default:
                $type = 'document';
                $endpoint = 'sendDocument';
                break;
        }

        $payload = [
            'multipart' => [
                [
                    'name' => 'chat_id',
                    'contents' => $chat->getId(),
                ],
                [
                    'name' => $type,
                    'contents' => fopen($attachment->getPath(), 'rb'),
                ],
            ],
        ];
    }

    /**
     * Send low-level request.
     *
     * @param Chat $chat
     * @param User $recipient
     * @param string $endpoint
     * @param array $parameters
     */
    public function sendRequest(Chat $chat, User $recipient, string $endpoint, array $parameters = []): void
    {
        $this->client()->request($endpoint, $parameters);
    }

    private function compileTemplate(Template $template): ?array
    {
        return (new TelegramTemplateCompiler)->compile($template);
    }

    /**
     * Get Telegram client instance.
     *
     * @return TelegramClient
     */
    private function client(): TelegramClient
    {
        if ($this->client === null) {
            $this->client = new TelegramClient(new Client, $this->parameters->get('token'));
        }

        return $this->client;
    }
}
