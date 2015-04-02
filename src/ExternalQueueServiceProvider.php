<?php

namespace Kristianedlund\LaravelExternalQueue;

use Illuminate\Support\ServiceProvider;
use Kristianedlund\LaravelExternalQueue\Connectors\ExternalSqsConnector;

class ExternalQueueServiceProvider extends ServiceProvider
{

    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/externalqueue.php' => config_path('externalqueue.php')
        ]);
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {

        $this->app->booted(function () {
            /**
             * @var \Illuminate\Queue\QueueManager $manager
             */
            $manager = $this->app['queue'];
            $manager->addConnector('externalsqs', function () {
                return new ExternalSqsConnector;
            });
        });

    }
}
