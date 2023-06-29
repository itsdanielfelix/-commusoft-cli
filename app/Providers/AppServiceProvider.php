<?php

declare(strict_types=1);

namespace App\Providers;

use App\Contracts\ConfigurationContract;
use App\Repositories\LocalConfiguration;
use Illuminate\Support\ServiceProvider;

final class AppServiceProvider extends ServiceProvider
{
    public array $bindings = [
        ConfigurationContract::class => LocalConfiguration::class,
    ];

    public function register(): void
    {
        $this->app->singleton(
            abstract: LocalConfiguration::class,
            concrete: static function (): LocalConfiguration {
                $path = isset($_ENV['APP_ENV']) && $_ENV['APP_ENV'] === 'testing'
                    ? base_path(path: 'tests')
                    : ($_SERVER['HOME'] ?? $_SERVER['USERPROFILE']);

                return new LocalConfiguration(
                    path: "$path/.commusoft/config.json",
                );
            },
        );
    }
}
