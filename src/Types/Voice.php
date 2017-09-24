<?php

declare(strict_types=1);

namespace FondBot\Drivers\Telegram\Types;

use FondBot\Drivers\Type;

class Voice extends Type
{
    private $fileId;
    private $duration;
    private $mimeType;
    private $fileSize;

    public function getFileId(): string
    {
        return $this->fileId;
    }

    public function setFileId(string $fileId): Voice
    {
        $this->fileId = $fileId;

        return $this;
    }

    public function getDuration(): int
    {
        return $this->duration;
    }

    public function setDuration(int $duration): Voice
    {
        $this->duration = $duration;

        return $this;
    }

    public function getMimeType(): ?string
    {
        return $this->mimeType;
    }

    public function setMimeType(?string $mimeType): Voice
    {
        $this->mimeType = $mimeType;

        return $this;
    }

    public function getFileSize(): ?int
    {
        return $this->fileSize;
    }

    public function setFileSize(?int $fileSize): Voice
    {
        $this->fileSize = $fileSize;

        return $this;
    }
}
