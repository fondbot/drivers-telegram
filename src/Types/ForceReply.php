<?php

declare(strict_types=1);

namespace FondBot\Drivers\Telegram\Types;

use FondBot\Drivers\Type;

class ForceReply extends Type
{
    private $forceReply = true;
    private $selective;

    public function getForceReply(): bool
    {
        return $this->forceReply;
    }

    public function setForceReply(bool $forceReply): self
    {
        $this->forceReply = $forceReply;

        return $this;
    }

    public function getSelective(): ?bool
    {
        return $this->selective;
    }

    public function setSelective(?bool $selective): self
    {
        $this->selective = $selective;

        return $this;
    }
}
