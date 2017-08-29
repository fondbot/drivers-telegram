<?php

declare(strict_types=1);

namespace FondBot\Drivers\Telegram;

use RuntimeException;
use GuzzleHttp\Client;
use FondBot\Drivers\Telegram\Types\Chat;
use FondBot\Drivers\Telegram\Types\File;
use FondBot\Drivers\Telegram\Types\User;
use FondBot\Drivers\Telegram\Types\Message;
use FondBot\Drivers\Telegram\Types\ChatMember;
use FondBot\Drivers\Telegram\Types\ForceReply;
use FondBot\Drivers\Telegram\Types\UserProfilePhotos;
use FondBot\Drivers\Telegram\Types\ReplyKeyboardMarkup;
use FondBot\Drivers\Telegram\Types\ReplyKeyboardRemove;
use FondBot\Drivers\Telegram\Types\InlineKeyboardMarkup;

class TelegramClient
{
    private $guzzle;
    private $token;

    private const BASE_URL = 'https://api.telegram.org';

    public function __construct(Client $guzzle, string $token)
    {
        $this->guzzle = $guzzle;
        $this->token = $token;
    }

    public function getBaseUrl(): string
    {
        return self::BASE_URL.'/bot'.$this->token;
    }

    public function setGuzzle(Client $guzzle): void
    {
        $this->guzzle = $guzzle;
    }

    /**
     * A simple method for testing your bot's auth token. Requires no parameters.
     * Returns basic information about the bot in form of a User object.
     *
     * @return User
     */
    public function getMe(): User
    {
        return User::fromJson($this->request('getMe'));
    }

    /**
     * Use this method to send text messages.
     * On success, the sent Message is returned.
     *
     * @param string $chatId
     * @param string $text
     * @param string|null $parseMode
     * @param bool|null $disableWebPagePreview
     * @param bool|null $disableNotification
     * @param int|null $replyToMessageId
     * @param InlineKeyboardMarkup|ReplyKeyboardMarkup|ReplyKeyboardRemove|ForceReply $replyMarkup
     *
     * @return Message
     */
    public function sendMessage(
        string $chatId,
        string $text,
        string $parseMode = null,
        bool $disableWebPagePreview = null,
        bool $disableNotification = null,
        int $replyToMessageId = null,
        $replyMarkup = null
    ): Message {
        $parameters = compact(
            'chatId',
            'text',
            'parseMode',
            'disableWebPagePreview',
            'disableNotification',
            'replyToMessageId',
            'replyMarkup'
        );

        $response = $this->request('sendMessage', $parameters);

        return Message::fromJson($response);
    }

    /**
     * Use this method to forward messages of any kind. On success, the sent Message is returned.
     *
     * @param string $chatId
     * @param $fromChatId
     * @param int $messageId
     * @param bool|null $disableNotification
     *
     * @return Message
     */
    public function forwardMessage(
        string $chatId,
        $fromChatId,
        int $messageId,
        bool $disableNotification = null
    ): Message {
        $parameters = compact('chatId', 'fromChatId', 'messageId', 'disableNotification');

        $response = $this->request('forwardMessage', $parameters);

        return Message::fromJson($response);
    }

    /**
     * Use this method to send photos. On success, the sent Message is returned.
     *
     * @param string $chatId
     * @param string $photo
     * @param string|null $caption
     * @param bool|null $disableNotification
     * @param int|null $replyToMessageId
     * @param InlineKeyboardMarkup|ReplyKeyboardMarkup|ReplyKeyboardRemove|ForceReply $replyMarkup
     *
     * @return Message
     */
    public function sendPhoto(
        string $chatId,
        string $photo,
        string $caption = null,
        bool $disableNotification = null,
        int $replyToMessageId = null,
        $replyMarkup = null
    ): Message {
        $parameters = compact('chatId', 'photo', 'caption', 'disableNotification', 'replyToMessageId', 'replyMarkup');

        $response = $this->request('sendPhoto', $parameters);

        return Message::fromJson($response);
    }

