<?php

declare(strict_types=1);

namespace FondBot\Drivers\Telegram\Types;

use FondBot\Drivers\Type;

class VideoNote extends Type
{
    private $fileId;
    private $length;
    private $duration;
    private $thumb;
    private $fileSize;

    public function getFileId(): string
    {
        return $this->fileId;
    }

    public function setFileId(string $fileId): self
    {
        $this->fileId = $fileId;

        return $this;
    }

    public function getLength(): int
    {
        return $this->length;
    }

    public function setLength(int $length): self
    {
        $this->length = $length;

        return $this;
    }

    public function getDuration(): int
    {
        return $this->duration;
    }

    public function setDuration(int $duration): self
    {
        $this->duration = $duration;

        return $this;
    }

    public function getThumb(): ?PhotoSize
    {
        return $this->thumb;
    }

    public function setThumb(?PhotoSize $thumb): self
    {
        $this->thumb = $thumb;

        return $this;
    }

    public function getFileSize(): ?int
    {
        return $this->fileSize;
    }

    public function setFileSize(?int $fileSize): self
    {
        $this->fileSize = $fileSize;

        return $this;
    }
}
