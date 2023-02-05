<?php

declare(strict_types=1);

namespace App\Infra\Helper;

/**
 * 签名生成.
 */
class CreateSignature
{
    /**
     * @throws \UnexpectedValueException
     */
    public static function handle(string $signatureMethod, array $params, string $appSecret): string
    {
        if (empty($params)) {
            return '';
        }

        ksort($params);
        $tmpParams = [$appSecret];
        foreach ($params as $k => $v) {
            if (!\is_array($v)) {
                $tmpParams[] = $k.$v;
            } else {
                $tmpParams[] = $k.self::handle($signatureMethod, $v, $appSecret);
            }
        }
        $tmpParams[] = $appSecret;

        switch ($signatureMethod) {
            case 'hmac_sha256':
                return base64_encode(hash_hmac('sha256', implode('', $tmpParams), $appSecret, true));
        }

        throw new \UnexpectedValueException(sprintf('Signature method (%s) not supported.', $signatureMethod));
    }
}
