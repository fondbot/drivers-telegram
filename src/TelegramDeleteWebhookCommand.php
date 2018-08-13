<?php

declare(strict_types=1);

namespace FondBot\Drivers\Telegram;

use Illuminate\Console\Command;
use FondBot\Contracts\Channels\Manager;
use unreal4u\TelegramAPI\Telegram\Methods\DeleteWebhook;

class TelegramDeleteWebhookCommand extends Command
{
    protected $signature = 'fondbot:driver:telegram:delete-webhook';
    protected $description = 'Delete Telegram webhook';

    public function handle(Manager $channels): void
    {
        $options = $channels->getByDriver('telegram')->keys()->toArray();

        $selected = $this->choice('Choose channel', $options);

        $channel = $channels->create($selected);

        /** @var TelegramDriver $driver */
        $driver = $channel->getDriver();

        $request = new DeleteWebhook();

        $result = $driver->getClient()->performApiRequest($request);

        if (!$result) {
            $this->error('Webhook delete failed.');

            exit(0);
        }

        $this->info('Webhook deleted.');
    }
}
