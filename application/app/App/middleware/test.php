<?php declare(strict_types=1);
/*
 * This file is part of Your.Product.
 *
 * (c) 2017-2099 http://www.youdomain.com All rights reserved.
 *
 * This project can help people to do things very funny.
 * <To make the world better>
 */
namespace home\application\middleware;

/**
 * test
 *
 * @author your.name <your.email>
 * @package $$
 * @since 2017.06.27
 * @version 1.0
 */
class test
{

    /**
     * 请求
     *
     * @param  mixed|\queryyetsimple\request $mixRequest
     * @return mixed
     */
    public function handle($mixRequest)
    {
        // echo 'sdfsdfsdf';
        $mixRequest->setUrl('333333333');
        return $mixRequest;
    }

    /**
     * 响应
     *
     * @param  mixed|\queryyetsimple\response $mixResponse
     * @return mixed
     */
    public function terminate($mixResponse)
    {
        return $mixResponse;
    }
}
