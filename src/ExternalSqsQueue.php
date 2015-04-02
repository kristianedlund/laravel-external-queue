<?php

namespace Kristianedlund\LaravelExternalQueue;

use Illuminate\Queue\SqsQueue;
use Kristianedlund\LaravelExternalQueue\Jobs\ExternalSqsJob;
use Illuminate\Contracts\Queue\Queue as QueueContract;

class ExternalSqsQueue extends SqsQueue implements QueueContract
{

    /**
     * Pop the next job off of the queue.
     *
     * @param  string  $queue
     * @return \Illuminate\Contracts\Queue\Job|null
     */
    public function pop($queue = null)
    {
        $queue = $this->getQueue($queue);
        $response = $this->sqs->receiveMessage(
            array('QueueUrl' => $queue, 'AttributeNames' => array('ApproximateReceiveCount'))
        );
        if (count($response['Messages']) > 0)
        {
            return new ExternalSqsJob($this->container, $this->sqs, $queue, $response['Messages'][0]);
        }
    }
}
