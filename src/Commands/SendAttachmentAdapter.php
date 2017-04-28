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
     * Determine if attachment type is supported.
     *
     * @return bool
     */
    public function isSupported(): bool
    {
        return $this->command->attachment->getType() === Attachment::TYPE_IMAGE;
    }

    /**
     * Get API URI.
     *
     * @return null|string
     */
    public function getUri(): ?string
    {
        switch ($this->command->attachment->getType()) {
            case Attachment::TYPE_IMAGE:
                return 'sendPhoto';
            case Attachment::TYPE_AUDIO:
                return 'sendAudio';
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
        switch ($this->command->attachment->getType()) {
            case Attachment::TYPE_IMAGE:
                return [
                    'multipart' => [
                        [
                            'name' => 'chat_id',
                            'contents' => $this->command->chat->getId(),
                        ],
                        [
                            'name' => 'photo',
                            'contents' => fopen($this->command->attachment->getPath(), 'rb'),
                        ],
                    ],
                ];
            case Attachment::TYPE_AUDIO:
                return [
                    'multipart' => [
                        [
                            'name' => 'chat_id',
                            'contents' => $this->command->chat->getId(),
                        ],
                        [
                            'name' => 'photo',
                            'contents' => fopen($this->command->attachment->getPath(), 'rb'),
                        ],
                    ],
                ];
        }

        return [];
    }
}
