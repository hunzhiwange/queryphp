<?php

declare(strict_types=1);

namespace Demo;

/**
 * @OA\Schema(
 *     type="object",
 *     description="Api response",
 *     title="Api response"
 * )
 */
class ApiResponse
{
    /**
     * @OA\Property(
     *     description="Code",
     *     title="Code",
     *     format="int32"
     * )
     *
     * @var int
     */
    private $code;

    /**
     * OAS\Property(
     *    description="Type",
     *    title="Type",
     * ).
     *
     * @var string
     */
    private $type;

    /**
     * @OA\Property(
     *     description="Message",
     *     title="Message"
     * )
     *
     * @var string
     */
    private $message;
}