    /**
     * Use this method to send audio files, if you want Telegram clients to display them in the music player.
     * Your audio must be in the .mp3 format. On success, the sent Message is returned.
     * Bots can currently send audio files of up to 50 MB in size, this limit may be changed in the future.
     *
     * For sending voice messages, use the sendVoice method instead.
     *
     * @param string $chatId
     * @param string $audio
     * @param string|null $caption
     * @param int|null $duration
     * @param string|null $performer
     * @param string|null $title
     * @param bool $disableNotification
     * @param int|null $replyToMessageId
     * @param InlineKeyboardMarkup|ReplyKeyboardMarkup|ReplyKeyboardRemove|ForceReply $replyMarkup
     *
     * @return Message
     */
    public function sendAudio(
        string $chatId,
        string $audio,
        string $caption = null,
        int $duration = null,
        string $performer = null,
        string $title = null,
        bool $disableNotification = null,
        int $replyToMessageId = null,
        $replyMarkup = null
    ): Message {
        $parameters = compact(
            'chatId',
            'audio',
            'caption',
            'duration',
            'performer',
            'title',
            'disableNotification',
            'replyToMessageId',
            'replyMarkup'
        );

        $response = $this->request('sendAudio', $parameters);

        return Message::fromJson($response);
    }

    /**
     * Use this method to send general files. On success, the sent Message is returned.
     * Bots can currently send files of any type of up to 50 MB in size, this limit may be changed in the future.
     *
     * @param string $chatId
     * @param string $document
     * @param string|null $caption
     * @param bool|null $disableNotification
     * @param int|null $replyToMessageId
     * @param InlineKeyboardMarkup|ReplyKeyboardMarkup|ReplyKeyboardRemove|ForceReply $replyMarkup
     *
     * @return Message
     */
    public function sendDocument(
        string $chatId,
        string $document,
        string $caption = null,
        bool $disableNotification = null,
        int $replyToMessageId = null,
        $replyMarkup = null
    ): Message {
        $parameters = compact(
            'chatId',
            'document',
            'caption',
            'disableNotification',
            'replyToMessageId',
            'replyMarkup'
        );

        $response = $this->request('sendDocument', $parameters);

        return Message::fromJson($response);
    }

    /**
     * Use this method to send video files, Telegram clients support mp4 videos (other formats may be sent as Document). On success, the sent Message is returned.
     * Bots can currently send video files of up to 50 MB in size, this limit may be changed in the future.
     *
     * @param string $chatId
     * @param string $video
     * @param int $duration
     * @param int $width
     * @param int $height
     * @param string $caption
     * @param bool|null $disableNotification
     * @param int|null $replyToMessageId
     * @param InlineKeyboardMarkup|ReplyKeyboardMarkup|ReplyKeyboardRemove|ForceReply $replyMarkup
     *
     * @return Message
     */
    public function sendVideo(
        string $chatId,
        string $video,
        int $duration = null,
        int $width = null,
        int $height = null,
        string $caption = null,
        bool $disableNotification = null,
        int $replyToMessageId = null,
        $replyMarkup = null
    ): Message {
        $parameters = compact(
            'chatId',
            'video',
            'duration',
            'width',
            'height',
            'caption',
            'disableNotification',
            'replyToMessageId',
            'replyMarkup'
        );

        $response = $this->request('sendVideo', $parameters);

        return Message::fromJson($response);
    }

