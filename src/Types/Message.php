<?php

declare(strict_types=1);

namespace FondBot\Drivers\Telegram\Types;

use FondBot\Drivers\Type;

class Message extends Type
{
    private $messageId;
    private $from;
    private $date;
    private $chat;
    private $forwardFrom;
    private $forwardFromChat;
    private $forwardFromMessageId;
    private $forwardSignature;
    private $forwardDate;
    private $replyToMessage;
    private $editDate;
    private $authorSignature;
    private $text;
    private $entities;
    private $audio;
    private $document;
    private $game;
    private $photo;
    private $sticker;
    private $video;
    private $voice;
    private $videoNote;
    private $newChatMembers;
    private $caption;
    private $contact;
    private $location;
    private $venue;
    private $newChatMember;
    private $leftChatMember;
    private $newChatTitle;
    private $newChatPhoto;
    private $deleteChatPhoto;
    private $groupChatCreated;
    private $supergroupChatCreated;
    private $channelChatCreated;
    private $migrateToChatId;
    private $migrateFromChatId;
    private $pinnedMessage;
    private $invoice;
    private $successfulPayment;

    public function getMessageId(): int
    {
        return $this->messageId;
    }

    public function setMessageId(int $messageId): self
    {
        $this->messageId = $messageId;

        return $this;
    }

    public function getFrom(): ?User
    {
        return $this->from;
    }

    public function setFrom(?User $from): self
    {
        $this->from = $from;

        return $this;
    }

    public function getDate(): int
    {
        return $this->date;
    }

