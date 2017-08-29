<?php

declare(strict_types=1);

namespace Tests\Unit;

use Tests\TestCase;
use GuzzleHttp\Psr7\Response;
use FondBot\Drivers\Telegram\Types\Chat;
use FondBot\Drivers\Telegram\Types\File;
use FondBot\Drivers\Telegram\Types\User;
use FondBot\Drivers\Telegram\Types\Audio;
use FondBot\Drivers\Telegram\Types\Venue;
use FondBot\Drivers\Telegram\Types\Video;
use FondBot\Drivers\Telegram\Types\Voice;
use FondBot\Drivers\Telegram\Types\Contact;
use FondBot\Drivers\Telegram\TelegramClient;
use FondBot\Drivers\Telegram\Types\Document;
use FondBot\Drivers\Telegram\Types\Location;
use FondBot\Drivers\Telegram\Types\PhotoSize;
use FondBot\Drivers\Telegram\Types\VideoNote;
use FondBot\Drivers\Telegram\Types\ChatMember;

class TelegramClientTest extends TestCase
{
    /** @var TelegramClient */
    private $client;

    protected function setUp(): void
    {
        parent::setUp();

        $this->client = new TelegramClient(
            $this->guzzle(),
            '105604817:AAHCuLc5gcewUaDXS7hZpbZkiDEAHLlZcP4'
        );
    }

    public function testGetMe(): void
    {
        $body = [
            'ok' => true,
            'result' => [
                'id' => 1,
                'is_bot' => true,
                'first_name' => 'Foo',
                'username' => 'Foo_bot',
            ],
        ];

        $this->client->setGuzzle(
            $this->guzzle(new Response(200, [], json_encode($body)))
        );

        $user = $this->client->getMe();

        $this->assertSameType(User::fromJson($body['result']), $user);
    }

    public function testSendMessage(): void
    {
        $body = [
            'ok' => true,
            'result' => [
                'message_id' => $this->faker()->randomNumber(),
                'from' => [
                    'id' => $this->faker()->randomNumber(),
                    'is_bot' => true,
                    'first_name' => $this->faker()->firstName,
                    'username' => $this->faker()->userName,
                ],
                'chat' => [
                    'id' => $this->faker()->randomNumber(),
                    'first_name' => $this->faker()->firstName,
                    'last_name' => $this->faker()->lastName,
                    'username' => $this->faker()->userName,
                    'type' => 'private',
                ],
                'date' => $this->faker()->unixTime,
                'text' => $this->faker()->text,
            ],
        ];

        $this->client->setGuzzle(
            $this->guzzle(new Response(200, [], json_encode($body)))
        );

        $message = $this->client->sendMessage((string) $body['result']['chat']['id'], $body['result']['text']);

        $this->assertSame($body['result']['message_id'], $message->getMessageId());
        $this->assertSameType(User::fromJson($body['result']['from']), $message->getFrom());
        $this->assertSameType(Chat::fromJson($body['result']['chat']), $message->getChat());
        $this->assertSame($body['result']['date'], $message->getDate());
        $this->assertSame($body['result']['text'], $message->getText());
    }

    public function testForwardMessage(): void
    {
        $body = [
            'ok' => true,
            'result' => [
                'forward_from' => [
                    'id' => 431645,
                    'is_bot' => false,
                    'first_name' => 'Vladimir',
                    'last_name' => 'Yuldashev',
                    'username' => 'vyuldashev',
                    'language_code' => 'en-RU',
                ],
                'forward_date' => 1503612278,
                'text' => 'start',
            ],
        ];

        $this->client->setGuzzle(
            $this->guzzle(new Response(200, [], json_encode($body)))
        );

        $message = $this->client->forwardMessage('foo', 'bar', $this->faker()->randomNumber(), true);

        $this->assertSameType(User::fromJson($body['result']['forward_from']), $message->getForwardFrom());
        $this->assertSame(
            $body['result']['forward_from']['language_code'],
            $message->getForwardFrom()->getLanguageCode()
        );
        $this->assertSame($body['result']['forward_date'], $message->getForwardDate());
        $this->assertSame($body['result']['text'], $message->getText());
    }

