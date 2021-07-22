<?php

declare(strict_types=1);

namespace App\Domain\Service\User\User;

use App\Domain\Entity\User\User;
use App\Exceptions\UserBusinessException;
use App\Exceptions\UserErrorCode;
use Leevel\Auth\Hash;
use Leevel\Database\Ddd\UnitOfWork;
use Leevel\Validate\Proxy\Validate;
use Leevel\Validate\UniqueRule;

/**
 * 用户保存.
 */
class Store
{
    use BaseStoreUpdate;

    public function __construct(
        private UnitOfWork $w,
        private Hash $hash,
    )
    {
    }

    public function handle(StoreParams $params): array
    {
        $this->validateArgs($params);

        return $this->prepareData($this->save($params));
    }

    /**
     * 保存.
     */
    private function save(StoreParams $params): User
    {
        $this->w->create($entity = $this->entity($params));
        $this->w->flush();
        $entity->refresh();

        return $entity;
    }

    /**
     * 创建实体.
     */
    private function entity(StoreParams $params): User
    {
        return new User($this->data($params));
    }

    /**
     * 创建密码
     */
    private function createPassword(string $password): string
    {
        return $this->hash->password($password);
    }

    /**
     * 组装实体数据.
     */
    private function data(StoreParams $params): array
    {
        return [
            'name'       => $params->name,
            'num'        => $params->num,
            'status'     => $params->status,
            'password' => $this->createPassword($params->password),
        ];
    }

    /**
     * 校验基本参数.
     *
     * @throws \App\Exceptions\UserBusinessException
     */
    private function validateArgs(StoreParams $params): void
    {
        $uniqueRule = UniqueRule::rule(
            User::class,
            additional:['delete_at' => 0]
        );

        $validator = Validate::make(
            $params->toArray(),
            [
                'name'     => 'required|chinese_alpha_num|max_length:64|'.$uniqueRule,
                'num'      => 'required|alpha_dash|'.$uniqueRule,
                'password' => 'required|min_length:6,max_length:30',
                'status' => [
                    ['in', User::values('status')],
                ],
            ],
            [
                'name'     => __('名字'),
                'num'      => __('编号'),
                'password' => __('密码'),
                'status'   => __('状态值'),
            ]
        );

        if ($validator->fail()) {
            $e = json_encode($validator->error(), JSON_UNESCAPED_UNICODE);

            throw new UserBusinessException(UserErrorCode::USER_STORE_INVALID_ARGUMENT, $e, true);
        }
    }
}
