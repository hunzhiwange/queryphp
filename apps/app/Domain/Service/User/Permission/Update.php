<?php

declare(strict_types=1);

namespace App\Domain\Service\User\Permission;

use App\Domain\Entity\User\Permission;
use App\Exceptions\BusinessException;
use Leevel\Database\Ddd\UnitOfWork;
use Leevel\Validate\Proxy\Validate;
use Leevel\Validate\UniqueRule;

/**
 * 权限更新.
 */
class Update
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
    private function save(array $input): Permission
    {
        $this->w
            ->persist($entity = $this->entity($input))
            ->flush();

        return $entity;
    }

    /**
     * 验证参数.
     */
    private function entity(array $input): Permission
    {
        $entity = $this->find((int) $input['id']);
        $entity->withProps($this->data($input));

        return $entity;
    }

    /**
     * 查找实体.
     */
    private function find(int $id): Permission
    {
        return $this->w
            ->repository(Permission::class)
            ->findOrFail($id);
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
            'status'     => $input['status'],
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
     * @throws \App\Exceptions\BusinessException
     */
    private function validateArgs(): void
    {
        $validator = Validate::make(
            $this->input,
            [
                'id'            => 'required',
                'name' => 'required|chinese_alpha_num|max_length:50',
                'num'           => 'required|alpha_dash|'.UniqueRule::rule(Permission::class, null, $this->input['id']),
            ],
            [
                'id'            => 'ID',
                'name' => __('名字'),
                'num'           => __('编号'),
            ]
        );

        if ($validator->fail()) {
            $e = json_encode($validator->error(), JSON_UNESCAPED_UNICODE);

            throw new BusinessException($e);
        }
    }
}
