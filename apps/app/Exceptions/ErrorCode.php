<?php

declare(strict_types=1);

namespace App\Exceptions;

use OutOfBoundsException;
use Leevel\Support\Enum;

/**
 * 通用业务错误码.
 * 
 * - 应用标识(服务): 表示错误属于哪个应用，第一个数字从 1 开始，三位数字(100)
 * - 功能域标识(模块): 表示错误属于应用中的哪个功能模块，三位数字(000)
 *   100000 表示通用业务错误码
 *   100001 表示用户业务错误码
 *   100002 表示上传业务错误码
 *   100003 表示认证业务错误码
 * - 错误类型: 表示错误属于那种类型，一位数字(0)
 *   0 表示错误来源于用户，参数错误，用户安装版本过低，用户支付超时等问题;
 *   1 表示错误来源于当前系统，往往是业务逻辑出错，或程序健壮性差等问题;
 *   2 表示错误来源于第三方服务，比如 CDN 服务出错，消息投递超时等问题;
 *   3 表示错误来源于数据库，数据库无法连接等;
 *   4 表示错误来源于缓存 Redis 等，缓存中间件无法连接等;
 * - 错误编码: 错误类型下的具体错误，三位数字(000)
 * 
 * @see https://zhuanlan.zhihu.com/p/152115647
 */
class ErrorCode extends Enum
{
    #[msg('删除数据参数错误')]
    public const DESTROY_DATA_INVALID_ARGUMENT = 1000000000; 

    #[msg('批量修改状态参数错误')]
    public const BATCH_MODIFICATION_STATUS_INVALID_ARGUMENT = 1000000001; 

    #[msg('未发现数据')]
    public const BATCH_MODIFICATION_STATUS_NO_DATA_FOUND = 1000000002; 

    #[msg('应用无法找到')]
    public const APP_NOT_FOUND = 1000000003;

    #[msg('服务参数错误')]
    public const SERVICE_INVALID_ARGUMENT = 1000000004; 

    /**
     * 获取错误消息.
     */
    public static function getErrorMessage(int $errorCode): string
    {
        try {
            return static::description($errorCode);
        } catch (OutOfBoundsException) {
            return '';
        }
    }
}