    public function setDate(int $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getChat(): Chat
    {
        return $this->chat;
    }

    public function setChat(Chat $chat): self
    {
        $this->chat = $chat;

        return $this;
    }

    public function getForwardFrom(): ?User
    {
        return $this->forwardFrom;
    }

    public function setForwardFrom(?User $forwardFrom): self
    {
        $this->forwardFrom = $forwardFrom;

        return $this;
    }

    public function getForwardFromChat(): ?Chat
    {
        return $this->forwardFromChat;
    }

    public function setForwardFromChat(?Chat $forwardFromChat): self
    {
        $this->forwardFromChat = $forwardFromChat;

        return $this;
    }

    public function getForwardFromMessageId(): ?int
    {
        return $this->forwardFromMessageId;
    }

    public function setForwardFromMessageId(?int $forwardFromMessageId): self
    {
        $this->forwardFromMessageId = $forwardFromMessageId;

        return $this;
    }

    public function getForwardSignature(): ?string
    {
        return $this->forwardSignature;
    }

    public function setForwardSignature(?string $forwardSignature): self
    {
        $this->forwardSignature = $forwardSignature;

        return $this;
    }

    public function getForwardDate(): ?int
    {
        return $this->forwardDate;
    }

    public function setForwardDate(?int $forwardDate): self
    {
        $this->forwardDate = $forwardDate;

        return $this;
    }

    public function getReplyToMessage(): ?self
    {
        return $this->replyToMessage;
    }

    public function setReplyToMessage(?self $replyToMessage): self
    {
        $this->replyToMessage = $replyToMessage;

        return $this;
    }

    public function getEditDate(): ?int
    {
        return $this->editDate;
    }

    public function setEditDate(?int $editDate): self
    {
        $this->editDate = $editDate;

        return $this;
    }

    public function getAuthorSignature(): ?string
    {
        return $this->authorSignature;
    }

    public function setAuthorSignature(?string $authorSignature): self
    {
        $this->authorSignature = $authorSignature;

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
     * @return MessageEntity[]|null
     */
    public function getEntities(): ?array
    {
        return $this->entities;
    }

    /**
     * @param MessageEntity[] $entities
     *
     * @return Message
     */
    public function setEntities(?array $entities): self
    {
        $this->entities = $entities;

        return $this;
    }

    public function getAudio(): ?Audio
    {
        return $this->audio;
    }

    public function setAudio(?Audio $audio): self
    {
        $this->audio = $audio;

        return $this;
    }

    public function getDocument(): ?Document
    {
        return $this->document;
    }

    public function setDocument(?Document $document): self
    {
        $this->document = $document;

        return $this;
    }

    public function getGame(): ?Game
    {
        return $this->game;
    }

    public function setGame(?Game $game): self
    {
        $this->game = $game;

        return $this;
    }

    /**
     * @return PhotoSize[]|null
     */
    public function getPhoto(): ?array
    {
        return $this->photo;
    }

    /**
     * @param PhotoSize[] $photo
     * @return Message
     */
    public function setPhoto(?array $photo): self
    {
        $this->photo = $photo;

        return $this;
    }

    public function getSticker(): ?Sticker
    {
        return $this->sticker;
    }

    public function setSticker(?Sticker $sticker): self
    {
        $this->sticker = $sticker;

        return $this;
    }

    public function getVideo(): ?Video
    {
        return $this->video;
    }

    public function setVideo(?Video $video): self
    {
        $this->video = $video;

        return $this;
    }

    public function getVoice(): ?Voice
    {
        return $this->voice;
    }

    public function setVoice(?Voice $voice): self
    {
        $this->voice = $voice;

        return $this;
    }

    public function getVideoNote(): ?VideoNote
    {
        return $this->videoNote;
    }

    public function setVideoNote(?VideoNote $videoNote): self
    {
        $this->videoNote = $videoNote;

        return $this;
    }

    /**
     * @return User[]|null
     */
    public function getNewChatMembers(): ?array
    {
        return $this->newChatMembers;
    }

    /**
     * @param User[] $newChatMembers
     * @return Message
     */
    public function setNewChatMembers(?array $newChatMembers): self
    {
        $this->newChatMembers = $newChatMembers;

        return $this;
    }

    public function getCaption(): ?string
    {
        return $this->caption;
    }

    public function setCaption(?string $caption): self
    {
        $this->caption = $caption;

        return $this;
    }

    public function getContact(): ?Contact
    {
        return $this->contact;
    }

    public function setContact(?Contact $contact): self
    {
        $this->contact = $contact;

        return $this;
    }

    public function getLocation(): ?Location
    {
        return $this->location;
    }

    public function setLocation(?Location $location): self
    {
        $this->location = $location;

        return $this;
    }

    public function getVenue(): ?Venue
    {
        return $this->venue;
    }

    public function setVenue(?Venue $venue): self
    {
        $this->venue = $venue;

        return $this;
    }

    public function getNewChatMember(): ?User
    {
        return $this->newChatMember;
    }

    public function setNewChatMember(?User $newChatMember): self
    {
        $this->newChatMember = $newChatMember;

        return $this;
    }

    public function getLeftChatMember(): ?User
    {
        return $this->leftChatMember;
    }

    public function setLeftChatMember(?User $leftChatMember): self
    {
        $this->leftChatMember = $leftChatMember;

        return $this;
    }

    public function getNewChatTitle(): ?string
    {
        return $this->newChatTitle;
    }

    public function setNewChatTitle(?string $newChatTitle): self
    {
        $this->newChatTitle = $newChatTitle;

        return $this;
    }

    /**
     * @return PhotoSize[]|null
     */
    public function getNewChatPhoto(): ?array
    {
        return $this->newChatPhoto;
    }

    /**
     * @param PhotoSize[] $newChatPhoto
     *
     * @return Message
     */
    public function setNewChatPhoto(?array $newChatPhoto): self
    {
        $this->newChatPhoto = $newChatPhoto;

        return $this;
    }

    public function getDeleteChatPhoto(): ?bool
    {
        return $this->deleteChatPhoto;
    }

    public function setDeleteChatPhoto(?bool $deleteChatPhoto): self
    {
        $this->deleteChatPhoto = $deleteChatPhoto;

        return $this;
    }

    public function getGroupChatCreated(): ?bool
    {
        return $this->groupChatCreated;
    }

    public function setGroupChatCreated(?bool $groupChatCreated): self
    {
        $this->groupChatCreated = $groupChatCreated;

        return $this;
    }

    public function getSupergroupChatCreated(): ?bool
    {
        return $this->supergroupChatCreated;
    }

    public function setSupergroupChatCreated(?bool $supergroupChatCreated): self
    {
        $this->supergroupChatCreated = $supergroupChatCreated;

        return $this;
    }

    public function getChannelChatCreated(): ?bool
    {
        return $this->channelChatCreated;
    }

    public function setChannelChatCreated(?bool $channelChatCreated): self
    {
        $this->channelChatCreated = $channelChatCreated;

        return $this;
    }

    public function getMigrateToChatId(): ?int
    {
        return $this->migrateToChatId;
    }

    public function setMigrateToChatId(?int $migrateToChatId): self
    {
        $this->migrateToChatId = $migrateToChatId;

        return $this;
    }

    public function getMigrateFromChatId(): ?int
    {
        return $this->migrateFromChatId;
    }

    public function setMigrateFromChatId(?int $migrateFromChatId): self
    {
        $this->migrateFromChatId = $migrateFromChatId;

        return $this;
    }

    public function getPinnedMessage(): ?self
    {
        return $this->pinnedMessage;
    }

    public function setPinnedMessage(?self $pinnedMessage): self
    {
        $this->pinnedMessage = $pinnedMessage;

        return $this;
    }

    public function getInvoice(): ?Invoice
    {
        return $this->invoice;
    }

    public function setInvoice(?Invoice $invoice): self
    {
        $this->invoice = $invoice;

        return $this;
    }

    public function getSuccessfulPayment(): ?SuccessfulPayment
    {
        return $this->successfulPayment;
    }

    /**
     * @param mixed $successfulPayment
     * @return Message
     */
    public function setSuccessfulPayment(?SuccessfulPayment $successfulPayment): self
    {
        $this->successfulPayment = $successfulPayment;

        return $this;
    }
}
