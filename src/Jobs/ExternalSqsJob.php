<?php

namespace Kristianedlund\LaravelExternalQueue\Jobs;

use Illuminate\Contracts\Queue\Job as JobContract;
use Illuminate\Queue\Jobs\SqsJob;

class ExternalSqsJob extends SqsJob implements JobContract
{

    /**
     * Fire the job.
     *
     * @return void
     */
    public function fire()
    {

        $handler = $this->resolveHandler();
        $data = $this->getJobData();

        $handler->handle($this, $data);
    }

    /**
     * Extract the payload data from the queue message
     * @return Array The payload data
     */
    protected function getJobData()
    {
        $rawdata = $this->decodePayload();

        return $rawdata['data'];
    }

    /**
     * Spawns a new handler for the specific job
     * @return Kristianedlund\ExternalQueue\Contracts\ExternalQueueJobHandler The handler for this this job
     */
    protected function resolveHandler()
    {

        $job = $this->getJobName();

        //Get the handler class name
        $classname = config('externalqueue.handlers.' . $job, '');

        if (!class_exists($classname) ||
            !in_array('Kristianedlund\LaravelExternalQueue\Contracts\ExternalQueueJobHandler', class_implements($classname))
        ) {
            throw new \UnexpectedValueException('The handler class for ' . $job . ' was not found');
        }

        return new $classname;
    }

    /**
     * Get the job name
     * @return string The job name
     */
    protected function getJobName()
    {
        $rawdata = $this->decodePayload();

        return $rawdata['job'];
    }

    /**
     * Decode the payload data in the message
     * @return Array The decoded data
     */
    protected function decodePayload()
    {
        return json_decode($this->getRawBody(), true);
    }
}
