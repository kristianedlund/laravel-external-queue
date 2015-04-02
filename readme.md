# Laravel External Queues

Laravel queues are an awesome thing to use internally in an application in order to manage asynchronous tasks. However, in the usecase where you want external components such as desktop applications or other web applications to communicate with Laravel through queues it becomes somewhat more messy, since there is quite a bit of information embedded in a queue message about the internal workings, such as class names.

This package is an attempt to let applications communicate through queues by using a string as the job name, and then letting the internals of Laravel translate handle the execution.

If you don't need to send queue messages outside of your laravel application, then you don't need this package. The default works excellent.

## Installation

Pull this package in through Composer.

```js
{
    "require": {
        "kristianedlund/laravel-external-queue": "0.1"
    }
}
```

    $ composer update

Add the package to your application service providers in `config/app.php`

```php
'providers' => [
    
    'Illuminate\Foundation\Providers\ArtisanServiceProvider',
    'Illuminate\Auth\AuthServiceProvider',
    ...
    
    'Kristianedlund\LaravelExternalQueue\ExternalQueueServiceProvider',

],
```

Publish the package config file to your application.

    $ php artisan vendor:publish


## Usage

### Configuration

First of all you set up an external queue in the normal queue config file in laravel. It should look like

```php
'sqs' => [
    'driver' => 'externalsqs',
    'key'    => 'your-public-key',
    'secret' => 'your-secret-key',
    'queue'  => 'your-queue-url',
    'region' => 'us-east-1',
],
```

Second part is that you set up the different job names and map them to handler classes in the "externalqueue" config file.


### Handler files
Last but not least you need to write the handler files.

They need to implement the handler contract `Kristianedlund\LaravelExternalQueue\Contracts\ExternalQueueJobHandler` and could look like

```php
<?php

namespace App\Handlers\ExternalJobs;

use Kristianedlund\LaravelExternalQueue\Contracts\ExternalQueueJobHandler as HandlerContract;
use Illuminate\Queue\Jobs\Job;

class TestJob implements HandlerContract
{
    public function handle(Job $job, $data = null)
    {
        // Do you job handling here
    }
}
```

### License

The Laravel External Queue is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT).