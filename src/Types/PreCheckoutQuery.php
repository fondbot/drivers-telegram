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

    public function setId(string $id): PreCheckoutQuery
    {
        $this->id = $id;

        return $this;
    }

    public function getFrom(): User
    {
        return $this->from;
    }

    public function setFrom(User $from): PreCheckoutQuery
    {
        $this->from = $from;

        return $this;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }

    public function setCurrency(string $currency): PreCheckoutQuery
    {
        $this->currency = $currency;

        return $this;
    }

    public function getTotalAmount(): int
    {
        return $this->totalAmount;
    }

    public function setTotalAmount(int $totalAmount): PreCheckoutQuery
    {
        $this->totalAmount = $totalAmount;

        return $this;
    }

    public function getInvoicePayload(): string
    {
        return $this->invoicePayload;
    }

    public function setInvoicePayload(string $invoicePayload): PreCheckoutQuery
    {
        $this->invoicePayload = $invoicePayload;

        return $this;
    }

    public function getShippingOptionId(): ?string
    {
        return $this->shippingOptionId;
    }

    public function setShippingOptionId(?string $shippingOptionId): PreCheckoutQuery
    {
        $this->shippingOptionId = $shippingOptionId;

        return $this;
    }

    public function getOrderInfo(): ?OrderInfo
    {
        return $this->orderInfo;
    }

    public function setOrderInfo(?OrderInfo $orderInfo): PreCheckoutQuery
    {
        $this->orderInfo = $orderInfo;

        return $this;
    }
}
