<?php

declare(strict_types=1);

namespace Tests\Unit;

use Tests\TestCase;
use FondBot\Templates\Keyboard;
use FondBot\Drivers\Telegram\TelegramTemplateCompiler;
use unreal4u\TelegramAPI\Telegram\Types\ReplyKeyboardMarkup;
use unreal4u\TelegramAPI\Telegram\Types\Inline\Keyboard\Markup as InlineKeyboardMarkup;

class TelegramTemplateCompilerTest extends TestCase
{
    public function testCompileReplyKeyboard(): void
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
        $result = (new TelegramTemplateCompiler)->compile($keyboard);

        $this->assertInstanceOf(ReplyKeyboardMarkup::class, $result);
    }

    public function testCompileInlineKeyboard(): void
    {
        $buttons = [
            Keyboard\PayloadButton::make('Hello!', 'foo', ['url' => 'http://app']),
        ];

        $keyboard = new Keyboard($buttons);

        /** @var InlineKeyboardMarkup $result */
        $result = (new TelegramTemplateCompiler)->compile($keyboard);

        $this->assertInstanceOf(InlineKeyboardMarkup::class, $result);
    }
}
