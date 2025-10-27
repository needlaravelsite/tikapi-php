<?php

namespace NeedLaravelSite\TikApi;

use Illuminate\Support\ServiceProvider;
use GuzzleHttp\Client as GuzzleClient;
use NeedLaravelSite\TikApi\Client\HttpClient;

class TikApiServiceProvider extends ServiceProvider
{
    /**
     * Register the TikApi services.
     */
    public function register(): void
    {
        // Merge the config file
        $this->mergeConfigFrom(__DIR__ . '/../config/tikapi.php', 'tikapi');

        // Bind the HttpClient (transport layer)
        $this->app->singleton(HttpClient::class, function ($app) {
            $config = $app['config']->get('tikapi');

            $apiKey = $config['api_key'] ?? env('TIKAPI_API_KEY');
            $accountKey = $config['account_key'] ?? env('TIKAPI_ACCOUNT_KEY');
            $baseUrl = $config['base_url'] ?? env('TIKAPI_BASE_URL', 'https://api.tikapi.io');

            $guzzleOptions = $config['guzzle'] ?? [];

            $guzzle = new GuzzleClient($guzzleOptions);

            return new HttpClient($guzzle, $apiKey, $accountKey, $baseUrl);
        });

        // Bind the main TikApi SDK
        $this->app->singleton(TikApi::class, function ($app) {
            return new TikApi();
        });

        // Add alias for easier resolving
        $this->app->alias(TikApi::class, 'tikapi');
    }

    /**
     * Boot configuration publishing.
     */
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/tikapi.php' => config_path('tikapi.php'),
            ], 'config');
        }
    }
}
