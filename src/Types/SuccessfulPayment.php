<?php

declare(strict_types=1);

namespace FondBot\Drivers\Telegram\Types;

use FondBot\Drivers\Type;

class SuccessfulPayment extends Type
{
    private $currency;
    private $totalAmount;
    private $invoicePayload;
    private $shippingOptionId;
    private $orderInfo;
    private $telegramPaymentChargeId;
    private $providerPaymentChargeId;

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

    public function getTelegramPaymentChargeId(): string
    {
        return $this->telegramPaymentChargeId;
    }

    public function setTelegramPaymentChargeId(string $telegramPaymentChargeId): self
    {
        $this->telegramPaymentChargeId = $telegramPaymentChargeId;

        return $this;
    }

    public function getProviderPaymentChargeId(): string
    {
        return $this->providerPaymentChargeId;
    }

    public function setProviderPaymentChargeId(string $providerPaymentChargeId): self
    {
        $this->providerPaymentChargeId = $providerPaymentChargeId;

        return $this;
    }
}
