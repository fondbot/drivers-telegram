<?php

declare(strict_types=1);

namespace Tests\Unit;

use FondBot\Channels\Channel;
use FondBot\Drivers\Chat;
use FondBot\Drivers\Telegram\TelegramCommandHandler;
use FondBot\Drivers\Telegram\TelegramTemplateCompiler;
use function GuzzleHttp\Psr7\stream_for;
use Mockery\MockInterface;
use Tests\TestCase;
use GuzzleHttp\Client;
use FondBot\Helpers\Str;
use FondBot\Drivers\User;
use FondBot\Drivers\Telegram\TelegramDriver;
use FondBot\Drivers\Telegram\TelegramReceivedMessage;
use Zend\Diactoros\Request;

class TelegramDriverTest extends TestCase
{
    /** @var Channel */
    private $channel;

    /** @var MockInterface */
    private $guzzle;

    /** @var TelegramDriver */
    private $driver;

    protected function setUp(): void
    {
        parent::setUp();

        $this->channel = new Channel('foo', 'telegram', ['token' => md5('bar')]);
        $this->guzzle = $this->mock(Client::class);

        $this->driver = new TelegramDriver($this->guzzle);
    }

    public function testGetBaseUrl()
    {
        $this->driver->initialize($this->channel, new Request);

        $this->assertSame(
            'https://api.telegram.org/bot' . $this->channel->getParameter('token'),
            $this->driver->getBaseUrl()
        );
    }

    public function testGetName(): void
    {
        $this->assertSame('Telegram', $this->driver->getName());
    }

    public function testGetShortName(): void
    {
        $this->assertSame('telegram', $this->driver->getShortName());
    }

    public function testGetDefaultParameters(): void
    {
        $this->assertSame(['token' => ''], $this->driver->getDefaultParameters());
    }

    public function testGetTemplateCompiler()
    {
        $this->assertInstanceOf(TelegramTemplateCompiler::class, $this->driver->getTemplateCompiler());
    }

    public function testGetCommandHandler()
    {
        $this->assertInstanceOf(TelegramCommandHandler::class, $this->driver->getCommandHandler());
    }

    public function testVerifyRequestWithCallbackQuery()
    {
        $body = json_encode([
            'callback_query' => [
                'from' => [],
            ],
        ]);

        $request = new Request(null, null, stream_for($body), []);

        $this->driver->initialize($this->channel, $request);

        $this->driver->verifyRequest();
    }

    public function testVerifyRequestWithMessage()
    {
        $body = json_encode([
            'message' => [
                'from' => [],
            ],
        ]);

        $request = new Request(null, null, stream_for($body), []);

        $this->driver->initialize($this->channel, $request);

        $this->driver->verifyRequest();
    }

    /**
     * @expectedException \FondBot\Drivers\Exceptions\InvalidRequest
     * @expectedExceptionMessage Invalid payload
     */
    public function testVerifyRequestInvalidPayload(): void
    {
        $request = new Request;

        $this->driver->initialize($this->channel, $request);

        $this->driver->verifyRequest();
    }

    public function testGetChat(): void
    {
        $body = json_encode([
            'message' => [
                'chat' => $response = [
                    'id' => Str::random(),
                    'title' => $this->faker()->userName,
                    'type' => 'private',
                ],
            ],
        ]);

        $request = new Request(null, null, stream_for($body), []);

        $this->driver->initialize($this->channel, $request);

        $chat = $this->driver->getChat();
        $this->assertInstanceOf(Chat::class, $chat);
        $this->assertSame($response['id'], $chat->getId());
        $this->assertSame($response['title'], $chat->getTitle());
        $this->assertSame($response['type'], $chat->getType());
    }

    public function testGetUserFromCallbackQuery()
    {
        $body = json_encode([
            'callback_query' => [
                'from' => $response = [
                    'id' => $this->faker()->uuid,
                    'first_name' => $this->faker()->firstName,
                    'last_name' => $this->faker()->lastName,
                    'username' => $this->faker()->userName,
                ],
            ],
        ]);

        $request = new Request(null, null, stream_for($body), []);

        $this->driver->initialize($this->channel, $request);

        $user = $this->driver->getUser();
        $this->assertInstanceOf(User::class, $user);
        $this->assertSame($response['id'], $user->getId());
        $this->assertSame($response['first_name'] . ' ' . $response['last_name'], $user->getName());
        $this->assertSame($response['username'], $user->getUsername());
    }

    public function testGetUserFromMessage()
    {
        $body = json_encode([
            'message' => [
                'from' => $response = [
                    'id' => $this->faker()->uuid,
                    'first_name' => $this->faker()->firstName,
                    'last_name' => $this->faker()->lastName,
                    'username' => $this->faker()->userName,
                ],
            ],
        ]);

        $request = new Request(null, null, stream_for($body), []);

        $this->driver->initialize($this->channel, $request);

        $user = $this->driver->getUser();
        $this->assertInstanceOf(User::class, $user);
        $this->assertSame($response['id'], $user->getId());
        $this->assertSame($response['first_name'] . ' ' . $response['last_name'], $user->getName());
        $this->assertSame($response['username'], $user->getUsername());
    }

