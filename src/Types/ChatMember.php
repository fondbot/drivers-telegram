<?php

declare(strict_types=1);

namespace FondBot\Drivers\Telegram\Types;

use FondBot\Drivers\Type;

class ChatMember extends Type
{
    private $user;
    private $status;
    private $untilDate;
    private $canBeEdited;
    private $canChangeInfo;
    private $canPostMessages;
    private $canEditMessages;
    private $canDeleteMessages;
    private $canInviteUsers;
    private $canRestrictMembers;
    private $canPinMessages;
    private $canPromoteMembers;
    private $canSendMessages;
    private $canSendMediaMessages;
    private $canSendOtherMessages;
    private $canAddWebPagePreviews;

    public function getUser(): User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getUntilDate(): ?int
    {
        return $this->untilDate;
    }

    public function setUntilDate(?int $untilDate): self
    {
        $this->untilDate = $untilDate;

        return $this;
    }

    public function getCanBeEdited(): ?bool
    {
        return $this->canBeEdited;
    }

    public function setCanBeEdited(?bool $canBeEdited): self
    {
        $this->canBeEdited = $canBeEdited;

        return $this;
    }

    public function getCanChangeInfo(): ?bool
    {
        return $this->canChangeInfo;
    }

    public function setCanChangeInfo(?bool $canChangeInfo): self
    {
        $this->canChangeInfo = $canChangeInfo;

        return $this;
    }

    public function getCanPostMessages(): ?bool
    {
        return $this->canPostMessages;
    }

    public function setCanPostMessages(?bool $canPostMessages): self
    {
        $this->canPostMessages = $canPostMessages;

        return $this;
    }

    public function getCanEditMessages(): ?bool
    {
        return $this->canEditMessages;
    }

    public function setCanEditMessages(?bool $canEditMessages): self
    {
        $this->canEditMessages = $canEditMessages;

        return $this;
    }

    public function getCanDeleteMessages(): ?bool
    {
        return $this->canDeleteMessages;
    }

    public function setCanDeleteMessages(?bool $canDeleteMessages): self
    {
        $this->canDeleteMessages = $canDeleteMessages;

        return $this;
    }

    public function getCanInviteUsers(): ?bool
    {
        return $this->canInviteUsers;
    }

    public function setCanInviteUsers(?bool $canInviteUsers): self
    {
        $this->canInviteUsers = $canInviteUsers;

        return $this;
    }

    public function getCanRestrictMembers(): ?bool
    {
        return $this->canRestrictMembers;
    }

    public function setCanRestrictMembers(?bool $canRestrictMembers): self
    {
        $this->canRestrictMembers = $canRestrictMembers;

        return $this;
    }

    public function getCanPinMessages(): ?bool
    {
        return $this->canPinMessages;
    }

    public function setCanPinMessages(?bool $canPinMessages): self
    {
        $this->canPinMessages = $canPinMessages;

        return $this;
    }

    public function getCanPromoteMembers(): ?bool
    {
        return $this->canPromoteMembers;
    }

    public function setCanPromoteMembers(?bool $canPromoteMembers): self
    {
        $this->canPromoteMembers = $canPromoteMembers;

        return $this;
    }

    public function getCanSendMessages(): ?bool
    {
        return $this->canSendMessages;
    }

    public function setCanSendMessages(?bool $canSendMessages): self
    {
        $this->canSendMessages = $canSendMessages;

        return $this;
    }

    public function getCanSendMediaMessages(): ?bool
    {
        return $this->canSendMediaMessages;
    }

    public function setCanSendMediaMessages(?bool $canSendMediaMessages): self
    {
        $this->canSendMediaMessages = $canSendMediaMessages;

        return $this;
    }

    public function getCanSendOtherMessages(): ?bool
    {
        return $this->canSendOtherMessages;
    }

    public function setCanSendOtherMessages(?bool $canSendOtherMessages): self
    {
        $this->canSendOtherMessages = $canSendOtherMessages;

        return $this;
    }

    public function getCanAddWebPagePreviews(): ?bool
    {
        return $this->canAddWebPagePreviews;
    }

    public function setCanAddWebPagePreviews(?bool $canAddWebPagePreviews): self
    {
        $this->canAddWebPagePreviews = $canAddWebPagePreviews;

        return $this;
    }
}
