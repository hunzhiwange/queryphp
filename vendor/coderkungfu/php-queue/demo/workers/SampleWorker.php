<?php
class SampleWorker extends PHPQueue\Worker
{
    /**
     * @param \PHPQueue\Job $jobObject
     */
    public function runJob($jobObject)
    {
        parent::runJob($jobObject);
        $jobData = $jobObject->data;
        $jobData['var2'] = "Welcome back2222222222222222!";
        $this->result_data = $jobData;
    }
}
