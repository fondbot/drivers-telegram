<?php

declare(strict_types=1);

namespace FondBot\Drivers\Telegram\Types;

class MaskPosition
{
    private $point;
    private $xShift;
    private $yShift;
    private $scale;

    public function getPoint(): string
    {
        return $this->point;
    }

    public function setPoint(string $point): MaskPosition
    {
        $this->point = $point;

        return $this;
    }

    public function getXShift(): float
    {
        return $this->xShift;
    }

    public function setXShift(float $xShift): MaskPosition
    {
        $this->xShift = $xShift;

        return $this;
    }

    public function getYShift(): float
    {
        return $this->yShift;
    }

    public function setYShift(float $yShift): MaskPosition
    {
        $this->yShift = $yShift;

        return $this;
    }

    public function getScale(): float
    {
        return $this->scale;
    }

    public function setScale(float $scale): MaskPosition
    {
        $this->scale = $scale;

        return $this;
    }
}
