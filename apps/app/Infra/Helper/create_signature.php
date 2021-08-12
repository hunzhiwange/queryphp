<?php

declare(strict_types=1);

namespace App\Infra\Helper;

/**
 * 签名生成.
 */
function create_signature(array $params, string $appSecret): string  
{                                                                          
    if(empty($params)) {
        return '';
    }

    ksort($params);
    $tmpParams = [$appSecret];
    foreach($params as $k => $v){                                                    
        if (!is_array($v)) {                                                    
            $tmpParams[] = $k . $v;                                                    
        } else {  
            $tmpParams[] = $k . json_encode($v, JSON_FORCE_OBJECT);                                
        }                                                                       
    }
    $tmpParams[] = $appSecret;

    return base64_encode(hash_hmac('sha256', implode('', $tmpParams), $appSecret, true));                                                                
}

class create_signature
{
}
