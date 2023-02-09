<?php

declare(strict_types=1);

namespace App\Domain\Entity\Project;

use Leevel\Support\Enum;
use Leevel\Support\Msg;

/**
 * 项目问题类型内容类型值枚举.
 */
enum ProjectTypeContentTypeEnum: int
{
    use Enum;

    #[Msg('BUG')]
    case BUG = 1;

    #[Msg('任务')]
    case TASK = 2;

    #[Msg('需求')]
    case PRODUCT = 3;

    #[Msg('故事')]
    case STORY = 4;

    #[Msg('文档')]
    case DOC = 5;

    #[Msg('流程图')]
    case PROCESS = 6;

    #[Msg('思维导图')]
    case MIND = 7;

    #[Msg('Swagger内容')]
    case SWAGGER = 8;

    #[Msg('Swagger网址')]
    case SWAGGER_URL = 9;
}
