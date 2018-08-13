<?php

declare(strict_types=1);

namespace FondBot\Drivers\Telegram;

use Illuminate\Console\Command;
use FondBot\Contracts\Channels\Manager;
use unreal4u\TelegramAPI\Telegram\Methods\SetWebhook;

class TelegramSetWebhookCommand extends Command
{
    protected $signature = 'fondbot:driver:telegram:set-webhook';
    protected $description = 'Set Telegram webhook';

    public function handle(Manager $channels): void
    {
        $options = $channels->getByDriver('telegram')->keys()->toArray();

        $selected = $this->choice('Choose channel', $options);

        $channel = $channels->create($selected);

        /** @var TelegramDriver $driver */
        $driver = $channel->getDriver();

        $request = new SetWebhook();
        $request->url = $channel->getWebhookUrl();

        $result = $driver->getClient()->performApiRequest($request);

        if (!$result) {
            $this->error('Webhook update failed.');

            exit(0);
        }

        $this->info('Webhook updated.');
    }
}
