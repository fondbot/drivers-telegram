<?php

declare(strict_types=1);

namespace Tests\Unit;

use Tests\TestCase;
use FondBot\Templates\Keyboard;
use FondBot\Drivers\Telegram\TelegramTemplateCompiler;
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
        $result = (new TelegramTemplateCompiler)->compile($keyboard);

        $this->assertInstanceOf(ReplyKeyboardMarkup::class, $result);
        $this->assertCount(1, $result->getKeyboard());
        $this->assertSame('Hello!', $result->getKeyboard()[0]->getText());
        $this->assertFalse($result->getResizeKeyboard());
        $this->assertFalse($result->getOneTimeKeyboard());
        $this->assertTrue($result->getSelective());
    }

    public function testCompileInlineKeyboard(): void
    {
        $buttons = [
            Keyboard\PayloadButton::create('Hello!', 'foo', ['url' => 'http://app']),
        ];

        $keyboard = new Keyboard($buttons);

        /** @var InlineKeyboardMarkup $result */
        $result = (new TelegramTemplateCompiler)->compile($keyboard);

        $this->assertInstanceOf(InlineKeyboardMarkup::class, $result);
        $this->assertCount(1, $result->getInlineKeyboard());
        $this->assertSame('Hello!', $result->getInlineKeyboard()[0]->getText());
        $this->assertSame('foo', $result->getInlineKeyboard()[0]->getCallbackData());
        $this->assertSame('http://app', $result->getInlineKeyboard()[0]->getUrl());
    }
}
