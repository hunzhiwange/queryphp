<?php

declare(strict_types=1);

namespace App\Domain\Service\User\Resource;

use App\Domain\Entity\User\Resource;
use App\Exceptions\UserBusinessException;
use App\Exceptions\UserErrorCode;
use Leevel\Database\Ddd\UnitOfWork;
use Leevel\Validate\Proxy\Validate;
use Leevel\Validate\UniqueRule;

/**
 * 资源更新.
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
    private function save(array $input): Resource
    {
        $this->w
            ->persist($entity = $this->entity($input))
            ->flush();
        $entity->refresh();

        return $entity;
    }

    /**
     * 验证参数.
     */
    private function entity(array $input): Resource
    {
        $entity = $this->find((int) $input['id']);
        $entity->withProps($this->data($input));

        return $entity;
    }

    /**
     * 查找实体.
     */
    private function find(int $id): Resource
    {
        return $this->w
            ->repository(Resource::class)
            ->findOrFail($id);
    }

    /**
     * 组装实体数据.
     */
    private function data(array $input): array
    {
        return [
            'name'  => trim($input['name']),
            'num'        => trim($input['num']),
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
        $validator = Validate::make(
            $this->input,
            [
                'id'            => 'required',
                'name' => 'required|chinese_alpha_num|max_length:50',
                'num'           => 'required|'.UniqueRule::rule(Resource::class, null, $this->input['id']),
                'status' => [
                    ['in', Resource::values('status')],
                ],
            ],
            [
                'id'            => 'ID',
                'name' => __('名字'),
                'num'           => __('编号'),
                'status' => __('状态值'),
            ]
        );

        if ($validator->fail()) {
            $e = json_encode($validator->error(), JSON_UNESCAPED_UNICODE);

            throw new UserBusinessException(UserErrorCode::RESOURCE_UPDATE_INVALID_ARGUMENT, $e, true);
        }
    }
}
