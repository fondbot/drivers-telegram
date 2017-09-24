<?php

declare(strict_types=1);

namespace FondBot\Drivers\Telegram\Types;

use FondBot\Drivers\Type;

class Location extends Type
{
    private $latitude;
    private $longitude;

    public function getLatitude(): float
    {
        return $this->latitude;
    }

    public function setLatitude(float $latitude): Location
    {
        $this->latitude = $latitude;

        return $this;
    }

    public function getLongitude(): float
    {
        return $this->longitude;
    }

    public function setLongitude(float $longitude): Location
    {
        $this->longitude = $longitude;

        return $this;
    }
}