    public function testSendPhoto(): void
    {
        $body = [
            'ok' => true,
            'result' => [
                'photo' => [
                    [
                        'file_id' => 'AgADBAADLhw5G1saZAfTEeeXlDu2AAEQIOMZAARhQM4xpaN4DRLaAAIC',
                        'width' => 80,
                        'height' => 80,
                        'file_size' => 2355,
                    ],
                    [
                        'file_id' => 'AgADBAADLhw5G1saZAfTEeeXlDu2AAEQIOMZAARhQM4xpaN4DRLaAAIC',
                        'width' => 80,
                        'height' => 80,
                        'file_size' => 2355,
                    ],
                    [
                        'file_id' => 'AgADBAADLhw5G1saZAfTEeeXlDu2AAEQIOMZAARhQM4xpaN4DRLaAAIC',
                        'width' => 80,
                        'height' => 80,
                        'file_size' => 2355,
                    ],
                ],
            ],
        ];

        $this->client->setGuzzle(
            $this->guzzle(new Response(200, [], json_encode($body)))
        );

        $message = $this->client->sendPhoto('chat-id', 'foo');

        $this->assertSameType(PhotoSize::fromJson($body['result']['photo'][0]), $message->getPhoto()[0]);
        $this->assertSameType(PhotoSize::fromJson($body['result']['photo'][1]), $message->getPhoto()[1]);
        $this->assertSameType(PhotoSize::fromJson($body['result']['photo'][2]), $message->getPhoto()[2]);
    }

    public function testSendAudio(): void
    {
        $body = [
            'ok' => true,
            'result' => [
                'audio' => [
                    'file_id' => $this->faker()->uuid,
                    'duration' => $this->faker()->randomNumber(),
                    'performer' => $this->faker()->name,
                    'title' => $this->faker()->title,
                    'mime_type' => $this->faker()->mimeType,
                    'file_size' => $this->faker()->randomNumber(),
                ],
            ],
        ];

        $this->client->setGuzzle(
            $this->guzzle(new Response(200, [], json_encode($body)))
        );

        $message = $this->client->sendAudio('chat-id', 'foo');

        $this->assertSameType(Audio::fromJson($body['result']['audio']), $message->getAudio());
    }

    public function testSendDocument(): void
    {
        $body = [
            'ok' => true,
            'result' => [
                'document' => [
                    'file_id' => $this->faker()->uuid,
                    'thumb' => null,
                    'file_name' => $this->faker()->name,
                    'mime_type' => $this->faker()->mimeType,
                    'file_size' => $this->faker()->randomNumber(),
                ],
            ],
        ];

        $this->client->setGuzzle(
            $this->guzzle(new Response(200, [], json_encode($body)))
        );

        $message = $this->client->sendDocument('chat-id', 'foo');

        $this->assertSameType(Document::fromJson($body['result']['document']), $message->getDocument());
    }

    public function testSendVideo(): void
    {
        $body = [
            'ok' => true,
            'result' => [
                'video' => [
                    'file_id' => $this->faker()->uuid,
                    'width' => $this->faker()->randomNumber(),
                    'height' => $this->faker()->randomNumber(),
                    'duration' => $this->faker()->randomNumber(),
                    'thumb' => null,
                    'mime_type' => $this->faker()->mimeType,
                    'file_size' => $this->faker()->randomNumber(),
                ],
            ],
        ];

        $this->client->setGuzzle(
            $this->guzzle(new Response(200, [], json_encode($body)))
        );

        $message = $this->client->sendVideo('chat-id', 'foo');

        $this->assertSameType(Video::fromJson($body['result']['video']), $message->getVideo());
    }

