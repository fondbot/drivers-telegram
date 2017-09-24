<?php

declare(strict_types=1);

namespace FondBot\Drivers\Telegram\Types;

use FondBot\Drivers\Type;

class MessageEntity extends Type
{
    private $type;
    private $offset;
    private $length;
    private $url;
    private $user;

    public function getType(): string
    {
        return $this->type;
    }

    public function setType(string $type): MessageEntity
    {
        $this->type = $type;

        return $this;
    }

    public function getOffset(): int
    {
        return $this->offset;
    }

    public function setOffset(int $offset): MessageEntity
    {
        $this->offset = $offset;

        return $this;
    }

    public function getLength(): int
    {
        return $this->length;
    }

    public function setLength(int $length): MessageEntity
    {
        $this->length = $length;

        return $this;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(?string $url): MessageEntity
    {
        $this->url = $url;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): MessageEntity
    {
        $this->user = $user;

        return $this;
    }
}
