<?php

namespace Kristianedlund\LaravelExternalQueue\Connectors;

use Illuminate\Queue\Connectors\ConnectorInterface;
use Kristianedlund\LaravelExternalQueue\ExternalSqsQueue;
use Aws\Sqs\SqsClient;

class ExternalSqsConnector implements ConnectorInterface
{
    /**
     * Establish a queue connection.
     *
     * @param  array  $config
     * @return \Illuminate\Contracts\Queue\Queue
     */
    public function connect(array $config)
    {
        $sqs = SqsClient::factory($config);
        return new ExternalSqsQueue($sqs, $config['queue']);
    }
}
