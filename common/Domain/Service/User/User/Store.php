<?php

declare(strict_types=1);

namespace Common\Domain\Service\User\User;

use Common\Domain\Entity\User\User;
use Common\Domain\Entity\User\UserRole;
use Common\Infra\Exception\BusinessException;
use Leevel\Auth\Hash;
use Leevel\Collection\Collection;
use Leevel\Database\Ddd\UnitOfWork;
use Leevel\Validate\Proxy\Validate;
use Leevel\Validate\UniqueRule;

/**
 * 用户保存.
 */
class Store
{
    use BaseStoreUpdate;

    private array $input;

    public function __construct(private UnitOfWork $w, private Hash $hash)
    {
    }

    public function handle(array $input): array
    {
        $this->input = $input;
        $this->validateArgs();

        return $this->prepareData($this->save($input));
    }

    /**
     * 保存.
     */
    private function save(array $input): User
    {
        $this->w->persist($entity = $this->entity($input));
        $this->w->on($entity, function (User $user) use ($input) {
            $this->setUserRole((int) $user->id, $input['userRole'] ?? []);
        });
        $this->w->flush();
        $entity->refresh();

        return $entity;
    }

    /**
     * 查找存在角色.
     */
    private function findRoles(): Collection
    {
        return UserRole::make()->collection();
    }

    /**
     * 创建实体.
     */
    private function entity(array $input): User
    {
        return new User($this->data($input));
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
    private function data(array $input): array
    {
        return [
            'name'       => trim($input['name']),
            'num'        => trim($input['num']),
            'status'     => $input['status'],
            'password'   => $this->createPassword(trim($input['password'])),
        ];
    }

    /**
     * 校验基本参数.
     *
     * @throws \Common\Infra\Exception\BusinessException
     */
    private function validateArgs(): void
    {
        $validator = Validate::make(
            $this->input,
            [
                'name'     => 'required|chinese_alpha_num|max_length:64',
                'num'      => 'required|alpha_dash|'.UniqueRule::rule(User::class, null, null, null, 'delete_at', 0),
                'password' => 'required|min_length:6,max_length:30',
            ],
            [
                'name'     => __('名字'),
                'num'      => __('编号'),
                'password' => __('密码'),
            ]
        );

        if ($validator->fail()) {
            $e = json_encode($validator->error(), JSON_UNESCAPED_UNICODE);

            throw new BusinessException($e);
        }
    }
}
