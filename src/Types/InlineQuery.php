<?php

declare(strict_types=1);

namespace FondBot\Drivers\Telegram\Types;

use FondBot\Drivers\Type;

class InlineQuery extends Type
{
    private $id;
    private $from;
    private $location;
    private $query;
    private $offset;

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): InlineQuery
    {
        $this->id = $id;

        return $this;
    }

    public function getFrom(): User
    {
        return $this->from;
    }

    public function setFrom(User $from): InlineQuery
    {
        $this->from = $from;

        return $this;
    }

    public function getLocation(): ?Location
    {
        return $this->location;
    }

    public function setLocation(?Location $location): InlineQuery
    {
        $this->location = $location;

        return $this;
    }

    public function getQuery(): string
    {
        return $this->query;
    }

    public function setQuery(string $query): InlineQuery
    {
        $this->query = $query;

        return $this;
    }

    public function getOffset(): string
    {
        return $this->offset;
    }

    public function setOffset(string $offset): InlineQuery
    {
        $this->offset = $offset;

        return $this;
    }
}
