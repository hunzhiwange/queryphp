<?php

declare(strict_types=1);

namespace App\Infra\Service\ApiQL;

use Tests\TestCase;

final class ApiQlBatchTest extends TestCase
{
    /**
     * 测试正常情况.
     */
    public function testApiQlBatch(): void
    {
        $apis = [
            'product' => 'product:product/list-only',
            'warehouse' => 'stock:warehouse/list-only',
        ]; // 输入有效的API数组
        $params = [
            'product' => [
                'column' => 'sku_no,sku_title,title,small_unit',
                'sku_no' => [
                    'in' => '1130000117117,1130000117116',
                ],
            ],
            'warehouse' => [
                'column' => 'warehouse_no,warehouse_name',
                'warehouse_no' => [
                    'in' => 'CD03,CD02,CD01',
                ],
            ],
        ]; // 输入有效的参数数组
        $withoutDebug = true; // 输入true或false

        $result = \api_ql_batch($apis, $params, $withoutDebug);

        self::assertIsArray($result);
        // 进一步根据实际情况添加断言
        self::assertTrue(isset($result['content']));
    }

    /**
     * 测试开启调试功能.
     */
    public function testApiQlBatchWithDebug(): void
    {
        $apis = [
            'product' => 'product:product/list-only',
            'warehouse' => 'stock:warehouse/list-only',
        ]; // 输入有效的API数组
        $params = [
            'product' => [
                'column' => 'sku_no,sku_title,title,small_unit',
                'sku_no' => [
                    'in' => '1130000117117,1130000117116',
                ],
            ],
            'warehouse' => [
                'column' => 'warehouse_no,warehouse_name',
                'warehouse_no' => [
                    'in' => 'CD03,CD02,CD01',
                ],
            ],
        ]; // 输入有效的参数数组
        $withoutDebug = false; // 输入true或false

        $result = \api_ql_batch($apis, $params, $withoutDebug);

        self::assertIsArray($result);
        // 进一步根据实际情况添加断言
        self::assertTrue(isset($result['content']));
        self::assertStringContainsString('Token name was not set', $result['content']);
    }
}
