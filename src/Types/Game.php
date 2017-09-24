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

    public function setTitle(string $title): Game
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): Game
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
    public function setPhoto(array $photo): Game
    {
        $this->photo = $photo;

        return $this;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(?string $text): Game
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
    public function setTextEntities(array $textEntities): Game
    {
        $this->textEntities = $textEntities;

        return $this;
    }

    public function getAnimation(): ?Animation
    {
        return $this->animation;
    }

    public function setAnimation(?Animation $animation): Game
    {
        $this->animation = $animation;

        return $this;
    }
}
