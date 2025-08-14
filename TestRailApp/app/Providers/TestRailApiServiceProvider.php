<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\API\TestRailClient;

class TestRailApiServiceProvider extends ServiceProvider
{
    /**
     * Register services for the TestRail API
     *
     * @return App\API\TestRailClient $client
     */
    public function register()
    {

        $this->app->bind('App\API\TestRailClient', function ($app) {

            // Grab the testrail api url and other things the client needs via the .env file.
            $apiURL = env("TEST_RAIL_API_URL", "https://example.testrail.com");
            $apiUserName = env("TEST_RAIL_API_USERNAME", "JoeSmith@gmail.com");
            $apiPassword = env("TEST_RAIL_API_PASSWORD", "QNzsRa3xgv3qT994");

            $client = new TestRailClient($apiURL);
            $client->set_user($apiUserName);
            $client->set_password($apiPassword);

            return $client;
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {

    }
}
