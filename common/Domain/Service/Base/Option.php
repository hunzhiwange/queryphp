<?php

declare(strict_types=1);

namespace Common\Domain\Service\Base;

use Common\Domain\Entity\Base\Option as Options;
use Leevel\Database\Ddd\UnitOfWork;

/**
 * 配置更新.
 */
class Option
{
    public function __construct(private UnitOfWork $w)
    {
    }

    public function handle(array $input): array
    {
        $this->save($input);

        return [];
    }

    /**
     * 保存.
     */
    private function save(array $input): void
    {
        foreach ($input as $k => $v) {
            $this->w->update($this->entity($k, $v));
        }

        $this->w->flush();
    }

    /**
     * 组成实体.
     */
    private function entity(string $name, string $value): Options
    {
        $option = Options::select()
            ->where(['name' => $name])
            ->setColumns('id,name')
            ->findOne();

        $option->value = $value;

        return $option;
    }
}