    public function testGetMessage(): void
    {
        $this->driver->initialize($this->channel, new Request);

        /** @var TelegramReceivedMessage $message */
        $message = $this->driver->getMessage();
        $this->assertInstanceOf(TelegramReceivedMessage::class, $message);
    }

//    public function test_getMessage_with_contact_full(): void
//    {
//        $this->driver->fill(
//            $this->parameters,
//            new Request([
//                'message' => [
//                    'contact' => $contact = [
//                        'phone_number' => $phoneNumber = $this->faker()->phoneNumber,
//                        'first_name' => $firstName = $this->faker()->firstName,
//                        'last_name' => $lastName = $this->faker()->lastName,
//                        'user_id' => $userId = $this->faker()->uuid,
//                    ],
//                ],
//            ], [])
//        );
//
//        /** @var TelegramReceivedMessage $message */
//        $message = $this->driver->getMessage();
//        $this->assertInstanceOf(TelegramReceivedMessage::class, $message);
//        $this->assertSame($contact, $message->getContact());
//
//        $contact = $message->getContact();
//        $this->assertSame($phoneNumber, $contact['phone_number']);
//        $this->assertSame($firstName, $contact['first_name']);
//        $this->assertSame($lastName, $contact['last_name']);
//        $this->assertSame($userId, $contact['user_id']);
//    }
//
//    public function test_getMessage_with_contact_partial(): void
//    {
//        $this->driver->fill(
//            $this->parameters,
//            new Request([
//                'message' => [
//                    'contact' => $contact = [
//                        'phone_number' => $phoneNumber = $this->faker()->phoneNumber,
//                        'first_name' => $firstName = $this->faker()->firstName,
//                    ],
//                ],
//            ], [])
//        );
//
//        $contact = array_merge($contact, ['last_name' => null, 'user_id' => null]);
//
//        /** @var TelegramReceivedMessage $message */
//        $message = $this->driver->getMessage();
//        $this->assertInstanceOf(TelegramReceivedMessage::class, $message);
//        $this->assertSame($contact, $message->getContact());
//
//        $contact = $message->getContact();
//        $this->assertSame($phoneNumber, $contact['phone_number']);
//        $this->assertSame($firstName, $contact['first_name']);
//        $this->assertNull($contact['last_name']);
//        $this->assertNull($contact['user_id']);
//    }
//
//    public function test_getMessage_with_venue_full(): void
//    {
//        $latitude = $this->faker()->latitude;
//        $longitude = $this->faker()->longitude;
//
//        $this->driver->fill(
//            $this->parameters,
//            new Request([
//                'message' => [
//                    'text' => $this->faker()->text,
//                    'venue' => $venue = [
//                        'location' => [
//                            'latitude' => $latitude,
//                            'longitude' => $longitude,
//                        ],
//                        'title' => $title = $this->faker()->title,
//                        'address' => $address = $this->faker()->address,
//                        'foursquare_id' => $foursquareId = $this->faker()->uuid,
//                    ],
//                ],
//            ], [])
//        );
//
//        $venue['location'] = (new Location)
//            ->setLatitude($venue['location']['latitude'])
//            ->setLongitude($venue['location']['longitude']);
//
//        /** @var TelegramReceivedMessage $message */
//        $message = $this->driver->getMessage();
//        $this->assertInstanceOf(TelegramReceivedMessage::class, $message);
//        $this->assertEquals($venue, $message->getVenue());
//
//        $venue = $message->getVenue();
//        /** @var Location $location */
//        $location = $venue['location'];
//        $this->assertInstanceOf(Location::class, $location);
//        $this->assertSame($latitude, $location->getLatitude());
//        $this->assertSame($longitude, $location->getLongitude());
//        $this->assertSame($title, $venue['title']);
//        $this->assertSame($address, $venue['address']);
//        $this->assertSame($foursquareId, $venue['foursquare_id']);
//    }
//
//    public function test_getMessage_with_venue_partial(): void
//    {
//        $latitude = $this->faker()->latitude;
//        $longitude = $this->faker()->longitude;
//
//        $this->driver->fill(
//            $this->parameters,
//            new Request([
//                'message' => [
//                    'text' => $this->faker()->text,
//                    'venue' => $venue = [
//                        'location' => [
//                            'latitude' => $latitude,
//                            'longitude' => $longitude,
//                        ],
//                        'title' => $title = $this->faker()->title,
//                        'address' => $address = $this->faker()->address,
//                    ],
//                ],
//            ], [])
//        );
//
//        $venue['location'] = (new Location)
//            ->setLatitude($venue['location']['latitude'])
//            ->setLongitude($venue['location']['longitude']);
//
//        $venue['foursquare_id'] = null;
//
//        /** @var TelegramReceivedMessage $message */
//        $message = $this->driver->getMessage();
//        $this->assertInstanceOf(TelegramReceivedMessage::class, $message);
//        $this->assertEquals($venue, $message->getVenue());
//
//        $venue = $message->getVenue();
//        /** @var Location $location */
//        $location = $venue['location'];
//        $this->assertInstanceOf(Location::class, $location);
//        $this->assertSame($latitude, $location->getLatitude());
//        $this->assertSame($longitude, $location->getLongitude());
//        $this->assertSame($title, $venue['title']);
//        $this->assertSame($address, $venue['address']);
//        $this->assertNull($venue['foursquare_id']);
//    }
//
//
}
