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
            ]),
            'product' => new CartItemProductDto([
                'product_id' => 3,
                'product_name' => '商品A',
            ]),
        ]);
        $cartItemDto->price->promotions->set(1, new CartItemPromotionDto([
            'promotion_id' => 1,
            'promotion_name' => '秒杀活动',
            'promotion_price' => 8,
        ]));

        $cartItemDto->price->updatePromotionPrice();
        $cartItemDto->price->updatePurchaseAndSettlementPrice();
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
        ]);

        $cartItemDto->price->promotions->set(1, new CartItemPromotionDto([
            'promotion_id' => 1,
            'promotion_name' => '满减活动',
        ]));
        $cartItemDto->price->updatePurchaseAndSettlementPrice();

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
        ]);
        $cartItemDto2->price->promotions->set(1, new CartItemPromotionDto([
            'promotion_id' => 1,
            'promotion_name' => '满减活动',
        ]));
        $cartItemDto2->price->updatePurchaseAndSettlementPrice();

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

        $cartItemDto3->price->updatePurchaseAndSettlementPrice();

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
        $avgPrice = 20 / $abTotalPrice;
        static::assertSame($avgPrice, 0.2);
        $aManjian = 20 * ($cartItemDto->getPurchaseTotalPrice() / $abTotalPrice);
        $bManjian = 20 * ($cartItemDto2->getPurchaseTotalPrice() / $abTotalPrice);
        static::assertSame($aManjian, 8.0);
        static::assertSame($bManjian, 12.0);

        // 满减分摊单价
        $aManjianPrice = $avgPrice * $cartItemDto->price->purchasePrice;
        $bManjianPrice = $avgPrice * $cartItemDto2->price->purchasePrice;
        static::assertSame($aManjianPrice, 4.0);
        static::assertSame($bManjianPrice, 6.0);

        // 更新结算价
        $cartItemDto->price->promotions->get(1)->favorablePrice = $aManjianPrice;
        $cartItemDto->price->updatePromotionPrice();
        $cartItemDto2->price->promotions->get(1)->favorablePrice = $bManjianPrice;
        $cartItemDto2->price->updatePromotionPrice();

        // 订单金额
        // 订单总价=Σ成交价x购买数量 - 优惠项减免金额 + 运费 = 140元
        // Σ结算价x购买数量 + 运费 = 16x2+24x2+50x1+10=140元
        $ordersTotalPrice = $cartItemDto->getSettlementTotalPrice() + $cartItemDto2->getSettlementTotalPrice() + $cartItemDto3->getSettlementTotalPrice() + $yunfei;
        static::assertSame($ordersTotalPrice, 140.0);
    }

    public function test3(): void
    {
        // 包含活动价、满减、优惠券等多种活动。
        // 案例：商品A销售价20元，参与秒杀活动，秒杀价10元，购买2件；商品B销售价30元，购买2件；商品C销售价50元，购买1件。
        // 其中只有商品A和商品B参加“满49减20”活动，商品C不参加。
        // 商品B和商品C可使用1张“满100减11”的优惠券。运费10元。三种营销活动优惠可叠加。
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
        ]);
        $cartItemDto->price->promotions->set(1, new CartItemPromotionDto([
            'promotion_id' => 1,
            'promotion_name' => '秒杀活动',
            'promotion_price' => 10,
        ]));
        $cartItemDto->price->promotions->set(2, new CartItemPromotionDto([
            'promotion_id' => 2,
            'promotion_name' => '满49减20',
        ]));

        $cartItemDto->price->updatePromotionPrice();
        $cartItemDto->price->updatePurchaseAndSettlementPrice();

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
        ]);

        $cartItemDto2->price->promotions->set(2, new CartItemPromotionDto([
            'promotion_id' => 2,
            'promotion_name' => '满49减20',
        ]));
        $cartItemDto2->price->promotions->set(3, new CartItemPromotionDto([
            'promotion_id' => 3,
            'promotion_name' => '满100减11的优惠券',
        ]));

        $cartItemDto2->price->updatePurchaseAndSettlementPrice();

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

        $cartItemDto3->price->updatePurchaseAndSettlementPrice();

        $cartItemDto3->price->promotions->set(3, new CartItemPromotionDto([
            'promotion_id' => 3,
            'promotion_name' => '满100减11的优惠券',
        ]));

        // 成交价格
        static::assertSame($cartItemDto->price->purchasePrice, 10.0);
        static::assertSame($cartItemDto2->price->purchasePrice, 30.0);
        static::assertSame($cartItemDto3->price->purchasePrice, 50.0);

        // 参与满49减20的部分商品总金额
        $abTotalPrice = $cartItemDto->getPurchaseTotalPrice() + $cartItemDto2->getPurchaseTotalPrice();
        static::assertSame($abTotalPrice, 80.0);

        // 参与满100减11的优惠券的部分商品总金额
        $bcTotalPrice = $cartItemDto2->getPurchaseTotalPrice() + $cartItemDto3->getPurchaseTotalPrice();
        static::assertSame($bcTotalPrice, 110.0);

        // 总商品金额
        $allTotalPrice = $cartItemDto->getPurchaseTotalPrice() + $cartItemDto2->getPurchaseTotalPrice() + $cartItemDto3->getPurchaseTotalPrice();
        static::assertSame($allTotalPrice, 130.0);

        // 满减优惠：-20元
        $manJian = 20;

        // 优惠券优惠: 11元
        $youhuijuan = 11;

        // 运费
        $yunfei = 10;

        // 订单金额
        $ordersTotalPrice = $allTotalPrice - $manJian - $youhuijuan + $yunfei;
        static::assertSame($ordersTotalPrice, 109.0);

        // 下面计算各优惠项的分摊金额。满减部分总80元分摊20元，相当于每1元成交价分摊0.25元。优惠券部分总110元分摊11元，相当于每1元成交价分摊0.10元。得出下表：
        $avgPrice = 20 / $abTotalPrice;
        static::assertSame($avgPrice, 0.25);
        $aManjian = 20 * ($cartItemDto->getPurchaseTotalPrice() / $abTotalPrice);
        $bManjian = 20 * ($cartItemDto2->getPurchaseTotalPrice() / $abTotalPrice);
        static::assertSame($aManjian, 5.0);
        static::assertSame($bManjian, 15.0);

        $avgPrice2 = 11 / $bcTotalPrice;
        static::assertSame($avgPrice2, 0.1);
        $bYouhuijuan = 11 * ($cartItemDto2->getPurchaseTotalPrice() / $bcTotalPrice);
        $cYouhuijuan = 11 * ($cartItemDto3->getPurchaseTotalPrice() / $bcTotalPrice);
        static::assertSame($bYouhuijuan, 6.0);
        static::assertSame($cYouhuijuan, 5.0);

        // 满减分摊单价
        $aManjianPrice = $avgPrice * $cartItemDto->price->purchasePrice;
        $bManjianPrice = $avgPrice * $cartItemDto2->price->purchasePrice;
        static::assertSame($aManjianPrice, 2.5);
        static::assertSame($bManjianPrice, 7.5);

        // 优惠券分摊单价
        $bYouhuijuanPrice = $avgPrice2 * $cartItemDto2->price->purchasePrice;
        $cYouhuijuanPrice = $avgPrice2 * $cartItemDto3->price->purchasePrice;
        static::assertSame($bYouhuijuanPrice, 3.0);
        static::assertSame($cYouhuijuanPrice, 5.0);

        // 更新结算价
        $cartItemDto->price->promotions->get(2)->favorablePrice = $aManjianPrice;
        $cartItemDto->price->updatePromotionPrice();
        $cartItemDto2->price->promotions->get(2)->favorablePrice = $bManjianPrice;
        $cartItemDto2->price->promotions->get(3)->favorablePrice = $bYouhuijuanPrice;
        $cartItemDto2->price->updatePromotionPrice();
        $cartItemDto3->price->promotions->get(3)->favorablePrice = $cYouhuijuanPrice;
        $cartItemDto3->price->updatePromotionPrice();

        // 订单金额
        // 订单总价=Σ成交价x购买数量 - 优惠项减免金额 + 运费 = 109
        // Σ结算价x购买数量 + 运费 = 7.5x2+19.5x2+45x1+10=109
        $ordersTotalPrice = $cartItemDto->getSettlementTotalPrice() + $cartItemDto2->getSettlementTotalPrice() + $cartItemDto3->getSettlementTotalPrice() + $yunfei;
        static::assertSame($ordersTotalPrice, 109.0);
    }

    public function test4(): void
    {
        // 上面的讨论从数学的角度是没问题的，但是一旦涉及到“金额”，就会有一个突出问题，那就是金额的小数位只能到分，不允许存在例如“0.1111111”形式的金额，因此我们可能会遇到以下这种情况：
        // 商品A单价5元，购买3件，使用一张“满10减5”的优惠券，实际支付10元，但在计算结算价时，正确的应该是“3.33333.....”，但显然这不是一个正确的金额，因此只能记为“3.33”，但在相加时，总金额为“9.99”元，少于实付金额。
        // 针对以上场景，一般有两种解决方案。方案一是结算价仍记为3.33，仅在退款环节做判断，如果存在全部商品退款的情况，少的0.01元于最后补上。方案二是将商品分成两行记录，一行为购买2件，结算价3.33，第二行为购买1件，结算价3.34。这两种方案都是可行的，需要根据其他环节的业务实施情况选择更容易处理的方案。
        $cartItemDto = new CartItemDto([
            'inventory_id' => 1,
            'number' => 3,
            'price' => new CartItemPriceDto([
                'sales_price' => 5,
            ]),
            'product' => new CartItemProductDto([
                'product_id' => 3,
                'product_name' => '商品A',
            ]),
        ]);

        $cartItemDto->price->promotions->set(1, new CartItemPromotionDto([
            'promotion_id' => 1,
            'promotion_name' => '满10减5',
        ]));
        $cartItemDto->price->updatePurchaseAndSettlementPrice();

        // 参与满减金额的部分商品总金额
        $abTotalPrice = $cartItemDto->getPurchaseTotalPrice();
        static::assertSame($abTotalPrice, 15.0);

        // 总商品金额
        $allTotalPrice = $cartItemDto->getPurchaseTotalPrice();
        static::assertSame($abTotalPrice, 15.0);

        // 满10减5
        $manJian = 5;

        // 运费
        $yunfei = 0;

        // 订单金额
        $ordersTotalPrice = $allTotalPrice - $manJian + $yunfei;
        static::assertSame($ordersTotalPrice, 10.0);

        $avgPrice = 5 / $abTotalPrice;
        $avgPrice = bcmul((string) $avgPrice, '1', 2);
        $avgPrice = (float) $avgPrice;
        static::assertSame($avgPrice, 0.33);

        // 满减分摊单价
        $aManjianPrice = bcmul((string) $avgPrice, (string) $cartItemDto->price->purchasePrice, 2);
        $aManjianPrice = (float) $aManjianPrice;
        static::assertSame($aManjianPrice, 1.65);

        // 更新结算价
        $cartItemDto->price->promotions->get(1)->favorablePrice = $aManjianPrice;
        $cartItemDto->price->updatePromotionPrice();
        static::assertSame($cartItemDto->price->settlementPrice, 3.35);

        // 订单金额
        // 订单总价=Σ成交价x购买数量 - 优惠项减免金额 + 运费 = 10元
        // Σ结算价x购买数量 + 运费 = 3.35*3 =10.05元
        // 优惠价格除不尽造成了结算价偏高了，导致出现了总价偏高的问题
        $ordersTotalPrice = $cartItemDto->getSettlementTotalPrice() + $yunfei;
        static::assertSame($ordersTotalPrice, 10.05);
    }

    public function test5(): void
    {
        // 上面的讨论从数学的角度是没问题的，但是一旦涉及到“金额”，就会有一个突出问题，那就是金额的小数位只能到分，不允许存在例如“0.1111111”形式的金额，因此我们可能会遇到以下这种情况：
        // 商品A单价5元，购买3件，使用一张“满10减5”的优惠券，实际支付10元，但在计算结算价时，正确的应该是“3.33333.....”，但显然这不是一个正确的金额，因此只能记为“3.33”，但在相加时，总金额为“9.99”元，少于实付金额。
        // 针对以上场景，一般有两种解决方案。方案一是结算价仍记为3.33，仅在退款环节做判断，如果存在全部商品退款的情况，少的0.01元于最后补上。方案二是将商品分成两行记录，一行为购买2件，结算价3.33，第二行为购买1件，结算价3.34。这两种方案都是可行的，需要根据其他环节的业务实施情况选择更容易处理的方案。
        $cartItemDto = new CartItemDto([
            'inventory_id' => 1,
            'number' => 3,
            'price' => new CartItemPriceDto([
                'sales_price' => 5,
            ]),
            'product' => new CartItemProductDto([
                'product_id' => 3,
                'product_name' => '商品A',
            ]),
        ]);

        $cartItemDto->price->promotions->set(1, new CartItemPromotionDto([
            'promotion_id' => 1,
            'promotion_name' => '满10减5',
        ]));

        // 参与满减金额的部分商品总金额
        $abTotalPrice = $cartItemDto->getPurchaseTotalPrice();
        static::assertSame($abTotalPrice, 15.0);

        // 总商品金额
        $allTotalPrice = $cartItemDto->getPurchaseTotalPrice();
        static::assertSame($abTotalPrice, 15.0);

        // 满10减5
        $manJian = 5;

        // 运费
        $yunfei = 0;

        // 订单金额
        $ordersTotalPrice = $allTotalPrice - $manJian + $yunfei;
        static::assertSame($ordersTotalPrice, 10.0);

        $cartItemDto->setPromotionFavorableTotalPrice(1, $manJian);
        $cartItemDto->calculatePrice();
        static::assertSame($cartItemDto->price->settlementPrice, 3.33);

        // 订单金额
        // 订单总价=Σ成交价x购买数量 - 优惠项减免金额 + 运费 = 10元
        // Σ结算价x购买数量 + 运费 = 3.35*3 =10.05元
        // 优惠价格除不尽造成了结算价偏高了，导致出现了总价偏高的问题
        $ordersTotalPrice = $cartItemDto->getSettlementTotalPrice() + $yunfei;
        static::assertSame($ordersTotalPrice, 10.0);
        static::assertSame($cartItemDto->getSettlementRemainTotalPrice(), 0.01);
    }

    public function test6(): void
    {
        // 上面的讨论从数学的角度是没问题的，但是一旦涉及到“金额”，就会有一个突出问题，那就是金额的小数位只能到分，不允许存在例如“0.1111111”形式的金额，因此我们可能会遇到以下这种情况：
        // 商品A单价5元，购买3件，使用一张“满10减5”的优惠券，实际支付10元，但在计算结算价时，正确的应该是“3.33333.....”，但显然这不是一个正确的金额，因此只能记为“3.33”，但在相加时，总金额为“9.99”元，少于实付金额。
        // 针对以上场景，一般有两种解决方案。方案一是结算价仍记为3.33，仅在退款环节做判断，如果存在全部商品退款的情况，少的0.01元于最后补上。方案二是将商品分成两行记录，一行为购买2件，结算价3.33，第二行为购买1件，结算价3.34。这两种方案都是可行的，需要根据其他环节的业务实施情况选择更容易处理的方案。
        $cartItemDto = new CartItemDto([
            'inventory_id' => 1,
            'number' => 3,
            'price' => new CartItemPriceDto([
                'sales_price' => 5,
                'promotions' => new CartItemPromotionCollection([1 => new CartItemPromotionDto([
                    'promotion_id' => 1,
                    'promotion_name' => '满10减5',
                ])]),
            ]),
            'product' => new CartItemProductDto([
                'product_id' => 3,
                'product_name' => '商品A',
            ]),
        ]);

        // 参与满减金额的部分商品总金额
        $abTotalPrice = $cartItemDto->getPurchaseTotalPrice();
        static::assertSame($abTotalPrice, 15.0);

        // 总商品金额
        $allTotalPrice = $cartItemDto->getPurchaseTotalPrice();
        static::assertSame($abTotalPrice, 15.0);

        // 满10减5
        $manJian = 5;
        $cartItemDto->setPromotionFavorableTotalPrice(1, $manJian);
        $cartItemDto->calculatePrice();

        // 运费
        $yunFei = 0;

        // 订单金额
        $ordersTotalPrice = bcadd_compatibility(bcsub_compatibility($allTotalPrice, $manJian), $yunFei);
        static::assertSame($ordersTotalPrice, 10.0);

        // 订单金额
        // 订单总价=Σ成交价x购买数量 - 优惠项减免金额 + 运费 = 10元
        // Σ结算价x购买数量 + 运费 = 3.35*3 = 0.99元
        // 优惠价格除不尽造成了结算价偏高了，导致出现了总价偏高的问题
        $ordersTotalPrice2 = $cartItemDto->number * $cartItemDto->price->settlementPrice + $yunFei;
        static::assertSame($ordersTotalPrice2, 9.99);
        static::assertSame($cartItemDto->getSettlementTotalPrice(), 10.0);
        static::assertSame($cartItemDto->getSettlementRemainTotalPrice(), 0.01);
        $remainAmount = bcsub_compatibility($ordersTotalPrice, $ordersTotalPrice2);
        static::assertSame($remainAmount, $cartItemDto->price->settlementRemainTotalPrice);
    }
}
