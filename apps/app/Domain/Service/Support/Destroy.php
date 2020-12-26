<?php

declare(strict_types=1);

namespace App\Domain\Service\Support;

use App\Exceptions\BusinessException;
use Leevel\Database\Ddd\Entity;
use Leevel\Database\Ddd\UnitOfWork;
use Leevel\Validate\Proxy\Validate;

/**
 * 删除数据.
 */
trait Destroy
{
    public function __construct(private UnitOfWork $w)
    {
    }

    public function handle(array $input): array
    {
        $this->validateArgs($input);
        if (method_exists($this, 'validate')) {
            $this->validate($input);
        }
        $this->remove($this->find($input['id']));

        return [];
    }

    /**
     * 删除实体.
     */
    private function remove(Entity $entity): void
    {
        $this->w
            ->persist($entity)
            ->delete($entity)
            ->flush();
    }

    /**
     * 查找实体.
     */
    private function find(int $id): Entity
    {
        return $this->w->repository($this->entity())->findOrFail($id);
    }

    /**
     * 校验基本参数.
     *
     * @throws \App\Exceptions\BusinessException
     */
    private function validateArgs(array $input): void
    {
        $validator = Validate::make(
            $input,
            [
                'id'          => 'required',
            ],
            [
                'id'          => 'ID',
            ]
        );

        if ($validator->fail()) {
            $e = json_encode($validator->error(), JSON_UNESCAPED_UNICODE);

            throw new BusinessException($e);
        }
    }
}
