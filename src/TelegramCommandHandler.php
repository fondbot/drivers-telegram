<?php

declare(strict_types=1);

namespace FondBot\Drivers\Telegram;

use GuzzleHttp\Client;
use FondBot\Drivers\Driver;
use FondBot\Templates\Attachment;
use FondBot\Drivers\CommandHandler;
use FondBot\Drivers\Commands\SendMessage;
use FondBot\Drivers\Commands\SendRequest;
use FondBot\Drivers\Commands\SendAttachment;

class TelegramCommandHandler extends CommandHandler
{
    private $guzzle;

    /** @var TelegramDriver */
    protected $driver;

    public function __construct(Driver $driver, Client $guzzle)
    {
        parent::__construct($driver);
        $this->guzzle = $guzzle;
    }

    public function handleSendMessage(SendMessage $command): void
    {
        $payload = [
            'chat_id' => $command->getChat()->getId(),
            'text' => $command->getText(),
        ];

        if ($command->getTemplate() !== null) {
            $payload['reply_markup'] = $this->driver->getTemplateCompiler()->compile($command->getTemplate());
        }

        $this->guzzle->post($this->driver->getBaseUrl().'/sendMessage', ['form_params' => $payload]);
    }

    public function handleSendAttachment(SendAttachment $command): void
    {
        switch ($command->getAttachment()->getType()) {
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
                    'contents' => $command->getChat()->getId(),
                ],
                [
                    'name' => $type,
                    'filename' => $command->getAttachment()->getPath(),
                ],
            ],
        ];

        $this->guzzle->post($this->driver->getBaseUrl().'/'.$endpoint, $payload);
    }

    public function handleSendRequest(SendRequest $command): void
    {
    }
}
