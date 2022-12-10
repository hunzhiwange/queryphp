<?php

declare(strict_types=1);

namespace App\Domain\Service\Login;

use App\Infra\Code as Codes;
use Leevel;
use Gregwar\Captcha\CaptchaBuilder;

/**
 * 验证码生成.
 */
class Code
{
    public function __construct(private Codes $code)
    {
    }

    public function handle(CodeParams $params): string
    {
        // Mac 自带 PHP 有问题
        if (!function_exists('imagettftext')) {
            return file_get_contents(Leevel::path('assets/captcha/code.png')) ?: '';
        }

        $numFirst = rand(11, 50);
        $numSecond = rand(11, 50);
        $numResult = $numFirst + $numSecond;
        $numPhrase = $numFirst . '+' . $numSecond;

        $builder = new CaptchaBuilder($numPhrase);
        $builder->build(120, 36);

        if ($params->id) {
            $this->code->set($params->id, (string) $numResult);
        }

        return $builder->get(100);
    }
}
