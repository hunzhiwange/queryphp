<?php
// [$QueryPHP] A PHP Framework Since 2010.10.03. <Query Yet Simple>
// ©2010-2017 http://queryphp.com All rights reserved.
namespace queryyetsimple\queue;

<<<queryphp
##########################################################
#   ____                          ______  _   _ ______   #
#  /     \       ___  _ __  _   _ | ___ \| | | || ___ \  #
# |   (  ||(_)| / _ \| '__|| | | || |_/ /| |_| || |_/ /  #
#  \____/ |___||  __/| |   | |_| ||  __/ |  _  ||  __/   #
#       \__   | \___ |_|    \__  || |    | | | || |      #
#     Query Yet Simple      __/  |\_|    |_| |_|\_|      #
#                          |___ /  Since 2010.10.03      #
##########################################################
queryphp;

use PHPQueue\Job as PHPQueueJob;

/**
 * 基类 job
 *
 * @author Xiangmin Liu<635750556@qq.com>
 * @package $$
 * @since 2017.05.12
 * @version 1.0
 */
abstract class job extends PHPQueueJob {
    
    /**
     * 任务实例
     *
     * @var \queryyetsimple\queue\interfaces\job
     */
    protected $objInstance;

        /**
         * 任务所属的消息队列
         *
         * @var string
         */
        protected $strQueue;
    
        /**
         * 标识是否删除
         *
         * @var bool
         */
        protected $booDeleted = false;
    
        /**
         * 是否重新发布
         *
         * @var boolean
         */
        protected $booReleased = false;
        
        /**
         * 构造函数
         * 
         * @param array $arrData
         * @param string $strJobId
         * @param string $strQueue
         * @return void
         */
        public function __construct($arrData=null, $strJobId=null,$strQueue='default')
        {
            parent::__construct($arrData,$strJobId);
            $this->strQueue = $strQueue;
        }

        /**
         * 执行任务
         *
         * @return void
         */
        abstract public function handle();
    
        /**
         * 从队列中删除任务
         *
         * @return void
        */
        public function delete()
        {
            $this->booDeleted = true;
        }
    
        /**
         * 任务是否已经删除
         *
         * @return bool
         */
        public function isDeleted()
        {
            return $this->booDeleted;
        }
    
        /**
         * 重新发布任务
         *
         * @return void
         */
        public function release()
        {
            $this->booReleased = true;
        }
    
        /**
         * 任务是否已经发布
         *
         * @return bool
         */
        public function isReleased()
        {
            return $this->booReleased;
        }
    
        /**
         * Resolve and fire the job handler method.
         *
         * @param  array  $payload
         * @return void
        */
        protected function resolveAndFire(array $payload)
        {
            list($class, $method) = $this->parseJob($payload['job']);
    
            $this->instance = $this->resolve($class);
    
            $this->instance->{$method}($this, $this->resolveQueueableEntities($payload['data']));
        }
    
        /**
         * Parse the job declaration into class and method.
         *
         * @param  string  $job
         * @return array
         */
        protected function parseJob($job)
        {
            $segments = explode('@', $job);
    
            return count($segments) > 1 ? $segments : [$segments[0], 'fire'];
        }
    
        /**
         * Resolve the given job handler.
         *
         * @param  string  $class
         * @return mixed
         */
        protected function resolve($class)
        {
            return $this->container->make($class);
        }
    
        /**
         * Resolve all of the queueable entities in the given payload.
         *
         * @param  mixed  $data
         * @return mixed
         */
        protected function resolveQueueableEntities($data)
        {
            if (is_string($data)) {
                return $this->resolveQueueableEntity($data);
            }
    
            if (is_array($data)) {
                $data = array_map(function ($d) {
                    if (is_array($d)) {
                        return $this->resolveQueueableEntities($d);
                    }
    
                    return $this->resolveQueueableEntity($d);
                }, $data);
            }
    
            return $data;
        }
    
        /**
         * Resolve a single queueable entity from the resolver.
         *
         * @param  mixed  $value
         * @return \Illuminate\Contracts\Queue\QueueableEntity
         */
        protected function resolveQueueableEntity($value)
        {
            if (is_string($value) && Str::startsWith($value, '::entity::')) {
                list($marker, $type, $id) = explode('|', $value, 3);
    
                return $this->getEntityResolver()->resolve($type, $id);
            }
    
            return $value;
        }
    
        /**
         * Call the failed method on the job instance.
         *
         * @return void
         */
        public function failed()
        {
            $payload = json_decode($this->getRawBody(), true);
    
            list($class, $method) = $this->parseJob($payload['job']);
    
            $this->instance = $this->resolve($class);
    
            if (method_exists($this->instance, 'failed')) {
                $this->instance->failed($this->resolveQueueableEntities($payload['data']));
            }
        }
    
        /**
         * Get an entity resolver instance.
         *
         * @return \Illuminate\Contracts\Queue\EntityResolver
         */
        protected function getEntityResolver()
        {
            return $this->container->make('Illuminate\Contracts\Queue\EntityResolver');
        }
    
        /**
         * Calculate the number of seconds with the given delay.
         *
         * @param  \DateTime|int  $delay
         * @return int
         */
        protected function getSeconds($delay)
        {
            if ($delay instanceof DateTime) {
                return max(0, $delay->getTimestamp() - $this->getTime());
            }
    
            return (int) $delay;
        }
    
        /**
         * Get the current system time.
         *
         * @return int
         */
        protected function getTime()
        {
            return time();
        }
    
        /**
         * Get the name of the queued job class.
         *
         * @return string
         */
        public function getName()
        {
            return json_decode($this->getRawBody(), true)['job'];
        }
    
        /**
         * Get the name of the queue the job belongs to.
         *
         * @return string
         */
        public function getQueue()
        {
            return $this->queue;
        }
   
    
}
