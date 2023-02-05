<?php

declare(strict_types=1);

namespace App\Domain\Service\Cart;

use Tests\TestCase;

/**
 * @internal
 *
 * @coversNothing
 */
final class CartItemDtoTest extends TestCase
{
    public function test1(): void
    {
        // 商品参加秒杀活动，使用秒杀价
        // 案例：商品A销售价10元，秒杀价8元，购买3件。包邮。
        // 分析：商品A使用秒杀价，此时订单结算环节的“成交价”应取“秒杀价”，即成交价为8元。无其他优惠项，因此结算价也是8元。订单总价=8x3+0=24元。
        // 结果：商品A成交价8元，商品总价24元，订单总价24元，商品A结算价8元。
        $cartItemDto = new CartItemDto([
            'inventory_id' => 999,
            'number' => 3,
            'price' => new CartItemPriceDto([
                'sales_price' => 10,
                'promotion_price' => 8,
            ]),
            'product' => new CartItemProductDto([
                'product_id' => 3,
                'product_name' => '商品A',
            ]),
            'promotion' => new CartItemPromotionDto([
                'promotion_id' => 5,
                'promotion_name' => '秒杀活动',
            ]),
        ]);

        $cartItemDto->price->updatePrice();
        static::assertSame($cartItemDto->getPurchaseTotalPrice(), 24.0);
    }

    public function test2(): void
    {
        // 商品参加满减活动
        // 案例：商品A销售价20元，购买2件；商品B销售价30元，购买2件；商品C销售价50元，购买1件。其中只有商品A和商品B参加“满49减20”活动，商品C不参加。运费10元。
        // - 分析：首先，由于满减活动属于“以优惠项方式减免金额”，因此不存在活动价，所有的“成交价”都取“销售价”。
        // 判断是否达到“满减条件”，则需要计算订单中参与活动的商品的“部分商品总价”，已知商品A和商品B参与该满减活动，得部分商品总价=20x2+30x2=100元，该金额大于满减门槛，因此可使用“满减”优惠。
        $cartItemDto = new CartItemDto([
            'inventory_id' => 1,
            'number' => 2,
            'price' => new CartItemPriceDto([
                'sales_price' => 20,
            ]),
            'product' => new CartItemProductDto([
                'product_id' => 3,
                'product_name' => '商品A',
            ]),
            'promotion' => new CartItemPromotionDto([
                'promotion_id' => 5,
                'promotion_name' => '满减活动',
            ]),
        ]);

        $cartItemDto->price->updatePrice();

        $cartItemDto2 = new CartItemDto([
            'inventory_id' => 3,
            'number' => 2,
            'price' => new CartItemPriceDto([
                'sales_price' => 30,
            ]),
            'product' => new CartItemProductDto([
                'product_id' => 4,
                'product_name' => '商品B',
            ]),
            'promotion' => new CartItemPromotionDto([
                'promotion_id' => 5,
                'promotion_name' => '满减活动',
            ]),
        ]);

        $cartItemDto2->price->updatePrice();

        $cartItemDto3 = new CartItemDto([
            'inventory_id' => 5,
            'number' => 1,
            'price' => new CartItemPriceDto([
                'sales_price' => 50,
            ]),
            'product' => new CartItemProductDto([
                'product_id' => 5,
                'product_name' => '商品C',
            ]),
        ]);

        $cartItemDto3->price->updatePrice();

        // 参与满减金额的部分商品总金额
        $abTotalPrice = $cartItemDto->getPurchaseTotalPrice() + $cartItemDto2->getPurchaseTotalPrice();
        static::assertSame($abTotalPrice, 100.0);

        // 总商品金额
        $allTotalPrice = $cartItemDto->getPurchaseTotalPrice() + $cartItemDto2->getPurchaseTotalPrice() + $cartItemDto3->getPurchaseTotalPrice();
        static::assertSame($allTotalPrice, 150.0);

        // 满减优惠：-20元
        $manJian = 20;

        // 运费
        $yunfei = 10;

        // 订单金额
        $ordersTotalPrice = $allTotalPrice - $manJian + $yunfei;
        static::assertSame($ordersTotalPrice, 140.0);

        // 因此订单总价=150-20+10=140元，买家应该为这一笔订单支付140元。下面计算商品结算价，满减优惠的20元需要分摊到对应商品上，运费不参与分摊。
        $aManjian = 20 * ($cartItemDto->getPurchaseTotalPrice() / $abTotalPrice);
        $bManjian = 20 * ($cartItemDto2->getPurchaseTotalPrice() / $abTotalPrice);
        static::assertSame($aManjian, 8.0);
        static::assertSame($bManjian, 12.0);

        // 满减分摊单价
        $aManjianPrice = $aManjian / $cartItemDto->number;
        $bManjianPrice = $bManjian / $cartItemDto2->number;
        static::assertSame($aManjianPrice, 4.0);
        static::assertSame($bManjianPrice, 6.0);

        // 更新结算价
        $cartItemDto->price->updateFavorablePrice($aManjianPrice);
        $cartItemDto2->price->updateFavorablePrice($bManjianPrice);

        // 订单金额
        // 订单总价=Σ成交价x购买数量 - 优惠项减免金额 + 运费 = 140元
        // Σ结算价x购买数量 + 运费 = 16x2+24x2+50x1+10=140元
        $ordersTotalPrice = $cartItemDto->getSettlementTotalPrice() + $cartItemDto2->getSettlementTotalPrice() + $cartItemDto3->getSettlementTotalPrice() + $yunfei;
        static::assertSame($ordersTotalPrice, 140.0);
    }
}
