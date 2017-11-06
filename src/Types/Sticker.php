<?php

declare(strict_types=1);

namespace FondBot\Drivers\Telegram\Types;

use FondBot\Drivers\Type;

class Sticker extends Type
{
    private $fileId;
    private $width;
    private $height;
    private $thumb;
    private $emoji;
    private $setName;
    private $maskPosition;
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

    public function getWidth(): int
    {
        return $this->width;
    }

    public function setWidth(int $width): self
    {
        $this->width = $width;

        return $this;
    }

    public function getHeight(): int
    {
        return $this->height;
    }

    public function setHeight(int $height): self
    {
        $this->height = $height;

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

    public function getEmoji(): ?string
    {
        return $this->emoji;
    }

    public function setEmoji(?string $emoji): self
    {
        $this->emoji = $emoji;

        return $this;
    }

    public function getSetName(): ?string
    {
        return $this->setName;
    }

    public function setSetName(?string $setName): self
    {
        $this->setName = $setName;

        return $this;
    }

    public function getMaskPosition(): ?MaskPosition
    {
        return $this->maskPosition;
    }

    public function setMaskPosition(?MaskPosition $maskPosition): self
    {
        $this->maskPosition = $maskPosition;

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
