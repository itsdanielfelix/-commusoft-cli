<?php

declare(strict_types=1);

namespace App\Commands\Core;

use App\Contracts\ConfigurationContract;
use LaravelZero\Framework\Commands\Command;

final class ConfigCommand extends Command
{
    protected $signature = 'config';

    protected $description = 'Basic configuration needs to be done to use the cli tool';

    public function handle(ConfigurationContract $config): int
    {
        $username = $this->ask(
            question: 'What is your Username of Graylog?',
        );

        if (! $username) {
            $this->warn(
                string: 'You need to supply your Username of Graylog to use this application.',
            );

            return ConfigCommand::FAILURE;
        }

        $password = $this->secret(
            question: 'What is your Password of Graylog?',
        );

        if (! $password) {
            $this->warn(
                string: 'You need to supply your Password of Graylog to use this application.',
            );

            return ConfigCommand::FAILURE;
        }

        $config->clear()
            ->set(
                key: 'graylog_username',
                value: $username,
            )
            ->set(
                key: 'graylog_password',
                value: $password,
            )->set(
                key: 'graylog_baseurl',
                value: 'https://graylog.commusoft.co.uk/',
            );

        $this->info(
            string: 'Configuration stored successfully',
        );

        return ConfigCommand::SUCCESS;
    }
}
