<?php

declare(strict_types=1);

namespace FondBot\Drivers\Telegram\Commands;

use Illuminate\Console\Command;
use FondBot\Contracts\Channels\Manager;
use FondBot\Drivers\Telegram\TelegramDriver;

class SetWebhook extends Command
{
    protected $signature = 'telegram:set-webhook';
    protected $description = 'Set Webhook URL for a specific channel';

    public function handle(Manager $channels): void
    {
        $options = $channels->getByDriver('telegram')->keys()->toArray();

        $selected = $this->choice('Choose channel', $options);

        $channel = $channels->create($selected);

        /** @var TelegramDriver $driver */
        $driver = $channel->getDriver();

        $result = $driver->getClient()->setWebhook($channel->getWebhookUrl());

        if (!$result) {
            $this->error('Webhook set failed.');

            exit(0);
        }

        $this->info('Webhook set success.');
    }
}
