<?php

declare(strict_types=1);

namespace FondBot\Drivers\Telegram\Types;

class ForceReply
{
    private $forceReply = true;
    private $selective;

    public function getForceReply(): bool
    {
        return $this->forceReply;
    }

    public function setForceReply(bool $forceReply): ForceReply
    {
        $this->forceReply = $forceReply;

        return $this;
    }

    public function getSelective(): ?bool
    {
        return $this->selective;
    }

    public function setSelective(?bool $selective): ForceReply
    {
        $this->selective = $selective;

        return $this;
    }
}
