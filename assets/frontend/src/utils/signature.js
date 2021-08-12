import qs from 'qs'
import hmacSHA256 from 'crypto-js/hmac-sha256'
import Base64 from 'crypto-js/enc-base64'
import ksort from 'json-ksort'

export function createSignature(params, appSecret) {
    if (0 === Object.keys(params).length) {
        return ''
    }

    let str = parseParamsString(params, appSecret)
    return Base64.stringify(hmacSHA256(str, appSecret))
}

function parseParamsString(params, appSecret) {
    if (0 === Object.keys(params).length) {
        return ''
    }

    // 解析表单键为 `hello[foo][bar]` 此类数据为对象
    params = qs.parse(qs.stringify(params))
    // 按键排序数据
    params = ksort(params)

    let tmpParams = [appSecret];
    for (let i in params) {
        let value = params[i]
        if (typeof params[i] == 'object' || params[i] instanceof Array) {
            value = JSON.stringify(params[i])
        }
        tmpParams.push(i + value)
    }
    tmpParams.push(appSecret)

    return tmpParams.join('')
}
