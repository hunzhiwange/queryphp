<?php

declare(strict_types=1);

namespace App\Domain\Service\User\User;

use App\Domain\Entity\User\User;
use App\Infra\Exception\BusinessException;
use App\Infra\Support\WorkflowService;
use Leevel\Database\Ddd\UnitOfWork;
use Leevel\Validate\IValidator;
use Leevel\Validate\Proxy\Validate as Validates;

/**
 * 用户修改资料.
 */
class UpdateInfo
{
    use WorkflowService;

    private array $input;

    public function __construct(private UnitOfWork $w)
    {
    }

    public function handle(array $input): array
    {
        $this->input = $input;
        $this->validateArgs();
        $this->save($input)->toArray();

        return [];
    }

    /**
     * 保存.
     */
    private function save(array $input): User
    {
        $this->w->persist($entity = $this->entity($input));
        $this->w->flush();

        return $entity;
    }

    /**
     * 验证参数.
     */
    private function entity(array $input): User
    {
        $entity = $this->find((int) $input['id']);
        $entity->withProps($this->data($input));

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
     * 组装实体数据.
     */
    private function data(array $input): array
    {
        return [
            'email'        => $input['email'] ?: '',
            'mobile'       => $input['mobile'] ?: '',
        ];
    }

    /**
     * 校验基本参数.
     *
     * @throws \App\Infra\Exception\BusinessException
     */
    private function validateArgs(): void
    {
        $input = $this->filterEmptyStringInput($this->input);

        $validator = Validates::make(
            $input,
            [
                'email'       => 'email|'.IValidator::OPTIONAL,
                'mobile'      => 'mobile|'.IValidator::OPTIONAL,
            ],
            [
                'email'       => __('邮件'),
                'mobile'      => __('手机'),
            ]
        );

        if ($validator->fail()) {
            $e = json_encode($validator->error(), JSON_UNESCAPED_UNICODE);

            throw new BusinessException($e);
        }
    }
}
