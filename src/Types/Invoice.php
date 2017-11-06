<?php

declare(strict_types=1);

namespace FondBot\Drivers\Telegram\Types;

use FondBot\Drivers\Type;

class Invoice extends Type
{
    private $title;
    private $description;
    private $startParameter;
    private $currency;
    private $totalAmount;

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getStartParameter(): string
    {
        return $this->startParameter;
    }

    public function setStartParameter(string $startParameter): self
    {
        $this->startParameter = $startParameter;

        return $this;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }

    public function setCurrency(string $currency): self
    {
        $this->currency = $currency;

        return $this;
    }

    public function getTotalAmount(): int
    {
        return $this->totalAmount;
    }

    public function setTotalAmount(int $totalAmount): self
    {
        $this->totalAmount = $totalAmount;

        return $this;
    }
}