    public function testSendVoice(): void
    {
        $body = [
            'ok' => true,
            'result' => [
                'voice' => [
                    'file_id' => $this->faker()->uuid,
                    'duration' => $this->faker()->randomNumber(),
                    'mime_type' => $this->faker()->mimeType,
                    'file_size' => $this->faker()->randomNumber(),
                ],
            ],
        ];

        $this->client->setGuzzle(
            $this->guzzle(new Response(200, [], json_encode($body)))
        );

        $message = $this->client->sendVoice('chat-id', 'foo');

        $this->assertSameType(Voice::fromJson($body['result']['voice']), $message->getVoice());
    }

    public function testSendVideoNote(): void
    {
        $body = [
            'ok' => true,
            'result' => [
                'video_note' => [
                    'file_id' => $this->faker()->uuid,
                    'length' => $this->faker()->randomNumber(),
                    'duration' => $this->faker()->randomNumber(),
                    'thumb' => null,
                    'file_size' => $this->faker()->randomNumber(),
                ],
            ],
        ];

        $this->client->setGuzzle(
            $this->guzzle(new Response(200, [], json_encode($body)))
        );

        $message = $this->client->sendVideoNote('chat-id', 'foo');

        $this->assertSameType(VideoNote::fromJson($body['result']['video_note']), $message->getVideoNote());
    }

    public function testSendLocation(): void
    {
        $body = [
            'ok' => true,
            'result' => [
                'location' => [
                    'latitude' => $this->faker()->latitude,
                    'longitude' => $this->faker()->longitude,
                ],
            ],
        ];

        $this->client->setGuzzle(
            $this->guzzle(new Response(200, [], json_encode($body)))
        );

        $message = $this->client->sendLocation('chat-id', $this->faker()->latitude, $this->faker()->longitude);

        $this->assertSameType(Location::fromJson($body['result']['location']), $message->getLocation());
    }

    public function testSendVenue(): void
    {
        $body = [
            'ok' => true,
            'result' => [
                'venue' => [
                    'location' => [
                        'latitude' => $this->faker()->latitude,
                        'longitude' => $this->faker()->longitude,
                    ],
                    'title' => $this->faker()->userName,
                    'address' => $this->faker()->address,
                    'foursquare_id' => $this->faker()->uuid,
                ],
            ],
        ];

        $this->client->setGuzzle(
            $this->guzzle(new Response(200, [], json_encode($body)))
        );

        $message = $this->client->sendVenue(
            'chat-id',
            $body['result']['venue']['location']['latitude'],
            $body['result']['venue']['location']['longitude'],
            $body['result']['venue']['title'],
            $body['result']['venue']['address']
        );

        $this->assertSameType(Venue::fromJson($body['result']['venue']), $message->getVenue());
    }

    public function testSendContact(): void
    {
        $body = [
            'ok' => true,
            'result' => [
                'contact' => [
                    'phone_number' => $this->faker()->phoneNumber,
                    'first_name' => $this->faker()->firstName,
                    'last_name' => $this->faker()->lastName,
                    'user_id' => $this->faker()->randomNumber(),
                ],
            ],
        ];

        $this->client->setGuzzle(
            $this->guzzle(new Response(200, [], json_encode($body)))
        );

        $message = $this->client->sendContact(
            'chat-id',
            $body['result']['contact']['phone_number'],
            $body['result']['contact']['first_name'],
            $body['result']['contact']['last_name']
        );

        $this->assertSameType(Contact::fromJson($body['result']['contact']), $message->getContact());
    }

    public function testSendChatAction(): void
    {
        $body = ['ok' => true, 'result' => $this->faker()->boolean];

        $this->client->setGuzzle(
            $this->guzzle(new Response(200, [], json_encode($body)))
        );

        $result = $this->client->sendChatAction(str_random(), 'typing');

        $this->assertSame($body['result'], $result);
    }

