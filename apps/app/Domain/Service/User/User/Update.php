<?php

declare(strict_types=1);

namespace App\Domain\Service\User\User;

use App\Domain\Entity\User\User;
use App\Domain\Entity\User\UserRole as EntityUserRole;
use App\Exceptions\UserBusinessException;
use App\Exceptions\UserErrorCode;
use Leevel\Auth\Hash;
use Leevel\Collection\Collection;
use Leevel\Database\Ddd\UnitOfWork;
use Leevel\Validate\IValidator;
use Leevel\Validate\Proxy\Validate;
use Leevel\Validate\UniqueRule;

/**
 * 用户更新.
 */
class Update
{
    use BaseStoreUpdate;

    private UpdateParams $params;

    public function __construct(
        private UnitOfWork $w,
        private Hash $hash
    )
    {
    }

    public function handle(UpdateParams $params): array
    {
        $this->params = $params;
        $this->validateArgs();

        return $this->prepareData($this->save($params));
    }

    /**
     * 保存.
     */
    private function save(UpdateParams $params): User
    {
        $this->w->persist($entity = $this->entity($params));
        $this->setUserRole($params->id, $params->userRole);
        $this->w->flush();
        $entity->refresh();

        return $entity;
    }

    /**
     * 查找存在角色.
     */
    private function findRoles(int $userId): Collection
    {
        return $this->w
            ->repository(EntityUserRole::class)
            ->findAll(function ($select) use ($userId) {
                $select->where('user_id', $userId);
            });
    }

    private function entity(UpdateParams $params): User
    {
        $entity = $this->find($params->id);
        $entity->num = $params->num;
        $entity->status = $params->status;
        if ($params->password) {
            $entity->password = $this->createPassword($params->password);
        }

        return $entity;
    }

    /**
     * 查找实体.
     */
    private function find(int $id): User
    {
        return $this->w
            ->repository(User::class)
            ->findOrFail($id);
    }

    /**
     * 创建密码
     */
    private function createPassword(string $password): string
    {
        return $this->hash->password($password);
    }

    /**
     * 校验基本参数.
     *
     * @throws \App\Exceptions\UserBusinessException
     */
    private function validateArgs(): void
    {
        $params = $this->params
            ->only(['num', 'password', 'status'])
            ->toArray();
        if (empty($params['password'])) {
            $params['password'] = null;
        }

        $validator = Validate::make(
            $params,
            [
                'password' => 'required|min_length:6,max_length:30'.'|'.IValidator::OPTIONAL,
                'status' => [
                    ['in', User::values('status')],
                ],
                'num'      => 'required|alpha_dash|'.UniqueRule::rule(User::class, null, $this->params->id, null, 'delete_at', 0),
            ],
            [
                'password' => __('密码'),
                'status'   => __('状态值'),
                'num'      => __('编号'),
            ]
        );

        if ($validator->fail()) {
            $e = json_encode($validator->error(), JSON_UNESCAPED_UNICODE);

            throw new UserBusinessException(UserErrorCode::USER_UPDATE_INVALID_ARGUMENT, $e, true);
        }
    }
}
