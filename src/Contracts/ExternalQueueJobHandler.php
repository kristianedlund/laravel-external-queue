<?php

namespace Kristianedlund\LaravelExternalQueue\Contracts;

use Illuminate\Queue\Jobs\Job;

interface ExternalQueueJobHandler
{


    /**
     * Triggered by the worker in order to process the job
     * @param  Job    $job  The job
     * @param  data   $data The data in the message
     *
     * @return void
     */
    public function handle(Job $job, $data = null);
}
