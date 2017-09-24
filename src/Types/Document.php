<?php

declare(strict_types=1);

namespace FondBot\Drivers\Telegram\Types;

use FondBot\Drivers\Type;

class Document extends Type
{
    private $fileId;
    private $thumb;
    private $fileName;
    private $mimeType;
    private $fileSize;

    public function getFileId(): string
    {
        return $this->fileId;
    }

    public function setFileId(string $fileId): Document
    {
        $this->fileId = $fileId;

        return $this;
    }

    public function getThumb(): ?PhotoSize
    {
        return $this->thumb;
    }

    public function setThumb(?PhotoSize $thumb): Document
    {
        $this->thumb = $thumb;

        return $this;
    }

    public function getFileName(): ?string
    {
        return $this->fileName;
    }

    public function setFileName(?string $fileName): Document
    {
        $this->fileName = $fileName;

        return $this;
    }

    public function getMimeType(): ?string
    {
        return $this->mimeType;
    }

    public function setMimeType(?string $mimeType): Document
    {
        $this->mimeType = $mimeType;

        return $this;
    }

    public function getFileSize(): ?int
    {
        return $this->fileSize;
    }

    public function setFileSize(?int $fileSize): Document
    {
        $this->fileSize = $fileSize;

        return $this;
    }
}
