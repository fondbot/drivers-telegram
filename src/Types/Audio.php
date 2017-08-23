<?php

declare(strict_types=1);

namespace FondBot\Drivers\Telegram\Types;

use FondBot\Drivers\Telegram\Type;

class Audio extends Type
{
    private $fileId;
    private $duration;
    private $performer;
    private $title;
    private $mimeType;
    private $fileSize;

    public function getFileId(): string
    {
        return $this->fileId;
    }

    public function setFileId(string $fileId): Audio
    {
        $this->fileId = $fileId;

        return $this;
    }

    public function getDuration(): int
    {
        return $this->duration;
    }

    public function setDuration(int $duration): Audio
    {
        $this->duration = $duration;

        return $this;
    }

    public function getPerformer(): ?string
    {
        return $this->performer;
    }

    public function setPerformer(?string $performer): Audio
    {
        $this->performer = $performer;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): Audio
    {
        $this->title = $title;

        return $this;
    }

    public function getMimeType(): ?string
    {
        return $this->mimeType;
    }

    public function setMimeType(?string $mimeType): Audio
    {
        $this->mimeType = $mimeType;

        return $this;
    }

    public function getFileSize(): ?int
    {
        return $this->fileSize;
    }

    public function setFileSize(?int $fileSize): Audio
    {
        $this->fileSize = $fileSize;

        return $this;
    }
}