    public function testGetUserProfilePhotos(): void
    {
        $body = [
            'ok' => true,
            'result' => [
                'total_count' => $this->faker()->randomNumber(),
                'photos' => [
                    [
                        [
                            'file_id' => $this->faker()->sha256,
                            'file_size' => $this->faker()->randomNumber(),
                            'width' => $this->faker()->randomNumber(),
                            'height' => $this->faker()->randomNumber(),
                        ],
                        [
                            'file_id' => $this->faker()->sha256,
                            'file_size' => $this->faker()->randomNumber(),
                            'width' => $this->faker()->randomNumber(),
                            'height' => $this->faker()->randomNumber(),
                        ],
                        [
                            'file_id' => $this->faker()->sha256,
                            'file_size' => $this->faker()->randomNumber(),
                            'width' => $this->faker()->randomNumber(),
                            'height' => $this->faker()->randomNumber(),
                        ],
                    ],
                ],
            ],
        ];

        $this->client->setGuzzle($this->guzzle(new Response(200, [], json_encode($body))));

        $result = $this->client->getUserProfilePhotos($this->faker()->randomNumber());

        $this->assertSame($body['result']['total_count'], $result->getTotalCount());

        $this->assertSameType(PhotoSize::fromJson($body['result']['photos'][0][0]), $result->getPhotos()[0][0]);
        $this->assertSameType(PhotoSize::fromJson($body['result']['photos'][0][1]), $result->getPhotos()[0][1]);
        $this->assertSameType(PhotoSize::fromJson($body['result']['photos'][0][2]), $result->getPhotos()[0][2]);
    }

    public function testGetFile(): void
    {
        $body = [
            'ok' => true,
            'result' => [
                'file_id' => $this->faker()->sha256,
                'file_size' => $this->faker()->randomNumber(),
                'file_path' => $this->faker()->userName.'.'.$this->faker()->fileExtension,
            ],
        ];

        $this->client->setGuzzle($this->guzzle(new Response(200, [], json_encode($body))));

        $result = $this->client->getFile($this->faker()->sha256);

        $this->assertSameType(File::fromJson($body['result']), $result);
    }

    public function testKickChatMember(): void
    {
        $body = ['ok' => true, 'result' => $this->faker()->boolean];

        $this->client->setGuzzle($this->guzzle(new Response(200, [], json_encode($body))));

        $result = $this->client->kickChatMember(str_random(), $this->faker()->randomNumber());

        $this->assertSame($body['result'], $result);
    }

    public function testUnbanChatMember(): void
    {
        $body = ['ok' => true, 'result' => $this->faker()->boolean];

        $this->client->setGuzzle($this->guzzle(new Response(200, [], json_encode($body))));

        $result = $this->client->unbanChatMember(str_random(), $this->faker()->randomNumber());

        $this->assertSame($body['result'], $result);
    }

    public function testRestrictChatMember(): void
    {
        $body = ['ok' => true, 'result' => $this->faker()->boolean];

        $this->client->setGuzzle($this->guzzle(new Response(200, [], json_encode($body))));

        $result = $this->client->restrictChatMember(str_random(), $this->faker()->randomNumber());

        $this->assertSame($body['result'], $result);
    }

    public function testPromoteChatMember(): void
    {
        $body = ['ok' => true, 'result' => $this->faker()->boolean];

        $this->client->setGuzzle($this->guzzle(new Response(200, [], json_encode($body))));

        $result = $this->client->promoteChatMember(str_random(), $this->faker()->randomNumber());

        $this->assertSame($body['result'], $result);
    }

    public function testExportChatInviteLink(): void
    {
        $body = ['ok' => true, 'result' => $this->faker()->sha256];

        $this->client->setGuzzle($this->guzzle(new Response(200, [], json_encode($body))));

        $result = $this->client->exportChatInviteLink(str_random());

        $this->assertSame($body['result'], $result);
    }

    public function testSetChatPhoto(): void
    {
        $body = ['ok' => true, 'result' => $this->faker()->boolean];

        $this->client->setGuzzle($this->guzzle(new Response(200, [], json_encode($body))));

        $result = $this->client->setChatPhoto(str_random(), $this->faker()->imageUrl());

        $this->assertSame($body['result'], $result);
    }

