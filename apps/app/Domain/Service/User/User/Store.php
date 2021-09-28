<?php

declare(strict_types=1);

namespace App\Domain\Service\User\User;

use App\Domain\Entity\User\User;
use App\Exceptions\UserBusinessException;
use App\Exceptions\UserErrorCode;
use Leevel\Auth\Hash;
use Leevel\Database\Ddd\UnitOfWork;
use App\Domain\Validate\Validate;
use Leevel\Validate\UniqueRule;
use App\Domain\Validate\User\User as UserUser;

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
        );

        $validator = Validate::make(new UserUser($uniqueRule), 'store', $params->toArray())->getValidator();
        if ($validator->fail()) {
            $e = json_encode($validator->error(), JSON_UNESCAPED_UNICODE);

            throw new UserBusinessException(UserErrorCode::USER_STORE_INVALID_ARGUMENT, $e, true);
        }
    }
}