    /**
     * Use this method to send audio files, if you want Telegram clients to display the file as a playable voice message.
     * For this to work, your audio must be in an .ogg file encoded with OPUS (other formats may be sent as Audio or Document).
     * On success, the sent Message is returned.
     * Bots can currently send voice messages of up to 50 MB in size, this limit may be changed in the future.
     *
     * @param string $chatId
     * @param string $voice
     * @param string|null $caption
     * @param int|null $duration
     * @param bool|null $disableNotification
     * @param int|null $replyToMessageId
     * @param InlineKeyboardMarkup|ReplyKeyboardMarkup|ReplyKeyboardRemove|ForceReply $replyMarkup
     *
     * @return Message
     */
    public function sendVoice(
        string $chatId,
        string $voice,
        string $caption = null,
        int $duration = null,
        bool $disableNotification = null,
        int $replyToMessageId = null,
        $replyMarkup = null
    ): Message {
        $parameters = compact(
            'chatId',
            'voice',
            'caption',
            'duration',
            'disableNotification',
            'replyToMessageId',
            'replyMarkup'
        );

        $response = $this->request('sendVoice', $parameters);

        return Message::fromJson($response);
    }

    /**
     * As of v.4.0, Telegram clients support rounded square mp4 videos of up to 1 minute long.
     * Use this method to send video messages. On success, the sent Message is returned.
     *
     * @param string $chatId
     * @param string $videoNote
     * @param int|null $duration
     * @param int|null $length
     * @param bool|null $disableNotification
     * @param int|null $replyToMessageId
     * @param InlineKeyboardMarkup|ReplyKeyboardMarkup|ReplyKeyboardRemove|ForceReply $replyMarkup
     *
     * @return Message
     */
    public function sendVideoNote(
        string $chatId,
        string $videoNote,
        int $duration = null,
        int $length = null,
        bool $disableNotification = null,
        int $replyToMessageId = null,
        $replyMarkup = null
    ): Message {
        $parameters = compact(
            'chatId',
            'videoNote',
            'duration',
            'length',
            'disableNotification',
            'replyToMessageId',
            'replyMarkup'
        );

        $response = $this->request('sendVideoNote', $parameters);

        return Message::fromJson($response);
    }

    /**
     * Use this method to send point on the map. On success, the sent Message is returned.
     *
     * @param string $chatId
     * @param float $latitude
     * @param float $longitude
     * @param bool|null $disableNotification
     * @param int|null $replyToMessageId
     * @param InlineKeyboardMarkup|ReplyKeyboardMarkup|ReplyKeyboardRemove|ForceReply $replyMarkup
     *
     * @return Message
     */
    public function sendLocation(
        string $chatId,
        float $latitude,
        float $longitude,
        bool $disableNotification = null,
        int $replyToMessageId = null,
        $replyMarkup = null
    ): Message {
        $parameters = compact(
            'chatId',
            'latitude',
            'longitude',
            'disableNotification',
            'replyToMessageId',
            'replyMarkup'
        );

        $response = $this->request('sendLocation', $parameters);

        return Message::fromJson($response);
    }

    /**
     * Use this method to send information about a venue. On success, the sent Message is returned.
     *
     * @param string $chatId
     * @param float $latitude
     * @param float $longitude
     * @param string $title
     * @param string $address
     * @param string|null $foursquareId
     * @param bool|null $disableNotification
     * @param int|null $replyToMessageId
     * @param InlineKeyboardMarkup|ReplyKeyboardMarkup|ReplyKeyboardRemove|ForceReply $replyMarkup
     *
     * @return Message
     */
    public function sendVenue(
        string $chatId,
        float $latitude,
        float $longitude,
        string $title,
        string $address,
        string $foursquareId = null,
        bool $disableNotification = null,
        int $replyToMessageId = null,
        $replyMarkup = null
    ): Message {
        $parameters = compact(
            'chatId',
            'latitude',
            'longitude',
            'title',
            'address',
            'foursquareId',
            'disableNotification',
            'replyToMessageId',
            'replyMarkup'
        );

        $response = $this->request('sendVenue', $parameters);

        return Message::fromJson($response);
    }

