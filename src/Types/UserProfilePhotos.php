<?php

declare(strict_types=1);

namespace FondBot\Drivers\Telegram\Types;

use FondBot\Drivers\Telegram\Type;

class UserProfilePhotos extends Type
{
    private $totalCount;
    private $photos;

    public function getTotalCount(): int
    {
        return $this->totalCount;
    }

    public function setTotalCount(int $totalCount): UserProfilePhotos
    {
        $this->totalCount = $totalCount;

        return $this;
    }

    /**
     * @return PhotoSize[][]
     */
    public function getPhotos(): array
    {
        return $this->photos;
    }

    /**
     * @param PhotoSize[][] $photos
     *
     * @return UserProfilePhotos
     */
    public function setPhotos(array $photos): UserProfilePhotos
    {
        $this->photos = $photos;

        return $this;
    }
}
