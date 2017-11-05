<?php

declare(strict_types=1);

namespace FondBot\Drivers\Telegram\Factories;

use FondBot\Channels\Chat;
use FondBot\Channels\User;
use FondBot\Events\MessageReceived;
use FondBot\Drivers\Telegram\Types\Message;

class MessageReceivedFactory
{
    public static function create(Message $message): MessageReceived
    {
        $chat = new Chat(
            (string) $message->getChat()->getId(),
            $message->getChat()->getTitle(),
            $message->getChat()->getType()
        );

        $from = new User(
            (string) $message->getFrom()->getId(),
            $message->getFrom()->getFirstName(),
            $message->getFrom()->getUsername()
        );

        return new MessageReceived(
            $chat,
            $from,
            $message->getText(),
            $message->getLocation(),
            null,
            null
        );
    }
}
