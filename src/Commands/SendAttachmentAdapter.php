<?php

declare(strict_types=1);

namespace FondBot\Drivers\Telegram\Commands;

use FondBot\Contracts\Arrayable;
use FondBot\Templates\Attachment;
use FondBot\Drivers\Commands\SendAttachment;

class SendAttachmentAdapter implements Arrayable
{
    private $command;

    public function __construct(SendAttachment $command)
    {
        $this->command = $command;
    }

    /**
     * Get API method name.
     *
     * @return null|string
     */
    public function getMethod(): ?string
    {
        switch ($this->command->attachment->getType()) {
            case Attachment::TYPE_IMAGE:
                return 'sendPhoto';
            case Attachment::TYPE_AUDIO:
                return 'sendAudio';
            case Attachment::TYPE_FILE:
                return 'sendDocument';
            case Attachment::TYPE_VIDEO:
                return 'sendVideo';
        }

        return null;
    }

    /**
     * Get the instance as an array.
     *
     * @return array
     */
    public function toArray(): array
    {
        return [
            'multipart' => [
                [
                    'name' => 'chat_id',
                    'contents' => $this->command->chat->getId(),
                ],
                [
                    'name' => $this->getKeyName(),
                    'contents' => fopen($this->command->attachment->getPath(), 'rb'),
                ],
            ],
        ];
    }

    private function getKeyName(): string
    {
        switch ($this->command->attachment->getType()) {
            case Attachment::TYPE_IMAGE:
                return 'photo';
            case Attachment::TYPE_AUDIO:
                return 'audio';
            case Attachment::TYPE_VIDEO:
                return 'video';
            default:
                return 'document';
        }
    }
}
