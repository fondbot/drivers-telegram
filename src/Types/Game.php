<?php

declare(strict_types=1);

namespace FondBot\Drivers\Telegram\Types;

use FondBot\Drivers\Type;

class Game extends Type
{
    private $title;
    private $description;
    private $photo;
    private $text;
    private $textEntities;
    private $animation;

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return PhotoSize[]
     */
    public function getPhoto(): array
    {
        return $this->photo;
    }

    /**
     * @param PhotoSize[] $photo
     *
     * @return Game
     */
    public function setPhoto(array $photo): self
    {
        $this->photo = $photo;

        return $this;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(?string $text): self
    {
        $this->text = $text;

        return $this;
    }

    /**
     * @return MessageEntity[]
     */
    public function getTextEntities(): array
    {
        return $this->textEntities;
    }

    /**
     * @param MessageEntity[] $textEntities
     *
     * @return Game
     */
    public function setTextEntities(array $textEntities): self
    {
        $this->textEntities = $textEntities;

        return $this;
    }

    public function getAnimation(): ?Animation
    {
        return $this->animation;
    }

    public function setAnimation(?Animation $animation): self
    {
        $this->animation = $animation;

        return $this;
    }
}
