<?php

declare(strict_types=1);

namespace FondBot\Drivers\Telegram\Templates;

use FondBot\Templates\Keyboard\Button;

class RequestLocationButton implements Button
{
    private $label;

    /**
     * Get name.
     *
     * @return string
     */
    public function getName(): string
    {
        return 'RequestLocationButton';
    }

    /**
     * Get label.
     *
     * @return string
     */
    public function getLabel(): string
    {
        return $this->label;
    }

    /**
     * Set label.
     *
     * @param string $label
     *
     * @return RequestLocationButton
     */
    public function setLabel(string $label): RequestLocationButton
    {
        $this->label = $label;

        return $this;
    }
}
