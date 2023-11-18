<?php

declare(strict_types=1);

namespace App\User\Controller\ApiQL\V1\User;

use App\User\Entity\User;
use Leevel\Http\Request;

/**
 * 用户修改资料.
 *
 * @codeCoverageIgnore
 */
class UpdateInfo
{
    public function handle(Request $request): array
    {
        $entity = api_ql_update(
            User::class,
            get_account_id(),
            $request->all(),
            'update_info',
        );

        return ['id' => $entity->id];
    }
}
