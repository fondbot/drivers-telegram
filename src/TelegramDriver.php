<?php

declare(strict_types=1);

namespace FondBot\Drivers\Telegram;

use FondBot\Channels\Chat;
use FondBot\Channels\User;
use FondBot\Events\Unknown;
use FondBot\Channels\Driver;
use FondBot\Contracts\Event;
use Illuminate\Http\Request;
use React\EventLoop\Factory;
use FondBot\Contracts\Template;
use unreal4u\TelegramAPI\TgLog;
use FondBot\Templates\Attachment;
use React\EventLoop\LoopInterface;
use FondBot\Events\MessageReceived;
use unreal4u\TelegramAPI\Telegram\Types\Update;
use unreal4u\TelegramAPI\HttpClientRequestHandler;
use unreal4u\TelegramAPI\Telegram\Methods\SendAudio;
use unreal4u\TelegramAPI\Telegram\Methods\SendPhoto;
use unreal4u\TelegramAPI\Telegram\Methods\SendVideo;
use unreal4u\TelegramAPI\Telegram\Methods\SendMessage;
use unreal4u\TelegramAPI\Telegram\Methods\SendDocument;
use unreal4u\TelegramAPI\Telegram\Types\Custom\InputFile;

/**
 * @method TgLog getClient()
 */
class TelegramDriver extends Driver
{
    protected $token;

    /** @var TgLog */
    protected $client;

    /** @var LoopInterface */
    private $loop;

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
     * Create API client.
     *
     * @return mixed
     */
    public function createClient(): TgLog
    {
        $this->loop = Factory::create();
        $handler = new HttpClientRequestHandler($this->loop);

        return new TgLog($this->token, $handler);
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
        if (empty($request->input())) {
            return new Unknown();
        }

        $update = new Update($request->input());

        if ($message = $update->message) {
            $chat = new Chat((string) $message->chat->id, $message->chat->title, $message->chat->type);
            $from = new User((string) $message->from->id, $message->from->first_name, $message->from->username);

            return new MessageReceived(
                $chat,
                $from,
                $message->text,
                $message->location,
                null,
                optional($update->callback_query)->data,
                $update
            );
        }

        if ($callbackQuery = $update->callback_query) {
            $message = $callbackQuery->message;

            $chat = new Chat((string) $message->chat->id, $message->chat->title, $message->chat->type);
            $from = new User((string) $message->chat->id, $message->from->first_name, $message->from->username);

            return new MessageReceived(
                $chat,
                $from,
                $message->text,
                $message->location,
                null,
                $callbackQuery->data,
                $update
            );
        }

        return new Unknown();
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
        $sendMessage = new SendMessage();

        if ($template !== null) {
            $sendMessage->reply_markup = $this->templateCompiler->compile($template);
        }

        $sendMessage->chat_id = $chat->getId();
        $sendMessage->text = $text;

        $this->client->performApiRequest($sendMessage);
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

        $request = null;

        switch ($type) {
            case Attachment::TYPE_FILE:
                $request = new SendDocument();
                $request->document = new InputFile($attachment->getPath());
                $request->caption = $attachment->getParameters()->get('caption');
                break;

            case Attachment::TYPE_IMAGE:
                $request = new SendPhoto();
                $request->caption = $attachment->getParameters()->get('caption');
                break;

            case Attachment::TYPE_AUDIO:
                $request = new SendAudio();
                $request->chat_id = $chat->getId();
                $request->caption = $attachment->getParameters()->get('caption');
                $request->duration = $attachment->getParameters()->get('duration');
                $request->performer = $attachment->getParameters()->get('performer');
                $request->title = $attachment->getParameters()->get('title');

                break;

            case Attachment::TYPE_VIDEO:
                $request = new SendVideo();
                $request->duration = $attachment->getParameters()->get('duration');
                $request->width = $attachment->getParameters()->get('width');
                $request->height = $attachment->getParameters()->get('height');
                $request->caption = $attachment->getParameters()->get('caption');
                break;
        }

        if ($request) {
            $request->chat_id = $chat->getId();
            $request->disable_notification = $attachment->getParameters()->get('disable_notification');
            $request->reply_to_message_id = $attachment->getParameters()->get('reply_to_message_id');
            $request->reply_markup = $attachment->getParameters()->get('reply_markup');

            $this->client->performApiRequest($request);
        }
    }

    public function __destruct()
    {
        if ($this->loop) {
            $this->loop->run();
        }
    }
}
