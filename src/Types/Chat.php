<?php

declare(strict_types=1);

namespace FondBot\Drivers\Telegram\Types;

use FondBot\Drivers\Type;

class Chat extends Type
{
    private $id;
    private $type;
    private $title;
    private $username;
    private $firstName;
    private $lastName;
    private $allMembersAreAdministrators;
    private $photo;
    private $description;
    private $inviteLink;
    private $pinnedMessage;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): Chat
    {
        $this->id = $id;

        return $this;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function setType(string $type): Chat
    {
        $this->type = $type;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): Chat
    {
        $this->title = $title;

        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(?string $username): Chat
    {
        $this->username = $username;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(?string $firstName): Chat
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(?string $lastName): Chat
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getAllMembersAreAdministrators(): ?bool
    {
        return $this->allMembersAreAdministrators;
    }

    public function setAllMembersAreAdministrators(?bool $allMembersAreAdministrators): Chat
    {
        $this->allMembersAreAdministrators = $allMembersAreAdministrators;

        return $this;
    }

    public function getPhoto(): ?ChatPhoto
    {
        return $this->photo;
    }

    public function setPhoto(?ChatPhoto $photo): Chat
    {
        $this->photo = $photo;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): Chat
    {
        $this->description = $description;

        return $this;
    }

    public function getInviteLink(): ?string
    {
        return $this->inviteLink;
    }

    public function setInviteLink(?string $inviteLink): Chat
    {
        $this->inviteLink = $inviteLink;

        return $this;
    }

    public function getPinnedMessage(): ?Message
    {
        return $this->pinnedMessage;
    }

    public function setPinnedMessage(?Message $pinnedMessage): Chat
    {
        $this->pinnedMessage = $pinnedMessage;

        return $this;
    }
}
