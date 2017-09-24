<?php

declare(strict_types=1);

namespace FondBot\Drivers\Telegram\Types;

use FondBot\Drivers\Type;

class ResponseParameters extends Type
{
    private $migrateToChatId;
    private $retryAfter;

    public function getMigrateToChatId(): ?int
    {
        return $this->migrateToChatId;
    }

    public function setMigrateToChatId(?int $migrateToChatId): ResponseParameters
    {
        $this->migrateToChatId = $migrateToChatId;

        return $this;
    }

    public function getRetryAfter(): ?int
    {
        return $this->retryAfter;
    }

    public function setRetryAfter(?int $retryAfter): ResponseParameters
    {
        $this->retryAfter = $retryAfter;

        return $this;
    }
}
