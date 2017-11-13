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
use FondBot\Events\MessageReceived;
use FondBot\Drivers\TemplateCompiler;
use FondBot\Drivers\Telegram\Types\Update;

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
    public function getClient(): TelegramClient
    {
        if ($this->client === null) {
            $this->client = new TelegramClient(new Client, $this->parameters->get('token'));
        }

        return $this->client;
    }

    /** {@inheritdoc} */
    public function createEvent(Request $request): Event
    {
        $update = Update::createFromJson($request->all());

        if ($message = $update->getMessage()) {
            $chat = Chat::create((string) $message->getChat()->getId(), $message->getChat()->getTitle(), $message->getChat()->getType());
            $from = User::create((string) $message->getFrom()->getId(), $message->getFrom()->getFirstName(), $message->getFrom()->getUsername());

            return new MessageReceived(
                $chat,
                $from,
                $message->getText(),
                $message->getLocation(),
                null,
                optional($update->getCallbackQuery())->getData()
            );
        }

        if ($callbackQuery = $update->getCallbackQuery()) {
            $message = $callbackQuery->getMessage();

            $chat = Chat::create((string) $message->getChat()->getId(), $message->getChat()->getTitle(), $message->getChat()->getType());
            $from = User::create((string) $message->getFrom()->getId(), $message->getFrom()->getFirstName(), $message->getFrom()->getUsername());

            return new MessageReceived(
                $chat,
                $from,
                $message->getText(),
                $message->getLocation(),
                null,
                $callbackQuery->getData()
            );
        }

        return new Unknown;
    }

    /** {@inheritdoc} */
    public function sendMessage(Chat $chat, User $recipient, string $text, Template $template = null): void
    {
        if ($template !== null) {
            $replyMarkup = $this->getTemplateCompiler()->compile($template);
        }

        $this->getClient()->sendMessage(
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

        switch ($type) {
            case Attachment::TYPE_FILE:
                $this->getClient()->sendDocument(
                    $chat->getId(),
                    $attachment->getPath(),
                    $attachment->getParameters()->get('caption'),
                    $attachment->getParameters()->get('disable_notification'),
                    $attachment->getParameters()->get('reply_to_message_id'),
                    $attachment->getParameters()->get('reply_markup')
                );
                break;

            case Attachment::TYPE_IMAGE:
                $this->getClient()->sendPhoto(
                    $chat->getId(),
                    $attachment->getPath(),
                    $attachment->getParameters()->get('caption'),
                    $attachment->getParameters()->get('disable_notification'),
                    $attachment->getParameters()->get('reply_to_message_id'),
                    $attachment->getParameters()->get('reply_markup')
                );
                break;

            case Attachment::TYPE_AUDIO:
                $this->getClient()->sendAudio(
                    $chat->getId(),
                    $attachment->getPath(),
                    $attachment->getParameters()->get('caption'),
                    $attachment->getParameters()->get('duration'),
                    $attachment->getParameters()->get('performer'),
                    $attachment->getParameters()->get('title'),
                    $attachment->getParameters()->get('disable_notification'),
                    $attachment->getParameters()->get('reply_to_message_id'),
                    $attachment->getParameters()->get('reply_markup')
                );
                break;

            case Attachment::TYPE_VIDEO:
                $this->getClient()->sendVideo(
                    $chat->getId(),
                    $attachment->getPath(),
                    $attachment->getParameters()->get('duration'),
                    $attachment->getParameters()->get('width'),
                    $attachment->getParameters()->get('height'),
                    $attachment->getParameters()->get('caption'),
                    $attachment->getParameters()->get('disable_notification'),
                    $attachment->getParameters()->get('reply_to_message_id'),
                    $attachment->getParameters()->get('reply_markup')
                );
                break;
        }
    }

    /** {@inheritdoc} */
    public function sendRequest(Chat $chat, User $recipient, string $endpoint, array $parameters = []): void
    {
        $this->getClient()->post($endpoint, $parameters);
    }
}
