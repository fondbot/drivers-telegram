<?php

declare(strict_types=1);

namespace FondBot\Drivers\Telegram\Templates\Keyboard\Buttons;

use FondBot\Templates\Keyboard\Button;

class RequestLocationButton implements Button
{
    private $label;

    public function __construct(string $label)
    {
        $this->label = $label;
    }

    /**
     * Button label.
     *
     * @return string
     */
    public function getLabel(): string
    {
        return $this->label;
    }
}
