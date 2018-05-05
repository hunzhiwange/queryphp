<?php declare(strict_types=1);
// (c) 2018 http://your.domain.com All rights reserved.
namespace App\App\Controller\Petstore;

/**
 * @SWG\Definition(type="object")
 */
class ApiResponse
{
    /**
     * @SWG\Property(format="int32")
     * @var int
     */
    public $code;

    /**
     * @SWG\Property
     * @var string
     */
    public $type;

    /**
     * @SWG\Property
     * @var string
     */
    public $message;
}