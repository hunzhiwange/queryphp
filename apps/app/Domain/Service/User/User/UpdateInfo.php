<?php

declare(strict_types=1);

namespace App\Domain\Service\User\User;

use App\Domain\Entity\User\User;
use App\Exceptions\UserBusinessException;
use App\Exceptions\UserErrorCode;
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

    public function __construct(private UnitOfWork $w)
    {
    }

    public function handle(UpdateInfoParams $params): array
    {
        $this->validateArgs($params);
        $this->save($params)->toArray();

        return [];
    }

    /**
     * 保存.
     */
    private function save(UpdateInfoParams $params): User
    {
        $this->w->persist($entity = $this->entity($params));
        $this->w->flush();

        return $entity;
    }

    /**
     * 验证参数.
     */
    private function entity(UpdateInfoParams $params): User
    {
        $entity = $this->find($params->id);
        $entity->withProps($this->data($params));

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
    private function data(UpdateInfoParams $params): array
    {
        return [
            'email' => $params->email,
            'mobile' => $params->mobile,
        ];
    }

    /**
     * 校验基本参数.
     *
     * @throws \App\Exceptions\UserBusinessException
     */
    private function validateArgs(UpdateInfoParams $params): void
    {
        $params = $this->filterEmptyStringInput($params->toArray());

        $validator = Validates::make(
            $params,
            [
                'email'  => 'email|'.IValidator::OPTIONAL,
                'mobile' => 'mobile|'.IValidator::OPTIONAL,
            ],
            [
                'email'  => __('邮件'),
                'mobile' => __('手机'),
            ]
        );

        if ($validator->fail()) {
            $e = json_encode($validator->error(), JSON_UNESCAPED_UNICODE);
            throw new UserBusinessException(UserErrorCode::USER_UPDATE_INFO_INVALID_ARGUMENT, $e, true);
        }
    }
}
