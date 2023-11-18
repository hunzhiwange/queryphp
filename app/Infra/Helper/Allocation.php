<?php

declare(strict_types=1);

namespace App\Infra\Helper;

/**
 * 分摊.
 */
class Allocation
{
    public static function handle(array &$proportionData, float $totalQuantity, int $scale = 2): array
    {
        $totalProportionQuantity = 0;
        foreach ($proportionData as $v) {
            $totalProportionQuantity = bc_add($totalProportionQuantity, $v);
        }

        if (1 === bc_comp($totalQuantity, $totalProportionQuantity)) {
            $totalQuantity = $totalProportionQuantity;
        }

        $result = [];
        foreach ($proportionData as $k => $v) {
            // 先乘再除避免除不尽，这里保留分摊的小数位数
            $result[$k] = bc_div(bc_mul($totalQuantity, $proportionData[$k]), $totalProportionQuantity, $scale);
            $proportionData[$k] = bc_sub($proportionData[$k], $result[$k]);
        }

        // 补差值
        // 差值依次从第一个开始补，直到消耗完毕
        $splitTotalQuantity = 0;
        foreach ($result as $v) {
            $splitTotalQuantity = bc_add($splitTotalQuantity, $v);
        }

        if (-1 !== bc_comp($splitTotalQuantity, $totalQuantity, $scale)) {
            return $result;
        }

        $subTotal = bc_sub($totalQuantity, $splitTotalQuantity, $scale);

        foreach ($result as $k => $v) {
            $proportionItem = bc_add($proportionData[$k], 0, $scale);
            if (1 === bc_comp($proportionItem, 0, $scale)) {
                $subQuantity = 1 === bc_comp($proportionItem, $subTotal, $scale) ? $subTotal : $proportionItem;
                $subTotal = bc_sub($subTotal, $subQuantity);
                $result[$k] = bc_add($result[$k], $subQuantity);
                $proportionData[$k] = bc_sub($proportionData[$k], $subQuantity);
            }

            if (0 === bc_comp($subTotal, 0, $scale)) {
                break;
            }
        }

        return $result;
    }
}
