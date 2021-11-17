<?php

declare(strict_types=1);

namespace App\Domain\Service\User\User;

use App\Domain\Entity\User\User;
use App\Domain\Validate\User\User as UserUser;
use App\Domain\Validate\Validate;
use App\Exceptions\UserBusinessException;
use App\Exceptions\UserErrorCode;
use Leevel\Auth\Hash;
use Leevel\Database\Ddd\UnitOfWork;
use Leevel\Validate\UniqueRule;

/**
 * 用户更新.
 */
class Update
{
    use BaseStoreUpdate;

    public function __construct(
        private UnitOfWork $w,
        private Hash $hash
    ) {
    }

    public function handle(UpdateParams $params): array
    {
        $this->validateArgs($params);

        return $this->prepareData($this->save($params));
    }

    /**
     * 保存.
     */
    private function save(UpdateParams $params): User
    {
        $this->w->persist($entity = $this->entity($params));
        $this->w->flush();
        $entity->refresh();

        return $entity;
    }

    private function entity(UpdateParams $params): User
    {
        $entity = $this->find($params->id);
        foreach ($params->except(['id'])->toArray() as $field => $value) {
            if (null === $value) {
                continue;
            }

            if ('password' === $field) {
                $entity->password = $this->createPassword($value);
            } else {
                $entity->{$field} = $value;
            }
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
    private function validateArgs(UpdateParams $params): void
    {
        $uniqueRule = UniqueRule::rule(
            User::class,
            exceptId:$params->id,
        );

        $validator = Validate::make(new UserUser($uniqueRule), 'update', $params->toArray())->getValidator();
        if ($validator->fail()) {
            $e = json_encode($validator->error(), JSON_UNESCAPED_UNICODE);

            throw new UserBusinessException(UserErrorCode::USER_UPDATE_INVALID_ARGUMENT, $e, true);
        }
    }
}