    public function testDeleteChatPhoto(): void
    {
        $body = ['ok' => true, 'result' => $this->faker()->boolean];

        $this->client->setGuzzle($this->guzzle(new Response(200, [], json_encode($body))));

        $result = $this->client->deleteChatPhoto(str_random());

        $this->assertSame($body['result'], $result);
    }

    public function testSetChatTitle(): void
    {
        $body = ['ok' => true, 'result' => $this->faker()->boolean];

        $this->client->setGuzzle($this->guzzle(new Response(200, [], json_encode($body))));

        $result = $this->client->setChatTitle(str_random(), $this->faker()->word);

        $this->assertSame($body['result'], $result);
    }

    public function testSetChatDescription(): void
    {
        $body = ['ok' => true, 'result' => $this->faker()->boolean];

        $this->client->setGuzzle($this->guzzle(new Response(200, [], json_encode($body))));

        $result = $this->client->setChatDescription(str_random(), $this->faker()->text);

        $this->assertSame($body['result'], $result);
    }

    public function testPinChatMessage(): void
    {
        $body = ['ok' => true, 'result' => $this->faker()->boolean];

        $this->client->setGuzzle($this->guzzle(new Response(200, [], json_encode($body))));

        $result = $this->client->pinChatMessage(str_random(), $this->faker()->numberBetween(), $this->faker()->boolean);

        $this->assertSame($body['result'], $result);
    }

    public function testUnpinChatMessage(): void
    {
        $body = ['ok' => true, 'result' => $this->faker()->boolean];

        $this->client->setGuzzle($this->guzzle(new Response(200, [], json_encode($body))));

        $result = $this->client->unpinChatMessage(str_random());

        $this->assertSame($body['result'], $result);
    }

    public function testLeaveChat(): void
    {
        $body = ['ok' => true, 'result' => $this->faker()->boolean];

        $this->client->setGuzzle($this->guzzle(new Response(200, [], json_encode($body))));

        $result = $this->client->leaveChat(str_random());

        $this->assertSame($body['result'], $result);
    }

    public function testGetChat(): void
    {
        $body = [
            'ok' => true,
            'result' => [
                'id' => $this->faker()->numberBetween(),
                'type' => 'private',
                'title' => $this->faker()->userName,
                'username' => $this->faker()->userName,
                'first_name' => $this->faker()->firstName,
                'last_name' => $this->faker()->lastName,
                'all_members_are_administrators' => $this->faker()->boolean,
                'photo' => null,
                'description' => $this->faker()->text,
                'invite_link' => $this->faker()->url,
                'pinned_message' => null,
            ],
        ];

        $this->client->setGuzzle($this->guzzle(new Response(200, [], json_encode($body))));

        $result = $this->client->getChat(str_random());

        $this->assertSameType(Chat::fromJson($body['result']), $result);
    }

    public function testGetChatAdministrators(): void
    {
        $body = [
            'ok' => true,
            'result' => [
                [
                    'user' => [
                        'id' => $this->faker()->randomNumber(),
                        'is_bot' => $this->faker()->boolean,
                        'first_name' => $this->faker()->firstName,
                    ],
                    'status' => 'administrator',
                ],
                [
                    'user' => [
                        'id' => $this->faker()->randomNumber(),
                        'is_bot' => $this->faker()->boolean,
                        'first_name' => $this->faker()->firstName,
                    ],
                    'status' => 'administrator',
                ],
                [
                    'user' => [
                        'id' => $this->faker()->randomNumber(),
                        'is_bot' => $this->faker()->boolean,
                        'first_name' => $this->faker()->firstName,
                    ],
                    'status' => 'administrator',
                ],
            ],
        ];

        $this->client->setGuzzle($this->guzzle(new Response(200, [], json_encode($body))));

        $result = $this->client->getChatAdministrators(str_random());

        $this->assertSameType(ChatMember::fromJson($body['result'], true), $result);
    }
}
