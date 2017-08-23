<?php

declare(strict_types=1);

namespace FondBot\Drivers\Telegram\Types;

class ShippingAddress
{
    private $countryCode;
    private $state;
    private $city;
    private $streetLine1;
    private $streetLine2;
    private $postCode;

    public function getCountryCode(): string
    {
        return $this->countryCode;
    }

    public function setCountryCode(string $countryCode): ShippingAddress
    {
        $this->countryCode = $countryCode;

        return $this;
    }

    public function getState(): string
    {
        return $this->state;
    }

    public function setState(string $state): ShippingAddress
    {
        $this->state = $state;

        return $this;
    }

    public function getCity(): string
    {
        return $this->city;
    }

    public function setCity(string $city): ShippingAddress
    {
        $this->city = $city;

        return $this;
    }

    public function getStreetLine1(): string
    {
        return $this->streetLine1;
    }

    public function setStreetLine1(string $streetLine1): ShippingAddress
    {
        $this->streetLine1 = $streetLine1;

        return $this;
    }

    public function getStreetLine2(): string
    {
        return $this->streetLine2;
    }

    public function setStreetLine2(string $streetLine2): ShippingAddress
    {
        $this->streetLine2 = $streetLine2;

        return $this;
    }

    public function getPostCode(): string
    {
        return $this->postCode;
    }

    public function setPostCode(string $postCode): ShippingAddress
    {
        $this->postCode = $postCode;

        return $this;
    }
}
