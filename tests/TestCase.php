<?php

declare(strict_types=1);

/*
 * This file is part of the forcodepoem package.
 *
 * The PHP Application Created By Code Poem. <Query Yet Simple>
 * (c) 2018-2099 http://forcodepoem.com All rights reserved.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tests;

use PHPUnit\Framework\TestCase as TestCases;
use ReflectionClass;
use ReflectionMethod;
use ReflectionProperty;

/**
 * phpunit 基础测试类.
 *
 * @author Xiangmin Liu <635750556@qq.com>
 *
 * @since 2017.05.09
 *
 * @version 1.0
 */
abstract class TestCase extends TestCases
{
    protected function invokeTestMethod($classObj, string $method, array $args = [])
    {
        $method = $this->parseTestMethod($classObj, $method);

        if ($args) {
            return $method->invokeArgs($classObj, $args);
        }

        return $method->invoke($classObj);
    }

    protected function invokeTestStaticMethod($classOrObject, string $method, array $args = [])
    {
        $method = $this->parseTestMethod($classOrObject, $method);

        if ($args) {
            return $method->invokeArgs(null, $args);
        }

        return $method->invoke(null);
    }

    protected function getTestProperty($classOrObject, string $prop)
    {
        return $this->parseTestProperty($classOrObject, $prop)->
        getValue($classOrObject);
    }

    protected function setTestProperty($classOrObject, string $prop, $value)
    {
        $this->parseTestProperty($classOrObject, $prop)->

        setValue($value);
    }

    protected function parseTestProperty($classOrObject, string $prop): ReflectionProperty
    {
        $reflected = new ReflectionClass($classOrObject);
        $property = $reflected->getProperty($prop);
        $property->setAccessible(true);

        return $property;
    }

    protected function parseTestMethod($classOrObject, string $method): ReflectionMethod
    {
        $method = new ReflectionMethod($classOrObject, $method);
        $method->setAccessible(true);

        return $method;
    }

    protected function varExport(array $data)
    {
        file_put_contents(
            // dirname(__DIR__).'/logs/'.static::class.'.log',
            dirname(__DIR__).'/logs/trace.log',
            var_export($data, true)
        );

        return var_export($data, true);
    }
}
