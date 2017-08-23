<?php

declare(strict_types=1);

namespace FondBot\Drivers\Telegram\Types;

class ShippingQuery
{
    private $id;
    private $from;
    private $invoicePayload;
    private $shippingAddress;

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): ShippingQuery
    {
        $this->id = $id;

        return $this;
    }

    public function getFrom(): User
    {
        return $this->from;
    }

    public function setFrom(User $from): ShippingQuery
    {
        $this->from = $from;

        return $this;
    }

    public function getInvoicePayload(): string
    {
        return $this->invoicePayload;
    }

    public function setInvoicePayload(string $invoicePayload): ShippingQuery
    {
        $this->invoicePayload = $invoicePayload;

        return $this;
    }

    public function getShippingAddress(): ShippingAddress
    {
        return $this->shippingAddress;
    }

    public function setShippingAddress(ShippingAddress $shippingAddress): ShippingQuery
    {
        $this->shippingAddress = $shippingAddress;

        return $this;
    }
}
