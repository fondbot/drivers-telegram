<?php

declare(strict_types=1);

namespace FondBot\Drivers\Telegram;

use FondBot\Channels\Chat;
use FondBot\Channels\User;
use FondBot\Channels\Driver;
use FondBot\Contracts\Event;
use Illuminate\Http\Request;
use FondBot\Contracts\Template;
use FondBot\Templates\Attachment;

class TelegramDriver extends Driver
{
    public function getBaseUrl(): string
    {
        return 'https://api.telegram.org/bot'.$this->parameters->get('token');
    }

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
        //        $event = new MessageReceived();
        // TODO: Implement createEvent() method.
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
        $payload = [
            'chat_id' => $chat->getId(),
            'text' => $text,
        ];

        // TODO templates
//        if ($command->getTemplate() !== null) {
//            $payload['reply_markup'] = $this->driver->getTemplateCompiler()->compile($command->getTemplate());
//        }

//        $this->driver->post($this->driver->getBaseUrl().'/sendMessage', ['json' => $payload]);
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

        //        $this->driver->post($this->getBaseUrl().'/'.$endpoint, $payload);
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
        // TODO: Implement sendRequest() method.
    }
}
