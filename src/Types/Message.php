<?php

declare(strict_types=1);

namespace FondBot\Drivers\Telegram\Types;

use FondBot\Drivers\Telegram\Type;

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

    public function setMessageId(int $messageId): Message
    {
        $this->messageId = $messageId;

        return $this;
    }

    public function getFrom(): ?User
    {
        return $this->from;
    }

    public function setFrom(?User $from): Message
    {
        $this->from = $from;

        return $this;
    }

    public function getDate(): int
    {
        return $this->date;
    }

    public function setDate(int $date): Message
    {
        $this->date = $date;

        return $this;
    }

    public function getChat(): Chat
    {
        return $this->chat;
    }

    public function setChat(Chat $chat): Message
    {
        $this->chat = $chat;

        return $this;
    }

    public function getForwardFrom(): ?User
    {
        return $this->forwardFrom;
    }

    public function setForwardFrom(?User $forwardFrom): Message
    {
        $this->forwardFrom = $forwardFrom;

        return $this;
    }

    public function getForwardFromChat(): ?Chat
    {
        return $this->forwardFromChat;
    }

    public function setForwardFromChat(?Chat $forwardFromChat): Message
    {
        $this->forwardFromChat = $forwardFromChat;

        return $this;
    }

    public function getForwardFromMessageId(): ?int
    {
        return $this->forwardFromMessageId;
    }

    public function setForwardFromMessageId(?int $forwardFromMessageId): Message
    {
        $this->forwardFromMessageId = $forwardFromMessageId;

        return $this;
    }

    public function getForwardSignature(): ?string
    {
        return $this->forwardSignature;
    }

    public function setForwardSignature(?string $forwardSignature): Message
    {
        $this->forwardSignature = $forwardSignature;

        return $this;
    }

    public function getForwardDate(): ?int
    {
        return $this->forwardDate;
    }

    public function setForwardDate(?int $forwardDate): Message
    {
        $this->forwardDate = $forwardDate;

        return $this;
    }

    public function getReplyToMessage(): ?Message
    {
        return $this->replyToMessage;
    }

    public function setReplyToMessage(?Message $replyToMessage): Message
    {
        $this->replyToMessage = $replyToMessage;

        return $this;
    }

    public function getEditDate(): ?int
    {
        return $this->editDate;
    }

    public function setEditDate(?int $editDate): Message
    {
        $this->editDate = $editDate;

        return $this;
    }

    public function getAuthorSignature(): ?string
    {
        return $this->authorSignature;
    }

    public function setAuthorSignature(?string $authorSignature): Message
    {
        $this->authorSignature = $authorSignature;

        return $this;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(?string $text): Message
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
    public function setEntities(?array $entities): Message
    {
        $this->entities = $entities;

        return $this;
    }

    public function getAudio(): ?Audio
    {
        return $this->audio;
    }

    public function setAudio(?Audio $audio): Message
    {
        $this->audio = $audio;

        return $this;
    }

    public function getDocument(): ?Document
    {
        return $this->document;
    }

    public function setDocument(?Document $document): Message
    {
        $this->document = $document;

        return $this;
    }

    public function getGame(): ?Game
    {
        return $this->game;
    }

    public function setGame(?Game $game): Message
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
    public function setPhoto(?array $photo): Message
    {
        $this->photo = $photo;

        return $this;
    }

    public function getSticker(): ?Sticker
    {
        return $this->sticker;
    }

    public function setSticker(?Sticker $sticker): Message
    {
        $this->sticker = $sticker;

        return $this;
    }

    public function getVideo(): ?Video
    {
        return $this->video;
    }

    public function setVideo(?Video $video): Message
    {
        $this->video = $video;

        return $this;
    }

    public function getVoice(): ?Voice
    {
        return $this->voice;
    }

    public function setVoice(?Voice $voice): Message
    {
        $this->voice = $voice;

        return $this;
    }

    public function getVideoNote(): ?VideoNote
    {
        return $this->videoNote;
    }

    public function setVideoNote(?VideoNote $videoNote): Message
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
    public function setNewChatMembers(?array $newChatMembers): Message
    {
        $this->newChatMembers = $newChatMembers;

        return $this;
    }

    public function getCaption(): ?string
    {
        return $this->caption;
    }

    public function setCaption(?string $caption): Message
    {
        $this->caption = $caption;

        return $this;
    }

    public function getContact(): ?Contact
    {
        return $this->contact;
    }

    public function setContact(?Contact $contact): Message
    {
        $this->contact = $contact;

        return $this;
    }

    public function getLocation(): ?Location
    {
        return $this->location;
    }

    public function setLocation(?Location $location): Message
    {
        $this->location = $location;

        return $this;
    }

    public function getVenue(): ?Venue
    {
        return $this->venue;
    }

    public function setVenue(?Venue $venue): Message
    {
        $this->venue = $venue;

        return $this;
    }

    public function getNewChatMember(): ?User
    {
        return $this->newChatMember;
    }

    public function setNewChatMember(?User $newChatMember): Message
    {
        $this->newChatMember = $newChatMember;

        return $this;
    }

    public function getLeftChatMember(): ?User
    {
        return $this->leftChatMember;
    }

    public function setLeftChatMember(?User $leftChatMember): Message
    {
        $this->leftChatMember = $leftChatMember;

        return $this;
    }

    public function getNewChatTitle(): ?string
    {
        return $this->newChatTitle;
    }

    public function setNewChatTitle(?string $newChatTitle): Message
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
    public function setNewChatPhoto(?array $newChatPhoto): Message
    {
        $this->newChatPhoto = $newChatPhoto;

        return $this;
    }

    public function getDeleteChatPhoto(): ?bool
    {
        return $this->deleteChatPhoto;
    }

    public function setDeleteChatPhoto(?bool $deleteChatPhoto): Message
    {
        $this->deleteChatPhoto = $deleteChatPhoto;

        return $this;
    }

    public function getGroupChatCreated(): ?bool
    {
        return $this->groupChatCreated;
    }

    public function setGroupChatCreated(?bool $groupChatCreated): Message
    {
        $this->groupChatCreated = $groupChatCreated;

        return $this;
    }

    public function getSupergroupChatCreated(): ?bool
    {
        return $this->supergroupChatCreated;
    }

    public function setSupergroupChatCreated(?bool $supergroupChatCreated): Message
    {
        $this->supergroupChatCreated = $supergroupChatCreated;

        return $this;
    }

    public function getChannelChatCreated(): ?bool
    {
        return $this->channelChatCreated;
    }

    public function setChannelChatCreated(?bool $channelChatCreated): Message
    {
        $this->channelChatCreated = $channelChatCreated;

        return $this;
    }

    public function getMigrateToChatId(): ?int
    {
        return $this->migrateToChatId;
    }

    public function setMigrateToChatId(?int $migrateToChatId): Message
    {
        $this->migrateToChatId = $migrateToChatId;

        return $this;
    }

    public function getMigrateFromChatId(): ?int
    {
        return $this->migrateFromChatId;
    }

    public function setMigrateFromChatId(?int $migrateFromChatId): Message
    {
        $this->migrateFromChatId = $migrateFromChatId;

        return $this;
    }

    public function getPinnedMessage(): ?Message
    {
        return $this->pinnedMessage;
    }

    public function setPinnedMessage(?Message $pinnedMessage): Message
    {
        $this->pinnedMessage = $pinnedMessage;

        return $this;
    }

    public function getInvoice(): ?Invoice
    {
        return $this->invoice;
    }

    public function setInvoice(?Invoice $invoice): Message
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
    public function setSuccessfulPayment(?SuccessfulPayment $successfulPayment): Message
    {
        $this->successfulPayment = $successfulPayment;

        return $this;
    }
}
