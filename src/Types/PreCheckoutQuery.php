<?php

declare(strict_types=1);

namespace FondBot\Drivers\Telegram\Types;

use FondBot\Drivers\Type;

class PreCheckoutQuery extends Type
{
    private $id;
    private $from;
    private $currency;
    private $totalAmount;
    private $invoicePayload;
    private $shippingOptionId;
    private $orderInfo;

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getFrom(): User
    {
        return $this->from;
    }

    public function setFrom(User $from): self
    {
        $this->from = $from;

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

    public function getInvoicePayload(): string
    {
        return $this->invoicePayload;
    }

    public function setInvoicePayload(string $invoicePayload): self
    {
        $this->invoicePayload = $invoicePayload;

        return $this;
    }

    public function getShippingOptionId(): ?string
    {
        return $this->shippingOptionId;
    }

    public function setShippingOptionId(?string $shippingOptionId): self
    {
        $this->shippingOptionId = $shippingOptionId;

        return $this;
    }

    public function getOrderInfo(): ?OrderInfo
    {
        return $this->orderInfo;
    }

    public function setOrderInfo(?OrderInfo $orderInfo): self
    {
        $this->orderInfo = $orderInfo;

        return $this;
    }
}
