<?php

declare(strict_types=1);

namespace FondBot\Drivers\Telegram\Types;

use FondBot\Drivers\Type;

class File extends Type
{
    private $fileId;
    private $fileSize;
    private $filePath;

    public function getFileId(): string
    {
        return $this->fileId;
    }

    public function setFileId(string $fileId): self
    {
        $this->fileId = $fileId;

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

    public function getFilePath(): ?string
    {
        return $this->filePath;
    }

    public function setFilePath(?string $filePath): self
    {
        $this->filePath = $filePath;

        return $this;
    }
}
