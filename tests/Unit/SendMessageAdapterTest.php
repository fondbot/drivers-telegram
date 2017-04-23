<?php

declare(strict_types=1);

namespace Tests\Unit;

use Tests\TestCase;
use FondBot\Drivers\Chat;
use FondBot\Drivers\User;
use FondBot\Drivers\Commands\SendMessage;
use FondBot\Conversation\Templates\Keyboard;
use FondBot\Conversation\Templates\Keyboard\UrlButton;
use FondBot\Conversation\Templates\Keyboard\ReplyButton;
use FondBot\Drivers\Telegram\Commands\SendMessageAdapter;
use FondBot\Conversation\Templates\Keyboard\PayloadButton;
use FondBot\Drivers\Telegram\Templates\Keyboard\Buttons\RequestContactButton;

class SendMessageAdapterTest extends TestCase
{
    public function test_toArray_without_keyboard()
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

    public function test_toArray_with_reply_keyboard()
    {
        $chat = new Chat($chatId = $this->faker()->uuid, $this->faker()->title);
        $user = new User($this->faker()->uuid);
        $text = $this->faker()->text;

        $keyboard = new Keyboard([
            $button1 = new ReplyButton($this->faker()->word),
            $button2 = new ReplyButton($this->faker()->word),
            $button3 = new RequestContactButton($this->faker()->word),
        ]);

        $command = new SendMessage($chat, $user, $text, $keyboard);
        $message = new SendMessageAdapter($command);

        $expected = [
            'chat_id' => $chatId,
            'text' => $text,
            'reply_markup' => json_encode([
                'keyboard' => [
                    [
                        ['text' => $button1->getLabel()],
                        ['text' => $button2->getLabel()],
                        ['text' => $button3->getLabel(), 'request_contact' => true],
                    ],
                ],
                'one_time_keyboard' => true,
            ]),
        ];

        $this->assertSame($expected, $message->toArray());
    }

    public function test_toArray_with_inline_keyboard()
    {
        $chat = new Chat($chatId = $this->faker()->uuid, $this->faker()->title);
        $user = new User($this->faker()->uuid);
        $text = $this->faker()->text;

        $keyboard = new Keyboard([
            $button1 = new UrlButton($this->faker()->word, 'https://fondbot.com'),
            $button2 = new PayloadButton($this->faker()->word, 'do-something'),
            $button3 = new PayloadButton($this->faker()->word, ['action' => 'something']),
        ]);

        $command = new SendMessage($chat, $user, $text, $keyboard);
        $message = new SendMessageAdapter($command);

        $expected = [
            'chat_id' => $chatId,
            'text' => $text,
            'reply_markup' => json_encode([
                'inline_keyboard' => [
                    [
                        ['text' => $button1->getLabel(), 'url' => $button1->getUrl()],
                        ['text' => $button2->getLabel(), 'callback_data' => $button2->getPayload()],
                        ['text' => $button3->getLabel(), 'callback_data' => $button3->getPayload()],
                    ],
                ],
            ]),
        ];

        $this->assertSame($expected, $message->toArray());
    }
}
