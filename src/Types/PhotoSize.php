<?php

declare(strict_types=1);

namespace FondBot\Drivers\Telegram\Types;

use FondBot\Drivers\Type;

class PhotoSize extends Type
{
    private $fileId;
    private $width;
    private $height;
    private $fileSize;

    public function getFileId(): string
    {
        return $this->fileId;
    }

    public function setFileId(string $fileId): PhotoSize
    {
        $this->fileId = $fileId;

        return $this;
    }

    public function getWidth(): int
    {
        return $this->width;
    }

    public function setWidth(int $width): PhotoSize
    {
        $this->width = $width;

        return $this;
    }

    public function getHeight(): int
    {
        return $this->height;
    }

    public function setHeight(int $height): PhotoSize
    {
        $this->height = $height;

        return $this;
    }

    public function getFileSize(): ?int
    {
        return $this->fileSize;
    }

    public function setFileSize(?int $fileSize): PhotoSize
    {
        $this->fileSize = $fileSize;

        return $this;
    }
}