    /**
     * Use this method to send phone contacts. On success, the sent Message is returned.
     *
     * @param string $chatId
     * @param string $phoneNumber
     * @param string $firstName
     * @param string $lastName
     * @param bool|null $disableNotification
     * @param int|null $replyToMessageId
     * @param InlineKeyboardMarkup|ReplyKeyboardMarkup|ReplyKeyboardRemove|ForceReply $replyMarkup
     *
     * @return Message
     */
    public function sendContact(
        string $chatId,
        string $phoneNumber,
        string $firstName,
        string $lastName,
        bool $disableNotification = null,
        int $replyToMessageId = null,
        $replyMarkup = null
    ): Message {
        $parameters = compact(
            'chatId',
            'phoneNumber',
            'firstName',
            'lastName',
            'disableNotification',
            'replyToMessageId',
            'replyMarkup'
        );

        $response = $this->request('sendContact', $parameters);

        return Message::fromJson($response);
    }

    /**
     * Use this method when you need to tell the user that something is happening on the bot's side.
     * The status is set for 5 seconds or less (when a message arrives from your bot, Telegram clients clear its typing status). Returns True on success.
     * We only recommend using this method when a response from the bot will take a noticeable amount of time to arrive.
     *
     * @see https://core.telegram.org/bots/api#sendchataction
     *
     * @param string $chatId
     * @param string $action
     *
     * @return bool
     */
    public function sendChatAction(string $chatId, string $action): bool
    {
        return $this->request('sendChatAction', compact('chatId', 'action'));
    }

    /**
     * Use this method to get a list of profile pictures for a user. Returns a UserProfilePhotos object.
     *
     * @param int $userId
     * @param int|null $offset
     * @param int|null $limit
     *
     * @return UserProfilePhotos
     */
    public function getUserProfilePhotos(int $userId, int $offset = null, int $limit = null): UserProfilePhotos
    {
        $response = $this->request('getUserProfilePhotos', compact('userId', 'offset', 'limit'));

        return UserProfilePhotos::fromJson($response);
    }

    /**
     * Use this method to get basic info about a file and prepare it for downloading.
     * For the moment, bots can download files of up to 20MB in size.
     * On success, a File object is returned.
     * The file can then be downloaded via the link https://api.telegram.org/file/bot<token>/<file_path>, where <file_path> is taken from the response.
     * It is guaranteed that the link will be valid for at least 1 hour.
     * When the link expires, a new one can be requested by calling getFile again.
     *
     * @param string $fileId
     *
     * @return File
     */
    public function getFile(string $fileId): File
    {
        $response = $this->request('getFile', compact('fileId'));

        return File::fromJson($response);
    }

    /** Use this method to kick a user from a group, a supergroup or a channel.
     * In the case of supergroups and channels, the user will not be able to return to the group on their own using invite links, etc., unless unbanned first.
     * The bot must be an administrator in the chat for this to work and must have the appropriate admin rights.
     * Returns True on success.
     *
     * @param string $chatId
     * @param int $userId
     * @param int|null $untilDate
     *
     * @return bool
     */
    public function kickChatMember(string $chatId, int $userId, int $untilDate = null): bool
    {
        return $this->request('kickChatMember', compact('chatId', 'userId', 'untilDate'));
    }

    /**
     * Use this method to unban a previously kicked user in a supergroup or channel.
     * The user will not return to the group or channel automatically, but will be able to join via link, etc.
     * The bot must be an administrator for this to work.
     * Returns True on success.
     *
     * @param string $chatId
     * @param int $userId
     *
     * @return bool
     */
    public function unbanChatMember(string $chatId, int $userId): bool
    {
        return $this->request('unbanChatMember', compact('chatId', 'userId'));
    }

    /**
     * Use this method to restrict a user in a supergroup.
     * The bot must be an administrator in the supergroup for this to work and must have the appropriate admin rights.
     * Pass True for all boolean parameters to lift restrictions from a user.
     * Returns True on success.
     *
     * @param string $chatId
     * @param int $userId
     * @param int|null $untilDate
     * @param bool|null $canSendMessages
     * @param bool|null $canSendMediaMessages
     * @param bool|null $canSendOtherMessages
     * @param bool|null $canAddWebPagePreviews
     *
     * @return bool
     */
    public function restrictChatMember(
        string $chatId,
        int $userId,
        int $untilDate = null,
        bool $canSendMessages = null,
        bool $canSendMediaMessages = null,
        bool $canSendOtherMessages = null,
        bool $canAddWebPagePreviews = null
    ): bool {
        return $this->request('restrictChatMember', compact(
            'chatId',
            'userId',
            'untilDate',
            'canSendMessages',
            'canSendMediaMessages',
            'canSendOtherMessages',
            'canAddWebPagePreviews'
        ));
    }

