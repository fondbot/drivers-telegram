<?php

declare(strict_types=1);

namespace Tests\Unit;

use Tests\TestCase;
use FondBot\Templates\Keyboard;
use FondBot\Drivers\Telegram\TelegramTemplateRenderer;
use FondBot\Drivers\Telegram\Types\ReplyKeyboardMarkup;
use FondBot\Drivers\Telegram\Types\InlineKeyboardMarkup;

class TelegramTemplateRendererTest extends TestCase
{
    public function testRenderReplyKeyboard(): void
    {
        $buttons = [
            Keyboard\ReplyButton::make('Hello!'),
        ];

        $parameters = [
            'resize_keyboard' => false,
            'one_time_keyboard' => false,
            'selective' => true,
        ];

        $keyboard = new Keyboard($buttons, $parameters);

        /** @var ReplyKeyboardMarkup $result */
        $result = (new TelegramTemplateRenderer)->render($keyboard);

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

    public function testRenderInlineKeyboard(): void
    {
        $buttons = [
            Keyboard\PayloadButton::make('Hello!', 'foo', ['url' => 'http://app']),
        ];

        $keyboard = new Keyboard($buttons);

        /** @var InlineKeyboardMarkup $result */
        $result = (new TelegramTemplateRenderer)->render($keyboard);

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
