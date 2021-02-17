<?php

declare(strict_types=1);

namespace App\Domain\Service\Login;

use Admin\Infra\Code as Codes;
use Leevel;
use Leevel\Seccode\Seccode;

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
            return file_get_contents(Leevel::path('assets/seccode/code.png')) ?: '';
        }

        $seccode = new Seccode([
            'font_path' => Leevel::path('assets/seccode/font'),
            'width'     => 120,
            'height'    => 36,
        ]);

        ob_start();
        $seccode->display(4);
        if ($params->id) {
            $this->code->set($params->id, (string) $seccode->getCode());
        }
        $content = ob_get_contents() ?: '';
        ob_end_clean();

        return $content;
    }
}
