<?php

declare(strict_types=1);

namespace App\Domain\Service\Cart;

use Tests\TestCase;

/**
 * @internal
 *
 * @coversNothing
 */
final class CartPriceDtoTest extends TestCase
{
    public function test1(): void
    {
        $foo = new CartPriceDto();
        $foo->calculateFinalTotalPrice();
        $json = <<<'eot'
            {
                "final_total_price": 0,
                "purchase_total_price": 0,
                "should_special": false,
                "special_total_price": 0,
                "special_favorable_total_price": 0,
                "coupon_favorable_total_price": 0,
                "rebate_favorable_total_price": 0,
                "integral_favorable_total_price": 0,
                "freight": 0,
                "invoice_type": 0,
                "invoice_price": 0,
                "invoice_tax": 0,
                "invoice_tax_all": [
                    0,
                    3,
                    5
                ]
            }
            eot;
        static::assertSame($json, $this->varJson($foo->toArray()));
    }

    public function test2(): void
    {
        $foo = new CartPriceDto([
            'purchase_total_price' => 5,
        ]);
        $foo->calculateFinalTotalPrice();
        $json = <<<'eot'
            {
                "final_total_price": 5,
                "purchase_total_price": 5,
                "should_special": false,
                "special_total_price": 0,
                "special_favorable_total_price": 0,
                "coupon_favorable_total_price": 0,
                "rebate_favorable_total_price": 0,
                "integral_favorable_total_price": 0,
                "freight": 0,
                "invoice_type": 0,
                "invoice_price": 0,
                "invoice_tax": 0,
                "invoice_tax_all": [
                    0,
                    3,
                    5
                ]
            }
            eot;
        static::assertSame($json, $this->varJson($foo->toArray()));
    }

    public function test3(): void
    {
        $foo = new CartPriceDto([
            'purchase_total_price' => 5,
            'freight' => 1,
        ]);
        $foo->calculateFinalTotalPrice();
        $json = <<<'eot'
            {
                "final_total_price": 6,
                "purchase_total_price": 5,
                "should_special": false,
                "special_total_price": 0,
                "special_favorable_total_price": 0,
                "coupon_favorable_total_price": 0,
                "rebate_favorable_total_price": 0,
                "integral_favorable_total_price": 0,
                "freight": 1,
                "invoice_type": 0,
                "invoice_price": 0,
                "invoice_tax": 0,
                "invoice_tax_all": [
                    0,
                    3,
                    5
                ]
            }
            eot;
        static::assertSame($json, $this->varJson($foo->toArray()));
    }

    public function test4(): void
    {
        $foo = new CartPriceDto([
            'purchase_total_price' => 5,
            'freight' => 1,
            'invoice_type' => 1,
            'invoice_tax' => 3,
        ]);
        $foo->calculateFinalTotalPrice();
        $json = <<<'eot'
            {
                "final_total_price": 6.15,
                "purchase_total_price": 5,
                "should_special": false,
                "special_total_price": 0,
                "special_favorable_total_price": 0,
                "coupon_favorable_total_price": 0,
                "rebate_favorable_total_price": 0,
                "integral_favorable_total_price": 0,
                "freight": 1,
                "invoice_type": 1,
                "invoice_price": 0.15,
                "invoice_tax": 3,
                "invoice_tax_all": [
                    0,
                    3,
                    5
                ]
            }
            eot;
        static::assertSame($json, $this->varJson($foo->toArray()));
    }

    public function test5(): void
    {
        $foo = new CartPriceDto([
            'purchase_total_price' => 5,
            'freight' => 1,
            'invoice_type' => 1,
            'invoice_tax' => 3,
            'should_special' => true,
            'special_total_price' => 2,
        ]);
        $foo->calculateFinalTotalPrice();
        $json = <<<'eot'
            {
                "final_total_price": 3,
                "purchase_total_price": 5,
                "should_special": true,
                "special_total_price": 2,
                "special_favorable_total_price": 3.15,
                "coupon_favorable_total_price": 0,
                "rebate_favorable_total_price": 0,
                "integral_favorable_total_price": 0,
                "freight": 1,
                "invoice_type": 1,
                "invoice_price": 0.15,
                "invoice_tax": 3,
                "invoice_tax_all": [
                    0,
                    3,
                    5
                ]
            }
            eot;
        static::assertSame($json, $this->varJson($foo->toArray()));
    }

    public function test7(): void
    {
        $foo = new CartPriceDto([
            'purchase_total_price' => 7,
            'coupon_favorable_total_price' => 1,
            'rebate_favorable_total_price' => 1,
            'integral_favorable_total_price' => 1,
        ]);
        $foo->calculateFinalTotalPrice();
        $json = <<<'eot'
            {
                "final_total_price": 4,
                "purchase_total_price": 7,
                "should_special": false,
                "special_total_price": 0,
                "special_favorable_total_price": 0,
                "coupon_favorable_total_price": 1,
                "rebate_favorable_total_price": 1,
                "integral_favorable_total_price": 1,
                "freight": 0,
                "invoice_type": 0,
                "invoice_price": 0,
                "invoice_tax": 0,
                "invoice_tax_all": [
                    0,
                    3,
                    5
                ]
            }
            eot;
        static::assertSame($json, $this->varJson($foo->toArray()));
    }

    public function test8(): void
    {
        $foo = new CartPriceDto([
            'purchase_total_price' => 7,
            'coupon_favorable_total_price' => 1,
            'rebate_favorable_total_price' => 1,
            'integral_favorable_total_price' => 1,
            'freight' => 1,
            'invoice_type' => 1,
            'invoice_tax' => 3,
        ]);
        $foo->calculateFinalTotalPrice();
        $json = <<<'eot'
            {
                "final_total_price": 5.21,
                "purchase_total_price": 7,
                "should_special": false,
                "special_total_price": 0,
                "special_favorable_total_price": 0,
                "coupon_favorable_total_price": 1,
                "rebate_favorable_total_price": 1,
                "integral_favorable_total_price": 1,
                "freight": 1,
                "invoice_type": 1,
                "invoice_price": 0.21,
                "invoice_tax": 3,
                "invoice_tax_all": [
                    0,
                    3,
                    5
                ]
            }
            eot;
        static::assertSame($json, $this->varJson($foo->toArray()));
    }
}