    /**
     * Use this method to promote or demote a user in a supergroup or a channel.
     * The bot must be an administrator in the chat for this to work and must have the appropriate admin rights.
     * Pass False for all boolean parameters to demote a user.
     * Returns True on success.
     *
     * @param string $chatId
     * @param int $userId
     * @param bool|null $canChangeInfo
     * @param bool|null $canPostMessages
     * @param bool|null $canEditMessages
     * @param bool|null $canDeleteMessages
     * @param bool|null $canInviteUsers
     * @param bool|null $canRestrictMembers
     * @param bool|null $canPinMessages
     * @param bool|null $canPromoteMembers
     *
     * @return bool
     */
    public function promoteChatMember(
        string $chatId,
        int $userId,
        bool $canChangeInfo = null,
        bool $canPostMessages = null,
        bool $canEditMessages = null,
        bool $canDeleteMessages = null,
        bool $canInviteUsers = null,
        bool $canRestrictMembers = null,
        bool $canPinMessages = null,
        bool $canPromoteMembers = null
    ): bool {
        return $this->request('promoteChatMember', compact(
            'chatId',
            'userId',
            'canChangeInfo',
            'canPostMessages',
            'canEditMessages',
            'canDeleteMessages',
            'canInviteUsers',
            'canRestrictMembers',
            'canPinMessages',
            'canPromoteMembers'
        ));
    }

    /**
     * Use this method to export an invite link to a supergroup or a channel.
     * The bot must be an administrator in the chat for this to work and must have the appropriate admin rights.
     * Returns exported invite link as String on success.
     *
     * @param string $chatId
     *
     * @return string
     */
    public function exportChatInviteLink(string $chatId): string
    {
        return $this->request('exportChatInviteLink', compact('chatId'));
    }

    /**
     * Use this method to set a new profile photo for the chat.
     * Photos can't be changed for private chats.
     * The bot must be an administrator in the chat for this to work and must have the appropriate admin rights.
     * Returns True on success.
     *
     * @param string $chatId
     * @param string $photo
     *
     * @return bool
     */
    public function setChatPhoto(string $chatId, string $photo): bool
    {
        return $this->request('setChatPhoto', compact('chatId', 'photo'));
    }

    /**
     * Use this method to delete a chat photo.
     * Photos can't be changed for private chats.
     * The bot must be an administrator in the chat for this to work and must have the appropriate admin rights.
     * Returns True on success.
     *
     * @param string $chatId
     *
     * @return bool
     */
    public function deleteChatPhoto(string $chatId): bool
    {
        return $this->request('deleteChatPhoto', compact('chatId'));
    }

    /**
     * Use this method to change the title of a chat.
     * Titles can't be changed for private chats.
     * The bot must be an administrator in the chat for this to work and must have the appropriate admin rights.
     * Returns True on success.
     *
     * @param string $chatId
     * @param string $title
     *
     * @return bool
     */
    public function setChatTitle(string $chatId, string $title): bool
    {
        return $this->request('setChatTitle', compact('chatId', 'title'));
    }

    /**
     * Use this method to change the description of a supergroup or a channel.
     * The bot must be an administrator in the chat for this to work and must have the appropriate admin rights.
     * Returns True on success.
     *
     * @param string $chatId
     * @param string $description
     *
     * @return bool
     */
    public function setChatDescription(string $chatId, string $description = ''): bool
    {
        return $this->request('setChatDescription', compact('chatId', 'description'));
    }

