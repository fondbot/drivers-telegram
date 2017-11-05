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
use FondBot\Drivers\TemplateCompiler;
use FondBot\Drivers\Telegram\Types\Update;
use FondBot\Drivers\Telegram\Factories\MessageReceivedFactory;

class TelegramDriver extends Driver
{
    private $client;

    /** {@inheritdoc} */
    public function getName(): string
    {
        return 'Telegram';
    }

    /** {@inheritdoc} */
    public function getShortName(): string
    {
        return 'telegram';
    }

    /** {@inheritdoc} */
    public function getDefaultParameters(): array
    {
        return [
            'token' => '',
        ];
    }

    /** {@inheritdoc} */
    public function getTemplateCompiler(): ?TemplateCompiler
    {
        return new TelegramTemplateCompiler;
    }

    /** {@inheritdoc} */
    public function createEvent(Request $request): Event
    {
        $update = Update::createFromJson($request->all());

        if ($message = $update->getMessage()) {
            return MessageReceivedFactory::create($message);
        }

        return new Unknown;
    }

    /** {@inheritdoc} */
    public function sendMessage(Chat $chat, User $recipient, string $text, Template $template = null): void
    {
        if ($template !== null) {
            $replyMarkup = $this->getTemplateCompiler()->compile($template);
        }

        $this->client()->sendMessage(
            $chat->getId(),
            $text,
            null,
            null,
            null,
            null,
            $replyMarkup ?? null
        );
    }

    /** {@inheritdoc} */
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

    /** {@inheritdoc} */
    public function sendRequest(Chat $chat, User $recipient, string $endpoint, array $parameters = []): void
    {
        $this->client()->request($endpoint, $parameters);
    }

    /**
     * Get Telegram client instance.
     *
     * @return TelegramClient
     */
    public function client(): TelegramClient
    {
        if ($this->client === null) {
            $this->client = new TelegramClient(new Client, $this->parameters->get('token'));
        }

        return $this->client;
    }
}
