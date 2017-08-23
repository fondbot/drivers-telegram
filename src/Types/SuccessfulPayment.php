<?php

declare(strict_types=1);

namespace FondBot\Drivers\Telegram\Types;

class SuccessfulPayment
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

    public function setCurrency(string $currency): SuccessfulPayment
    {
        $this->currency = $currency;

        return $this;
    }

    public function getTotalAmount(): int
    {
        return $this->totalAmount;
    }

    public function setTotalAmount(int $totalAmount): SuccessfulPayment
    {
        $this->totalAmount = $totalAmount;

        return $this;
    }

    public function getInvoicePayload(): string
    {
        return $this->invoicePayload;
    }

    public function setInvoicePayload(string $invoicePayload): SuccessfulPayment
    {
        $this->invoicePayload = $invoicePayload;

        return $this;
    }

    public function getShippingOptionId(): ?string
    {
        return $this->shippingOptionId;
    }

    public function setShippingOptionId(?string $shippingOptionId): SuccessfulPayment
    {
        $this->shippingOptionId = $shippingOptionId;

        return $this;
    }

    public function getOrderInfo(): ?OrderInfo
    {
        return $this->orderInfo;
    }

    public function setOrderInfo(?OrderInfo $orderInfo): SuccessfulPayment
    {
        $this->orderInfo = $orderInfo;

        return $this;
    }

    public function getTelegramPaymentChargeId(): string
    {
        return $this->telegramPaymentChargeId;
    }

    public function setTelegramPaymentChargeId(string $telegramPaymentChargeId): SuccessfulPayment
    {
        $this->telegramPaymentChargeId = $telegramPaymentChargeId;

        return $this;
    }

    public function getProviderPaymentChargeId(): string
    {
        return $this->providerPaymentChargeId;
    }

    public function setProviderPaymentChargeId(string $providerPaymentChargeId): SuccessfulPayment
    {
        $this->providerPaymentChargeId = $providerPaymentChargeId;

        return $this;
    }
}
