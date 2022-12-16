<?php

declare(strict_types=1);

namespace App\Domain\Entity\Project;

use Leevel\Support\BaseEnum;

/**
 * 项目问题类型内容类型值枚举.
 */
enum ProjectTypeContentTypeEnum:int
{
    use BaseEnum;

    #[msg('BUG')]
    case BUG = 1;

    #[msg('任务')]
    case TASK = 2;

    #[msg('需求')]
    case PRODUCT = 3;

    #[msg('故事')]
    case STORY = 4;

    #[msg('文档')]
    case DOC = 5;

    #[msg('流程图')]
    case PROCESS = 6;

    #[msg('思维导图')]
    case MIND = 7;

    #[msg('Swagger内容')]
    case SWAGGER = 8;

    #[msg('Swagger网址')]
    case SWAGGER_URL = 9;
}
