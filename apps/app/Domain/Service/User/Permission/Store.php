<?php

declare(strict_types=1);

namespace App\Domain\Service\User\Permission;

use App\Domain\Entity\User\Permission;
use App\Exceptions\UserBusinessException;
use App\Exceptions\UserErrorCode;
use Leevel\Database\Ddd\UnitOfWork;
use Leevel\Validate\Proxy\Validate;
use Leevel\Validate\UniqueRule;

/**
 * 权限保存.
 */
class Store
{
    /**
     * 输入数据.
     */
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
    private function save(array $input): Permission
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
    private function entity(array $input): Permission
    {
        return new Permission($this->data($input));
    }

    /**
     * 组装实体数据.
     */
    private function data(array $input): array
    {
        $input['pid'] = $this->parseParentId($input['pid']);

        return [
            'pid'        => $input['pid'],
            'name'       => trim($input['name']),
            'num'        => trim($input['num']),
            'status' => $input['status'],
        ];
    }

    /**
     * 分析父级数据.
     */
    private function parseParentId(array $pid): int
    {
        $p = (int) (array_pop($pid));
        if ($p < 0) {
            $p = 0;
        }

        return $p;
    }

    /**
     * 校验基本参数.
     *
     * @throws \App\Exceptions\UserBusinessException
     */
    private function validateArgs(): void
    {
        $uniqueRule = UniqueRule::rule(
            Permission::class,
            null,
            null,
            null,
            'delete_at',
            0
        );

        $validator = Validate::make(
            $this->input,
            [
                'name' => 'required|chinese_alpha_num|max_length:50|'.$uniqueRule,
                'num'  => 'required|alpha_dash|'.$uniqueRule,
                'status' => [
                    ['in', Permission::values('status')],
                ],
            ],
            [
                'name' => __('名字'),
                'num'  => __('编号'),
                'status' => __('状态值'),
            ]
        );

        if ($validator->fail()) {
            $e = json_encode($validator->error(), JSON_UNESCAPED_UNICODE);
            throw new UserBusinessException(UserErrorCode::PERMISSION_STORE_INVALID_ARGUMENT, $e, true);
        }
    }
}
