<?php

declare(strict_types=1);

namespace App\Domain\Service\Cart;

/**
 * 根据占比计算价格分摊.
 */
class CalculatePriceProportionHelper
{
    public static function handle(array &$prices, float $favorableTotalPrice, int $remainAccurate = 2): array
    {
        // 原始数据必须保持相同保留位数
        $favorableTotalPrice = bcadd_compatibility($favorableTotalPrice, 0, $remainAccurate);
        $allTotalPrice = 0;
        foreach ($prices as $v) {
            $v = bcadd_compatibility($v, 0, $remainAccurate);
            $allTotalPrice = bcadd_compatibility($allTotalPrice, $v, $remainAccurate);
        }

        // 优惠金额比本金还大，最大支持本金
        if (1 === bccomp_compatibility($favorableTotalPrice, $allTotalPrice, $remainAccurate)) {
            $favorableTotalPrice = $allTotalPrice;
        }

        $result = [];
        foreach ($prices as $k => $v) {
            // 原始数据必须保持相同保留位数
            $prices[$k] = $v = bcadd_compatibility($prices[$k], 0, $remainAccurate);
            // 先乘再除避免除不尽
            $result[$k] = bcdiv_compatibility(bcmul_compatibility($v, $favorableTotalPrice), $allTotalPrice);
            $prices[$k] = bcsub_compatibility($v, $result[$k], $remainAccurate);
        }

        // 补差价
        // 差值依次从第一个开始补，直到消耗完毕
        $splitTotalNumber = 0;
        foreach ($result as $v) {
            $splitTotalNumber = bcadd_compatibility($splitTotalNumber, $v, $remainAccurate);
        }
        if (-1 === bccomp_compatibility($splitTotalNumber, $favorableTotalPrice, $remainAccurate)) {
            $subTotal = bcsub_compatibility($favorableTotalPrice, $splitTotalNumber, $remainAccurate);
            foreach ($result as $k => $v) {
                if (1 === bccomp_compatibility($prices[$k], 0, $remainAccurate)) {
                    $subPrice = 1 === bccomp_compatibility($prices[$k], $subTotal, $remainAccurate) ? $subTotal : $prices[$k];
                    $subTotal = bcsub_compatibility($subTotal, $subPrice, $remainAccurate);
                    $result[$k] = bcadd_compatibility($result[$k], $subPrice, $remainAccurate);
                    $prices[$k] = bcsub_compatibility($prices[$k], $subPrice, $remainAccurate);
                }
                if (0 === bccomp_compatibility($subTotal, 0, $remainAccurate)) {
                    break;
                }
            }
        }

        return $result;
    }
}
