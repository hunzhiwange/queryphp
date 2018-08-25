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

namespace App\App\Controller\Petstore\Model;

/**
 * @SWG\Definition(required={"name", "photoUrls"}, type="object", @SWG\Xml(name="Pet"))
 */
class Pet
{
    /**
     * @SWG\Property(format="int64")
     *
     * @var int
     */
    public $id;

    /**
     * @SWG\Property(example="doggie")
     *
     * @var string
     */
    public $name;

    /**
     * @var Category
     * @SWG\Property()
     */
    public $category;

    /**
     * @var string[]
     * @SWG\Property(@SWG\Xml(name="photoUrl", wrapped=true))
     */
    public $photoUrls;

    /**
     * @var Tag[]
     * @SWG\Property(@SWG\Xml(name="tag", wrapped=true))
     */
    public $tags;

    /**
     * pet status in the store.
     *
     * @var string
     * @SWG\Property(enum={"available", "pending", "sold"})
     */
    public $status;
}
