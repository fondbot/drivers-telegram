<?php

declare(strict_types=1);

namespace Tests\Unit;

use Tests\TestCase;
use FondBot\Templates\Keyboard;
use FondBot\Drivers\Telegram\TelegramTemplateRenderer;
use FondBot\Drivers\Telegram\Types\ReplyKeyboardMarkup;
use FondBot\Drivers\Telegram\Types\InlineKeyboardMarkup;

class TelegramTemplateCompilerTest extends TestCase
{
    public function testCompileReplyKeyboard(): void
    {
        $buttons = [
            Keyboard\ReplyButton::create('Hello!'),
        ];

        $parameters = [
            'resize_keyboard' => false,
            'one_time_keyboard' => false,
            'selective' => true,
        ];

        $keyboard = new Keyboard($buttons, $parameters);

        /** @var ReplyKeyboardMarkup $result */
        $result = (new TelegramTemplateRenderer)->compile($keyboard);

        $this->assertSame([
            'keyboard' => [
                [
                    ['text' => 'Hello!'],
                ],
            ],
            'resize_keyboard' => false,
            'one_time_keyboard' => false,
            'selective' => true,
        ], $result);
    }

    public function testCompileInlineKeyboard(): void
    {
        $buttons = [
            Keyboard\PayloadButton::create('Hello!', 'foo', ['url' => 'http://app']),
        ];

        $keyboard = new Keyboard($buttons);

        /** @var InlineKeyboardMarkup $result */
        $result = (new TelegramTemplateRenderer)->compile($keyboard);

        $this->assertSame([
            'inline_keyboard' => [
                [
                    [
                        'text' => 'Hello!',
                        'url' => 'http://app',
                        'callback_data' => 'foo',
                    ],
                ],
            ],
        ], $result);
    }
}
