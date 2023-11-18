<?php

declare(strict_types=1);

namespace App\Infra\Service\ApiQL;

use Leevel\Support\Str\Camelize;

trait PrepareEnumDescriptionTrait
{
    protected function prepareEnumDescription(string $enumClass, string $group = ''): array
    {
        $result = [];

        if (!method_exists($enumClass, 'descriptions')) {
            throw new \Exception(sprintf('The enum `%s` must has method `descriptions`.', $enumClass));
        }
        $descriptions = $enumClass::descriptions();
        if (!$descriptions['value']) {
            return $result;
        }

        if ($group) {
            $values = [];
            $groups = explode(',', $group);
            foreach ($groups as $group) {
                $groupMethod = Camelize::handle($group);
                if (!method_exists($enumClass, $groupMethod)) {
                    throw new \Exception(sprintf('The enum `%s` has no method `%s`.', $enumClass, $groupMethod));
                }

                $groupEnum = $enumClass::{$groupMethod}();
                $values = array_merge($values, array_filter($descriptions['value'], function (object $value) use ($groupEnum) {
                    return \in_array($value, $groupEnum, true);
                }));
            }
            $descriptions['value'] = $values;
        }

        foreach ($descriptions['value'] as $key => $value) {
            $item = [
                'name' => $value->name,
                'value' => $value->value,
            ];
            $item['msg'] = $descriptions['description'][$key];
            $result[] = $item;
        }

        return $result;
    }
}
