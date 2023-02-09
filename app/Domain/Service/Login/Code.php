<?php

declare(strict_types=1);

namespace App\Domain\Service\Login;

use App\Infra\Code as Codes;
use SimpleCaptcha\Builder;

/**
 * 验证码生成.
 */
class Code
{
    public function __construct(private Codes $code)
    {
    }

    /**
     * @throws \Exception
     */
    public function handle(CodeParams $params): string
    {
        // Mac 自带 PHP 有问题
        if (!\function_exists('imagettftext')) {
            return file_get_contents(\Leevel::path('assets/captcha/code.png')) ?: '';
        }

        $numFirst = random_int(11, 99);
        $numSecond = random_int(11, 99);
        $numResult = $numFirst + $numSecond;
        $numPhrase = $numFirst.'+'.$numSecond;

        $builder = new Builder($numPhrase);
        $builder->build(120, 36);

        if ($params->id) {
            $this->code->set($params->id, (string) $numResult);
        }

        return $builder->fetch(100);
    }
}
