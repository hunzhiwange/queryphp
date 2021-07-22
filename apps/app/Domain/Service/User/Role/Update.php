<?php

declare(strict_types=1);

namespace App\Domain\Service\User\Role;

use App\Domain\Entity\User\Role;
use Leevel\Database\Ddd\UnitOfWork;
use Leevel\Validate\UniqueRule;
use App\Exceptions\UserBusinessException;
use App\Exceptions\UserErrorCode;
use Leevel\Validate\Proxy\Validate;

/**
 * 角色更新.
 */
class Update
{
    public function __construct(private UnitOfWork $w)
    {
    }

    public function handle(UpdateParams $params): array
    {
        $this->validateArgs($params);

        return $this->save($params)->toArray();
    }

    /**
     * 验证参数.
     */
    private function entity(UpdateParams $params): Role
    {
        $entity = $this->find($params->id);
        $entity->withProps($this->data($params));

        return $entity;
    }

    /**
     * 查找实体.
     */
    private function find(int $id): Role
    {
        return $this->w
            ->repository(Role::class)
            ->findOrFail($id);
    }

    /**
     * 组装实体数据.
     */
    private function data(UpdateParams $params): array
    {
        return $params->except(['id'])->toArray();
    }

    /**
     * 保存.
     */
    private function save(UpdateParams $params): Role
    {
        $this->w
            ->persist($entity = $this->entity($params))
            ->flush();
        $entity->refresh();

        return $entity;
    }

    /**
     * 校验基本参数.
     *
     * @throws \App\Exceptions\UserBusinessException
     */
    private function validateArgs(UpdateParams $params): void
    {
        list($rules, $names) = $this->validateInputRules($params);

        $validator = Validate::make(
            $params->toArray(),
            $rules,
            $names,
        );

        if ($validator->fail()) {
            $e = json_encode($validator->error(), JSON_UNESCAPED_UNICODE);

            throw new UserBusinessException(UserErrorCode::ROLE_UPDATE_INVALID_ARGUMENT, $e, true);
        }
    }

    /**
     * 校验数据规则.
     */
    private function validateInputRules(UpdateParams $params): array
    {
        $uniqueRule = UniqueRule::rule(
            Role::class,
            exceptId:$params->id, 
            additional:['delete_at' => 0]
        );

        $rules = [
            'id' => [
                'required',
            ],
            'name' => [
                'required',
                'chinese_alpha_num',
                'max_length:50',
                $uniqueRule,
            ],
            'num' => [
                'required',
                'alpha_dash',
                $uniqueRule,
            ],
            'status' => [
                ['in', Role::values('status')],
            ],
        ];

        $names = [
            'id'     => 'ID',
            'name'   => __('名字'),
            'num'    => __('编号'),
            'status' => __('状态值'),
        ];

        return [$rules, $names];
    }
}
