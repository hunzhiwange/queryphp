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

namespace App\App\Controller\Petstore;

/**
 * @SWG\Definition(type="object")
 */
class ApiResponse
{
    /**
     * @SWG\Property(format="int32")
     *
     * @var int
     */
    public $code;

    /**
     * @SWG\Property
     *
     * @var string
     */
    public $type;

    /**
     * @SWG\Property
     *
     * @var string
     */
    public $message;
}
