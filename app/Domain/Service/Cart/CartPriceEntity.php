<?php

declare(strict_types=1);

namespace App\Domain\Service\Cart;

use Leevel\Support\Dto;

/**
 * 购物车计算.
 */
class CartPriceEntity extends Dto
{
    /**
     * 订单结算金额.
     */
    public float $finalTotalPrice = 0;

    /**
     * 订单商品金额.
     */
    public float $purchaseTotalPrice = 0;

    /**
     * 是否启用特批价.
     */
    public bool $shouldSpecial = false;

    /**
     * 特批价金额.
     */
    public float $specialTotalPrice = 0;

    /**
     * 特批优惠.
     */
    public float $specialFavorableTotalPrice = 0;

    /**
     * 优惠券抵扣.
     */
    public float $couponFavorableTotalPrice = 0;

    /**
     * 返利抵扣.
     */
    public float $rebateFavorableTotalPrice = 0;

    /**
     * 积分抵扣.
     */
    public float $integralFavorableTotalPrice = 0;

    /**
     * 运费.
     */
    public float $freight = 0;

    /**
     * 开票.
     *
     * - 0:未开启
     * - 1:普通发票
     * - 2:增值发票
     */
    public int $invoiceType = 0;

    /**
     * 税费.
     */
    public float $invoicePrice = 0;

    /**
     * 税点.
     */
    public int $invoiceTax = 0;

    public array $invoiceTaxAll = [
        0 => 0,
        1 => 3,
        2 => 5,
    ];

    /**
     * 计算订单结算价.
     */
    public function calculateFinalTotalPrice(): float
    {
        if (-1 === bccomp_compatibility($this->purchaseTotalPrice, 0, 4)) {
            $this->purchaseTotalPrice = 0;
        }

        // 订单商品金额
        // 订单商品金额部分优惠后的金额（满立惠、特价、团购、套餐）
        $finalTotalPrice = $this->purchaseTotalPrice;

        // 减去优惠
        // 优惠券
        $finalTotalPrice = bcsub_compatibility($finalTotalPrice, $this->couponFavorableTotalPrice, 4);
        // 返利
        $finalTotalPrice = bcsub_compatibility($finalTotalPrice, $this->rebateFavorableTotalPrice, 4);
        // 积分
        $finalTotalPrice = bcsub_compatibility($finalTotalPrice, $this->integralFavorableTotalPrice, 4);

        // 扣除优惠后结算金额最低为 0，避免扣成负数参与后续逻辑错误
        if (-1 === bccomp_compatibility($finalTotalPrice, 0, 4)) {
            $finalTotalPrice = 0;
        }

        // 加上税费
        if ($this->invoiceTax > 100) {
            $this->invoiceTax = 100;
        }
        if ($this->invoiceTax < 0) {
            $this->invoiceTax = 0;
        }

        if (isset($this->invoiceTaxAll[$this->invoiceType])) {
            $this->invoicePrice = bcmul_compatibility($this->purchaseTotalPrice, $this->invoiceTax, 4);
            $this->invoicePrice = bcdiv_compatibility($this->invoicePrice, 100, 4);
            $finalTotalPrice = bcadd_compatibility($finalTotalPrice, $this->invoicePrice, 4);
        } else {
            $this->invoicePrice = 0;
            $this->invoiceType = 0;
        }

        // 特批可以特批除了运费之外的所有价
        if ($this->shouldSpecial) {
            // 特批价不能大于此金额(订单商品金额 - 优惠券抵扣金额 - 返利抵扣 - 积分抵扣 + 税费)
            if (1 === bccomp_compatibility($this->specialTotalPrice, $finalTotalPrice, 4)) {
                throw new \Exception('特批价不能大于（订单商品金额 - 优惠券抵扣金额 - 返利抵扣 - 积分抵扣 + 税费）！');
            }

            $this->specialFavorableTotalPrice = bcsub_compatibility($finalTotalPrice, $this->specialTotalPrice, 4);
            $finalTotalPrice = $this->specialTotalPrice;
        } else {
            $this->specialTotalPrice = 0;
            $this->specialFavorableTotalPrice = 0;
        }

        // 加上运费
        $this->finalTotalPrice = bcadd_compatibility($finalTotalPrice, $this->freight, 4);

        // 结算金额最低为 0
        if (-1 === bccomp_compatibility($this->finalTotalPrice, 0, 4)) {
            $this->finalTotalPrice = 0;
        }

        // 格式化入库数据
        $this->formatData();

        return $this->finalTotalPrice;
    }

    private function formatData(): void
    {
        $this->finalTotalPrice = bcadd_compatibility($this->finalTotalPrice, 0);
        $this->specialTotalPrice = bcadd_compatibility($this->specialTotalPrice, 0);
        $this->invoicePrice = bcadd_compatibility($this->invoicePrice, 0);
    }
}
