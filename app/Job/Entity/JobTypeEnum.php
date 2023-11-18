<?php

declare(strict_types=1);

namespace App\Job\Entity;

use Leevel\Support\Enum;
use Leevel\Support\Msg;

enum JobTypeEnum: int
{
    use Enum;

    #[Msg('入库单导入')]
    case DOC_DOC_IN_DASH_STORAGE_IMPORT = 20230427215654;

    #[Msg('采购单导入')]
    case DOC_DOC_PURCHASE_IMPORT = 20230504221032;

    #[Msg('采购退货单导入')]
    case DOC_DOC_PURCHASE_DASH_RETURN_IMPORT = 20230504231827;

    #[Msg('调拨单导入')]
    case DOC_DOC_STOCK_DASH_TRANSFER_IMPORT = 20230504233824;

    #[Msg('盘点单导入')]
    case DOC_DOC_INVENTORY_DASH_CHECK_IMPORT = 20230505000847;

    #[Msg('出库单导入')]
    case DOC_DOC_OUT_DASH_STORAGE_IMPORT = 20230505070352;

    #[Msg('补货单导入')]
    case DOC_DOC_REPLENISHMENT_IMPORT = 20230505071329;

    #[Msg('退货单导入')]
    case DOC_DOC_RETURNS_IMPORT = 20230505075207;

    #[Msg('强配单导入')]
    case DOC_DOC_FORCE_DASH_ORDER_IMPORT = 20230505093453;

    #[Msg('商品品牌导入')]
    case PRODUCT_PRODUCT_DASH_BRAND_IMPORT_DASH_JOB = 20230505094505;

    #[Msg('商品分类导入')]
    case PRODUCT_PRODUCT_DASH_CATEGORY_IMPORT_DASH_JOB = 20230505204842;

    #[Msg('商品导入')]
    case PRODUCT_PRODUCT_IMPORT_DASH_JOB = 20230505225409;
}
