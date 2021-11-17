<?php

declare(strict_types=1);

namespace App\Infra\Repository\Base;

use App\Domain\Entity\Base\App as BaseApp;
use App\Exceptions\BusinessException;
use App\Exceptions\ErrorCode;
use Leevel\Database\Ddd\Repository;

/**
 * 应用仓储.
 */
class App extends Repository
{
    /**
     * 根据应用 KEY 查找应用秘钥.
     *
     * @throws \App\Exceptions\BusinessException
     */
    public function findAppSecretByKey(string $appKey): string
    {
        $app = $this->entity
            ->select()
            ->cache('app:'.$appKey, rand(300, 600))
            ->where('key', $appKey)
            ->where('status', BaseApp::STATUS_ENABLE)
            ->setColumns('id,secret')
            ->findOne();
        if (!$app->id) {
            throw new BusinessException(ErrorCode::APP_NOT_FOUND);
        }

        return $app->secret;
    }
}
