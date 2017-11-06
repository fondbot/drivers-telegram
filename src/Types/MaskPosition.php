<?php

declare(strict_types=1);

namespace FondBot\Drivers\Telegram\Types;

use FondBot\Drivers\Type;

class MaskPosition extends Type
{
    private $point;
    private $xShift;
    private $yShift;
    private $scale;

    public function getPoint(): string
    {
        return $this->point;
    }

    public function setPoint(string $point): self
    {
        $this->point = $point;

        return $this;
    }

    public function getXShift(): float
    {
        return $this->xShift;
    }

    public function setXShift(float $xShift): self
    {
        $this->xShift = $xShift;

        return $this;
    }

    public function getYShift(): float
    {
        return $this->yShift;
    }

    public function setYShift(float $yShift): self
    {
        $this->yShift = $yShift;

        return $this;
    }

    public function getScale(): float
    {
        return $this->scale;
    }

    public function setScale(float $scale): self
    {
        $this->scale = $scale;

        return $this;
    }
}