    /**
     * Use this method to pin a message in a supergroup.
     * The bot must be an administrator in the chat for this to work and must have the appropriate admin rights.
     * Returns True on success.
     *
     * @param string $chatId
     * @param int $messageId
     * @param bool|null $disableNotification
     *
     * @return bool
     */
    public function pinChatMessage(string $chatId, int $messageId, bool $disableNotification = null): bool
    {
        return $this->request('pinChatMessage', compact('chatId', 'messageId', 'disableNotification'));
    }

    /**
     * Use this method to unpin a message in a supergroup chat.
     * The bot must be an administrator in the chat for this to work and must have the appropriate admin rights.
     * Returns True on success.
     *
     * @param string $chatId
     * @return bool
     */
    public function unpinChatMessage(string $chatId): bool
    {
        return $this->request('unpinChatMessage', compact('chatId'));
    }

    /**
     * Use this method for your bot to leave a group, supergroup or channel. Returns True on success.
     *
     * @param string $chatId
     *
     * @return bool
     */
    public function leaveChat(string $chatId): bool
    {
        return $this->request('leaveChat', compact('chatId'));
    }

    /**
     * Use this method to get up to date information about the chat (current name of the user for one-on-one conversations, current username of a user, group or channel, etc.).
     * Returns a Chat object on success.
     *
     * @param string $chatId
     * @return Chat
     */
    public function getChat(string $chatId): Chat
    {
        return Chat::fromJson(
            $this->request('getChat', compact('chatId'))
        );
    }

    /**
     * Use this method to get a list of administrators in a chat.
     * On success, returns an Array of ChatMember objects that contains information about all chat administrators except other bots.
     * If the chat is a group or a supergroup and no administrators were appointed, only the creator will be returned.
     *
     * @param string $chatId
     *
     * @return ChatMember[]
     */
    public function getChatAdministrators(string $chatId): array
    {
        $response = $this->request('getChatAdministrators', compact('chatId'));

        return ChatMember::fromJson($response, true);
    }

    /**
     * Use this method to get the number of members in a chat. Returns Int on success.
     *
     * @param string $chatId
     *
     * @return int
     */
    public function getChatMembersCount(string $chatId): int
    {
        return $this->request('getChatMembersCount', compact('chatId'));
    }

    /**
     * Use this method to get information about a member of a chat. Returns a ChatMember object on success.
     *
     * @param string $chatId
     * @param int $userId
     *
     * @return ChatMember
     */
    public function getChatMember(string $chatId, int $userId): ChatMember
    {
        return ChatMember::fromJson(
            $this->request('getChatMember', compact('chatId', 'userId'))
        );
    }

    /**
     * Use this method to send answers to callback queries sent from inline keyboards.
     * The answer will be displayed to the user as a notification at the top of the chat screen or as an alert.
     * On success, True is returned.
     *
     * @param string $callbackQueryId
     * @param string|null $text
     * @param bool|null $showAlert
     * @param string|null $url
     * @param int $cacheTime
     *
     * @return bool
     */
    public function answerCallbackQuery(
        string $callbackQueryId,
        string $text = null,
        bool $showAlert = null,
        string $url = null,
        int $cacheTime = null
    ): bool {
        return $this->request(
            'answerCallbackQuery',
            compact('callbackQueryId', 'text', 'showAlert', 'url', 'cacheTime')
        );
    }

    /**
     * Send request.
     *
     * @param string $endpoint
     * @param array $parameters
     *
     * @return mixed
     */
    public function request(string $endpoint, array $parameters = [])
    {
        // Remove parameters with null value
        $parameters = collect($parameters)
            ->mapWithKeys(function ($value, $key) {
                return [snake_case($key) => $value];
            })
            ->filter(function ($value) {
                return $value !== null;
            })
            ->toArray();

        $response = $this->guzzle->get($this->getBaseUrl().'/'.$endpoint, ['json' => $parameters]);
        $body = (string) $response->getBody();
        $json = json_decode($body);

        if ($json->ok !== true) {
            throw new RuntimeException($body);
        }

        return $json->result;
    }
}
