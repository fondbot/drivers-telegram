<?php

declare(strict_types=1);

namespace Tests\Unit;

use Tests\TestCase;
use FondBot\Drivers\Chat;
use FondBot\Drivers\User;
use FondBot\Templates\Keyboard;
use FondBot\Drivers\Commands\SendMessage;
use FondBot\Templates\Keyboard\UrlButton;
use FondBot\Templates\Keyboard\ReplyButton;
use FondBot\Templates\Keyboard\PayloadButton;
use FondBot\Drivers\Telegram\Commands\SendMessageAdapter;
use FondBot\Drivers\Telegram\Templates\Keyboard\Buttons\RequestContactButton;

class SendMessageAdapterTest extends TestCase
{
    public function test_toArray_without_keyboard(): void
    {
        $chat = new Chat($chatId = $this->faker()->uuid, $this->faker()->title);
        $user = new User($this->faker()->uuid);
        $text = $this->faker()->text;

        $command = new SendMessage($chat, $user, $text);
        $message = new SendMessageAdapter($command);

        $expected = [
            'chat_id' => $chatId,
            'text' => $text,
        ];

        $this->assertSame($expected, $message->toArray());
    }

    public function test_toArray_with_reply_keyboard(): void
    {
        $chat = new Chat($chatId = $this->faker()->uuid, $this->faker()->title);
        $user = new User($this->faker()->uuid);
        $text = $this->faker()->text;

        $keyboard = (new Keyboard)
            ->addButton($button1 = (new ReplyButton)->setLabel('foo1'))
            ->addButton($button2 = (new ReplyButton)->setLabel('foo2'))
            ->addButton($button3 = (new RequestContactButton)->setLabel('foo3'));

        $command = new SendMessage($chat, $user, $text, $keyboard);
        $message = new SendMessageAdapter($command);

        $expected = [
            'chat_id' => $chatId,
            'text' => $text,
            'reply_markup' => json_encode([
                'keyboard' => [
                    [$button1->getLabel()],
                    [$button2->getLabel()],
                    [['text' => $button3->getLabel(), 'request_contact' => true]],
                ],
                'resize_keyboard' => true,
                'one_time_keyboard' => true,
            ]),
        ];

        $this->assertSame($expected, $message->toArray());
    }

    public function test_toArray_with_inline_keyboard(): void
    {
        $chat = new Chat($chatId = $this->faker()->uuid, $this->faker()->title);
        $user = new User($this->faker()->uuid);
        $text = $this->faker()->text;

        $keyboard = (new Keyboard)
            ->addButton(
                $button1 = (new UrlButton)
                    ->setLabel('foo1')
                    ->setUrl('https://fondbot.com')
            )
            ->addButton(
                $button2 = (new PayloadButton)
                    ->setLabel('foo2')
                    ->setPayload('bar')
            )
            ->addButton(
                $button3 = (new PayloadButton)
                    ->setLabel('foo3')
                    ->setPayload(['foo' => 'bar'])
            );

        $command = new SendMessage($chat, $user, $text, $keyboard);
        $message = new SendMessageAdapter($command);

        $expected = [
            'chat_id' => $chatId,
            'text' => $text,
            'reply_markup' => json_encode([
                'inline_keyboard' => [
                    [['text' => $button1->getLabel(), 'url' => $button1->getUrl()]],
                    [['text' => $button2->getLabel(), 'callback_data' => $button2->getPayload()]],
                    [['text' => $button3->getLabel(), 'callback_data' => $button3->getPayload()]],
                ],
            ]),
        ];

        $this->assertSame($expected, $message->toArray());
    }
}
