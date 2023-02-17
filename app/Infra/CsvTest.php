<?php

declare(strict_types=1);

namespace App\Infra;

use Tests\TestCase;

/**
 * @internal
 *
 * @coversNothing
 */
final class CsvTest extends TestCase
{
    public function test1(): void
    {
        $csv = new Csv();
        $result = $csv->read(__DIR__.'/test.csv');

        $json = <<<'eot'
            {
                "header": {
                    "pos_id": "POS门店号",
                    "inventory": "授权库存牌额额度",
                    "replenishment": "授权库存补货额度",
                    "total": "额度合计",
                    "errors_message": "错误原因"
                },
                "notice": {
                    "pos_id": "必须",
                    "inventory": "",
                    "replenishment": "",
                    "total": "",
                    "errors_message": ""
                },
                "data": [
                    {
                        "pos_id": "50090221",
                        "inventory": "3",
                        "replenishment": "4",
                        "total": "7",
                        "errors_message": ""
                    }
                ]
            }
            eot;

        static::assertSame(
            $json,
            $this->varJson(
                $result
            )
        );
    }
}
