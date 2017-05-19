<?php

namespace Illuminate\Contracts\Queue;

interface Job
{
    
    
    public function isSuccessful()
    {
        return ($this->status == self::OK);
    }
    
    public function onSuccessful()
    {
        $this->status = self::OK;
    }
    
    public function onError()
    {
        $this->status = self::NOT_OK;
    }
    
    
    /**
     * Fire the job.
     *
     * @return void
     */
    public function fire();

    /**
     * Delete the job from the queue.
     *
     * @return void
     */
    public function delete();

    /**
     * Determine if the job has been deleted.
     *
     * @return bool
     */
    public function isDeleted();

    /**
     * Release the job back into the queue.
     *
     * @param  int   $delay
     * @return void
     */
    public function release($delay = 0);

    /**
     * Determine if the job has been deleted or released.
     *
     * @return bool
     */
    public function isDeletedOrReleased();

    /**
     * Get the number of times the job has been attempted.
     *
     * @return int
     */
    public function attempts();

    /**
     * Get the name of the queued job class.
     *
     * @return string
     */
    public function getName();

    /**
     * Call the failed method on the job instance.
     *
     * @return void
     */
    public function failed();

    /**
     * Get the name of the queue the job belongs to.
     *
     * @return string
     */
    public function getQueue();

     /**
      * Get the raw body string for the job.
      *
      * @return string
      */
     public function getRawBody();
}
