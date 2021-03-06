<?php

declare(strict_types=1);

namespace App\Domain\Service\User\Role;

use App\Domain\Entity\User\Role;
use App\Exceptions\UserBusinessException;
use App\Exceptions\UserErrorCode;
use Leevel\Database\Ddd\UnitOfWork;
use Leevel\Validate\Proxy\Validate;
use Leevel\Validate\UniqueRule;

/**
 * 角色保存.
 */
class Store
{
    private array $input;

    public function __construct(private UnitOfWork $w)
    {
    }

    public function handle(array $input): array
    {
        $this->input = $input;
        $this->validateArgs();

        return $this->save($input)->toArray();
    }

    /**
     * 保存.
     */
    private function save(array $input): Role
    {
        $this->w
            ->persist($entity = $this->entity($input))
            ->flush();
        $entity->refresh();

        return $entity;
    }

    /**
     * 创建实体.
     */
    private function entity(array $input): Role
    {
        return new Role($this->data($input));
    }

    /**
     * 组装实体数据.
     */
    private function data(array $input): array
    {
        return [
            'name'       => $input['name'],
            'num'        => $input['num'],
            'status' => $input['status'],
        ];
    }

    /**
     * 校验基本参数.
     *
     * @throws \App\Exceptions\UserBusinessException
     */
    private function validateArgs(): void
    {
        $uniqueRule = UniqueRule::rule(
            Role::class, 
            additional:['delete_at' => 0]
        );

        $validator = Validate::make(
            $this->input,
            [
                'name' => 'required|chinese_alpha_num|max_length:50|'.$uniqueRule,
                'num'           => 'required|alpha_dash|'.$uniqueRule,
                'status' => [
                    ['in', Role::values('status')],
                ],
            ],
            [
                'name' => __('名字'),
                'num'           => __('编号'),
                'status'   => __('状态值'),
            ]
        );

        if ($validator->fail()) {
            $e = json_encode($validator->error(), JSON_UNESCAPED_UNICODE);

            throw new UserBusinessException(UserErrorCode::ROLE_STORE_INVALID_ARGUMENT, $e, true);
        }
    }
}
