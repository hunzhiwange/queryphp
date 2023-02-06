<?php

declare(strict_types=1);

namespace App\Domain\Service\Cart;

/**
 * 根据占比计算数量.
 */
class CalculatePriceProportionHelper
{
    public static function handle(array &$data, float $totalNumber, int $remainAccurate = 2): array
    {
        // 原始数据必须保持相同保留位数
        $totalNumber = bcadd_compatibility($totalNumber, 0, $remainAccurate);
        $totalDataNumber = 0;
        foreach ($data as $v) {
            $v = bcadd_compatibility($v, 0, $remainAccurate);
            $totalDataNumber = bcadd_compatibility($totalDataNumber, $v, $remainAccurate);
        }

        // 优惠金额比本金还大，最大支持本金
        if (1 === bccomp_compatibility($totalNumber, $totalDataNumber, $remainAccurate)) {
            $totalNumber = $totalDataNumber;
        }

        $result = [];
        foreach ($data as $k => $v) {
            // 原始数据必须保持相同保留位数
            $data[$k] = $v = bcadd_compatibility($data[$k], 0, $remainAccurate);
            // 占比留长一点精确些
            $result[$k] = bcmul_compatibility(bcdiv_compatibility($v, $totalDataNumber, 12), $totalNumber, $remainAccurate);
            $data[$k] = bcsub_compatibility($v, $result[$k], $remainAccurate);
        }

        // 补差价
        // 差值依次从第一个开始补，直到消耗完毕
        $splitTotalNumber = 0;
        foreach ($result as $v) {
            $splitTotalNumber = bcadd_compatibility($splitTotalNumber, $v, $remainAccurate);
        }
        if (-1 === bccomp_compatibility($splitTotalNumber, $totalNumber, $remainAccurate)) {
            $subTotal = bcsub_compatibility($totalNumber, $splitTotalNumber, $remainAccurate);
            foreach ($result as $k => $v) {
                if (1 === bccomp_compatibility($data[$k], 0, $remainAccurate)) {
                    $subPrice = 1 === bccomp_compatibility($data[$k], $subTotal, $remainAccurate) ? $subTotal : $data[$k];
                    $subTotal = bcsub_compatibility($subTotal, $subPrice, $remainAccurate);
                    $result[$k] = bcadd_compatibility($result[$k], $subPrice, $remainAccurate);
                    $data[$k] = bcsub_compatibility($data[$k], $subPrice, $remainAccurate);
                }
                if (0 === bccomp_compatibility($subTotal, 0, $remainAccurate)) {
                    break;
                }
            }
        }

        return $result;
    }
}
