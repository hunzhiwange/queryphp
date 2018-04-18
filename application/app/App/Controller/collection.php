<?php
// (c) 2018 http://your.domain.com All rights reserved.
namespace home\app\controller;

use Exception;
use Closure;
use ReflectionFunction;
use BadMethodCallException;
use Queryyetsimple\Mvc\Controller;
use Queryyetsimple\Support\Type;

/**
 * collection 控制器
 *
 * @author Name Your <your@mail.com>
 * @package $$
 * @since 2017.10.12
 * @version 1.0
 */
class collection extends Controller
{

    /**
     * 默认方法
     *
     * @return void
     */
    public function index()
    {
        \Queryyetsimple\Collection\Collection::macro('hello',function($h) {
            ddd($h);
            ddd($this->all());
        });

 
        $c = new \Queryyetsimple\Collection\Collection([
            'name' => ['world'],
            'title' => ['描述信息'],
            'description' => ['描述信息']
        ],['array']); 


        $c->hello(5);

    }
}
