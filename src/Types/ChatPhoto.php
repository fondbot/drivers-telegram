<?php

declare(strict_types=1);

namespace FondBot\Drivers\Telegram\Types;

class ChatPhoto
{
    private $smallFileId;
    private $bigFileId;

    public function getSmallFileId(): string
    {
        return $this->smallFileId;
    }

    public function setSmallFileId(string $smallFileId): ChatPhoto
    {
        $this->smallFileId = $smallFileId;

        return $this;
    }

    public function getBigFileId(): string
    {
        return $this->bigFileId;
    }

    public function setBigFileId(string $bigFileId): ChatPhoto
    {
        $this->bigFileId = $bigFileId;

        return $this;
    }
}
