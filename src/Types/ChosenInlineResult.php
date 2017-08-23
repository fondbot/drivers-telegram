<?php

declare(strict_types=1);

namespace FondBot\Drivers\Telegram\Types;

class ChosenInlineResult
{
    private $resultId;
    private $from;
    private $location;
    private $inlineMessageId;
    private $query;

    public function getResultId(): string
    {
        return $this->resultId;
    }

    public function setResultId(string $resultId): ChosenInlineResult
    {
        $this->resultId = $resultId;

        return $this;
    }

    public function getFrom(): User
    {
        return $this->from;
    }

    public function setFrom(User $from): ChosenInlineResult
    {
        $this->from = $from;

        return $this;
    }

    public function getLocation(): ?Location
    {
        return $this->location;
    }

    public function setLocation(?Location $location): ChosenInlineResult
    {
        $this->location = $location;

        return $this;
    }

    public function getInlineMessageId(): ?string
    {
        return $this->inlineMessageId;
    }

    public function setInlineMessageId(?string $inlineMessageId): ChosenInlineResult
    {
        $this->inlineMessageId = $inlineMessageId;

        return $this;
    }

    public function getQuery(): string
    {
        return $this->query;
    }

    public function setQuery(string $query): ChosenInlineResult
    {
        $this->query = $query;

        return $this;
    }
}
