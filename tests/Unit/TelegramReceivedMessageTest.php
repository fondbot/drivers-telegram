<?php

declare(strict_types=1);

namespace Tests\Unit;

use FondBot\Drivers\Telegram\TelegramReceivedMessage;
use FondBot\Templates\Attachment;
use FondBot\Templates\Location;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use function GuzzleHttp\Psr7\stream_for;
use Tests\TestCase;
use Zend\Diactoros\Response;

class TelegramReceivedMessageTest extends TestCase
{
    public function testGetTextFromCallbackQuery()
    {
        $payload = [
            'callback_query' => [
                'message' => [
                    'text' => $this->faker()->text,
                ],
            ],
        ];

        $message = new TelegramReceivedMessage($this->guzzle(), 'foo', $payload);

        $this->assertSame($payload['callback_query']['message']['text'], $message->getText());
    }

    public function testGetMessageFromMessage()
    {
        $payload = [
            'message' => [
                'text' => $this->faker()->text,
            ],
        ];

        $message = new TelegramReceivedMessage($this->guzzle(), 'foo', $payload);
        $this->assertSame($payload['message']['text'], $message->getText());
    }

    public function testGetLocation()
    {
        $message = new TelegramReceivedMessage($this->guzzle(), 'foo', []);

        $this->assertNull($message->getLocation());

        $payload = [
            'message' => [
                'location' => [
                    'latitude' => $this->faker()->latitude,
                    'longitude' => $this->faker()->longitude,
                ],
            ],
        ];

        $message = new TelegramReceivedMessage($this->guzzle(), 'foo', $payload);

        $this->assertInstanceOf(Location::class, $message->getLocation());
        $this->assertSame($payload['message']['location']['latitude'], $message->getLocation()->getLatitude());
        $this->assertSame($payload['message']['location']['longitude'], $message->getLocation()->getLongitude());
    }

    /**
     * @dataProvider attachments
     *
     * @param string $type
     */
    public function testHasAttachment(string $type)
    {
        $payload = ['message' => []];
        $message = new TelegramReceivedMessage($this->guzzle(), 'foo', $payload);

        $this->assertFalse($message->hasAttachment());

        $payload = ['message' => [$type => []]];
        $message = new TelegramReceivedMessage($this->guzzle(), 'foo', $payload);

        $this->assertTrue($message->hasAttachment());
    }

    /**
     * @dataProvider attachments
     *
     * @param string $type
     * @param array|null $result
     */
    public function testGetAttachment(string $type, array $result = null)
    {
        if ($result === null) {
            $result = [
                'file_id' => $id = $this->faker()->uuid,
            ];
        } else {
            $id = collect($result)->pluck('file_id')->last();
        }

        // Get file path from Telegram
        $body = json_encode([
            'ok' => true,
            'result' => [
                'file_id' => $id,
                'file_size' => $this->faker()->randomFloat(),
                'file_path' => $path = $this->faker()->imageUrl(),
            ],
        ]);

        $path = 'https://api.telegram.org/file/botfoo/' . $path;

        $response = new Response(stream_for($body));

        $mock = new MockHandler([$response]);
        $handler = HandlerStack::create($mock);
        $guzzle = new Client(['handler' => $handler]);

        $payload = ['message' => [$type => $result]];

        $message = new TelegramReceivedMessage($guzzle, 'foo', $payload);

        $this->assertTrue($message->hasAttachment());

        $attachment = $message->getAttachment();

        switch ($type) {
            case 'photo':
            case 'sticker':
                $genericType = Attachment::TYPE_IMAGE;
                break;
            case 'document':
                $genericType = Attachment::TYPE_FILE;
                break;
            case 'voice':
                $genericType = Attachment::TYPE_AUDIO;
                break;
            default:
                $genericType = $type;
                break;
        }

        $this->assertInstanceOf(Attachment::class, $attachment);
        $this->assertSame($genericType, $attachment->getType());
        $this->assertSame($path, $attachment->getPath());
    }

    public function testHasData()
    {
        $message = new TelegramReceivedMessage($this->guzzle(), 'foo', ['callback_query' => []]);

        $this->assertTrue($message->hasData());
    }

    public function testGetData()
    {
        $message = new TelegramReceivedMessage($this->guzzle(), 'foo', []);

        $this->assertFalse($message->hasData());
        $this->assertNull($message->getData());

        $payload = [
            'callback_query' => [
                'data' => 'foo'
            ]
        ];

        $message = new TelegramReceivedMessage($this->guzzle(), 'foo', $payload);

        $this->assertTrue($message->hasData());
        $this->assertSame('foo', $message->getData());
    }

    public function attachments(): array
    {
        return [
            ['audio'],
            ['document'],
            [
                'photo',
                [
                    [
                        'file_id' => $this->faker()->uuid,
                        'file_size' => 1,
                        'file_path' => $this->faker()->imageUrl(),
                        'width' => $this->faker()->randomNumber(),
                        'height' => $this->faker()->randomNumber(),
                    ],
                    [
                        'file_id' => $this->faker()->uuid,
                        'file_size' => 2,
                        'file_path' => $this->faker()->imageUrl(),
                        'width' => $this->faker()->randomNumber(),
                        'height' => $this->faker()->randomNumber(),
                    ],
                    [
                        'file_id' => $this->faker()->uuid,
                        'file_size' => 3,
                        'file_path' => $this->faker()->imageUrl(),
                        'width' => $this->faker()->randomNumber(),
                        'height' => $this->faker()->randomNumber(),
                    ],
                ],
            ],
            ['sticker'],
            ['video'],
            ['voice'],
        ];
    }
}