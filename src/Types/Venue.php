<?php

declare(strict_types=1);

namespace FondBot\Drivers\Telegram\Types;

use FondBot\Drivers\Type;

class Venue extends Type
{
    private $location;
    private $title;
    private $address;
    private $foursquareId;

    public function getLocation(): Location
    {
        return $this->location;
    }

    public function setLocation(Location $location): Venue
    {
        $this->location = $location;

        return $this;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): Venue
    {
        $this->title = $title;

        return $this;
    }

    public function getAddress(): string
    {
        return $this->address;
    }

    public function setAddress(string $address): Venue
    {
        $this->address = $address;

        return $this;
    }

    public function getFoursquareId(): ?string
    {
        return $this->foursquareId;
    }

    public function setFoursquareId(?string $foursquareId): Venue
    {
        $this->foursquareId = $foursquareId;

        return $this;
    }
}
