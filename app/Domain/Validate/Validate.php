<?php

declare(strict_types=1);

namespace App\Domain\Validate;

use Leevel\Validate\IValidator as BaseIValidator;
use Leevel\Validate\Proxy\Validate as ProxyValidate;

class Validate
{
    final public function __construct(
        protected IValidator $validator,
        protected string $scene,
        protected array $data,
    ) {
    }

        public static function make(
            IValidator $validator,
            string $scene,
            array $data,
        ): static {
            return new static($validator, $scene, $data);
        }

        public function getValidator(): BaseIValidator
        {
            return ProxyValidate::make(
                $this->data,
                $this->parseRules($this->validator, $this->scene),
                $this->validator->names(),
                $this->validator->messages()
            );
        }

        /**
         * @throws \InvalidArgumentException
         */
        protected function parseRules(IValidator $validator, string $scene): array
        {
            $validatorScenes = $validator->scenes();
            if (!isset($validatorScenes[$scene])) {
                throw new \InvalidArgumentException(__('验证器 (%s) 场景 (%s) 不存在', $validator::class, $scene));
            }

            $rules = [];
            $validatorRules = $validator->rules();
            foreach ($validatorScenes[$scene] as $k => $v) {
                // 直接继承通用验证规则
                if (\is_int($k)) {
                    $k = $v;
                    $rules[$k] = $validatorRules[$k];
                } else {
                    // 键值第一个为冒号表示合并验证规则
                    // 否则为替换验证规则
                    if (str_starts_with($k, ':')) {
                        $k = substr($k, 1);
                        $rules[$k] = array_merge((array) $v, (array) $validatorRules[$k]);
                    } else {
                        $rules[$k] = $v;
                    }
                }
            }

            return $rules;
        }
}
