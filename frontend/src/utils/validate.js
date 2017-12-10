// (c) 2018 http://your.domain.com All rights reserved.

/**
 * 公共验证规则
 *
 * @author Name Your <your@mail.com>
 * @package $$
 * @since 2017.11.14
 * @version 1.0
 */
var timeout = 50;

const validate = {
    alpha: (rule, value, callback) => {
        if (!value) {
            return callback()
        }
        setTimeout(() => {
            if (!/^[a-zA-Z]*$/.test(value)) {
                callback(new Error(__('只能是英文字母')))
            } else {
                return callback()
            }
        }, timeout)
    },
    alphaUpper: (rule, value, callback) => {
        if (!value) {
            return callback()
        }
        setTimeout(() => {
            if (!/^[A-Z]*$/.test(value)) {
                callback(new Error(__('只能是大写字母')))
            } else {
                return callback()
            }
        }, timeout)
    },
    alphaLower: (rule, value, callback) => {
        if (!value) {
            return callback()
        }
        setTimeout(() => {
            if (!/^[a-z]*$/.test(value)) {
                callback(new Error(__('只能是小写字母')))
            } else {
                return callback()
            }
        }, timeout)
    },
    alphaNum: (rule, value, callback) => {
        if (!value) {
            return callback()
        }
        setTimeout(() => {
            if (!/^[a-zA-Z0-9]{1,}$/.test(value)) {
                callback(new Error(__('只能包括英文字母和数字')))
            } else {
                return callback()
            }
        }, timeout)
    },
    alphaDash: (rule, value, callback) => {
        if (!value) {
            return callback()
        }
        setTimeout(() => {
            if (!/^[a-zA-Z0-9_-]{1,}$/.test(value)) {
                callback(new Error(__('只能包括英文字母、数字、短横线和下划线')))
            } else {
                return callback()
            }
        }, timeout)
    },
    chinese: (rule, value, callback) => {
        if (!value) {
            return callback()
        }
        setTimeout(() => {
            if (!/^[\u4E00-\u9FA5]+$/.test(value)) {
                callback(new Error(__('只能是中文字符')))
            } else {
                return callback()
            }
        }, timeout)
    },
    chineseAlphaNum: (rule, value, callback) => {
        if (!value) {
            return callback()
        }
        setTimeout(() => {
            if (!/^[\u4E00-\u9FA5a-zA-Z0-9\d]+$/u.test(value)) {
                callback(new Error(__('只能包括中文字符、英文字母和数字')))
            } else {
                return callback()
            }
        }, timeout)
    },
    chineseAlphaDash: (rule, value, callback) => {
        if (!value) {
            return callback()
        }
        setTimeout(() => {
            if (!/^[\u4E00-\u9FA5\w\d-]+$/u.test(value)) {
                return callback(new Error(__('只能包括中文字符、英文字母、数字、短横线和下划线')))
            } else {
                return callback()
            }
        }, timeout)
    },
    idCard: (rule, value, callback) => {
        if (!value) {
            return callback()
        }
        setTimeout(() => {
            if (!/(^\d{15}$)|(^\d{18}$)|(^\d{17}(\d|X|x)$)/.test(value)) {
                callback(new Error(__('请输入有效的身份证号码')))
            } else {
                return callback()
            }
        }, timeout)
    },
    mobile: (rule, value, callback) => {
        if (!value) {
            return callback()
        }
        setTimeout(() => {
            if (!value.length == 11 || !/^((1[0-9]{1})+\d{9})$/.test(value)) {
                callback(new Error(__('请输入有效的手机号码')))
            } else {
                return callback()
            }
        }, timeout)
    },
    tel: (rule, value, callback) => {
        if (!value) {
            return callback()
        }
        setTimeout(() => {
            if (!/^\d{3,4}-?\d{7,9}$/.test(value)) {
                callback(new Error(__('请输入有效的电话号码')))
            } else {
                return callback()
            }
        }, timeout)
    },
    phone: (rule, value, callback) => {
        if (!value) {
            return callback()
        }
        setTimeout(() => {
            if (!/^\d{3,4}-?\d{7,9}$/.test(value) && !(value.length == 11 && !/^((1[0-9]{1})+\d{9})$/.test(value))) {
                callback(new Error(__('请输入有效的电话或者手机号码')))
            } else {
                return callback()
            }
        }, timeout)
    },
    zipCode: (rule, value, callback) => {
        if (!value) {
            return callback()
        }
        setTimeout(() => {
            if (!/^[0-9]{6}$/.test(value)) {
                callback(new Error(__('请输入有效的邮政编码')))
            } else {
                return callback()
            }
        }, timeout)
    },
    qq: (rule, value, callback) => {
        if (!value) {
            return callback()
        }
        setTimeout(() => {
            if (!/^[1-9]\d{4,11}$/.test(value)) {
                callback(new Error(__('请输入有效的 QQ 号码')))
            } else {
                return callback()
            }
        }, timeout)
    },
    email: (rule, value, callback) => {
        if (!value) {
            return callback()
        }
        setTimeout(() => {
            if (!/^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/.test(value)) {
                callback(new Error(__('请输入有效的邮箱地址')))
            } else {
                return callback()
            }
        }, timeout)
    },
    integer: (rule, value, callback) => {
        if (!value) {
            return callback()
        }
        setTimeout(() => {
            if (!/^-?\d+$/.test(value)) {
                callback(new Error(__('请输入有效的整数')))
            } else {
                return callback()
            }
        }, timeout)
    },
    posInteger: (rule, value, callback) => {
        if (!value) {
            return callback()
        }
        setTimeout(() => {
            if (!/^\d+$/.test(value)) {
                callback(new Error(__('请输入有效的正整数')))
            } else {
                return callback()
            }
        }, timeout)
    },
    negInteger: (rule, value, callback) => {
        if (!value) {
            return callback()
        }
        setTimeout(() => {
            if (!/^-\d+$/.test(value)) {
                callback(new Error(__('请输入有效的负整数')))
            } else {
                return callback()
            }
        }, timeout)
    },
    number: (rule, value, callback) => {
        if (!value) {
            return callback()
        }
        setTimeout(() => {
            if (!/^-?\d*\.?\d+$/.test(value)) {
                callback(new Error(__('请输入有效的数字')))
            } else {
                return callback()
            }
        }, timeout)
    },
    posNumber: (rule, value, callback) => {
        if (!value) {
            return callback()
        }
        setTimeout(() => {
            if (!/^\d*\.?\d+$/.test(value)) {
                callback(new Error(__('请输入有效的正数')))
            } else {
                return callback()
            }
        }, timeout)
    },
    negNumber: (rule, value, callback) => {
        if (!value) {
            return callback()
        }
        setTimeout(() => {
            if (!/^-\d*\.?\d+$/.test(value)) {
                callback(new Error(__('请输入有效的负数')))
            } else {
                return callback()
            }
        }, timeout)
    },
    ip: (rule, value, callback) => {
        if (!value) {
            return callback()
        }
        setTimeout(() => {
            if (!/^(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)$/.test(value)) {
                callback(new Error(__('请输入有效的 IP 地址')))
            } else {
                return callback()
            }
        }, timeout)
    },
    colorHex: (rule, value, callback) => {
        if (!value) {
            return callback()
        }
        setTimeout(() => {
            if (!/^#?([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$/.test(value)) {
                callback(new Error(__('请输入有效的 RGB 颜色')))
            } else {
                return callback()
            }
        }, timeout)
    },
    date: (rule, value, callback) => {
        if (!value) {
            return callback()
        }
        setTimeout(() => {
            if (!/^(?:(?!0000)[0-9]{4}-(?:(?:0[1-9]|1[0-2])-(?:0[1-9]|1[0-9]|2[0-8])|(?:0[13-9]|1[0-2])-(?:29|30)|(?:0[13578]|1[02])-31)|(?:[0-9]{2}(?:0[48]|[2468][048]|[13579][26])|(?:0[48]|[2468][048]|[13579][26])00)-02-29)$/.test(value)) {
                callback(new Error(__('请输入有效的日期')))
            } else {
                return callback()
            }
        }, timeout)
    },
    weixin: (rule, value, callback) => {
        if (!value) {
            return callback()
        }
        setTimeout(() => {
            if (!/^[a-zA-Z]([-_a-zA-Z0-9]{5,19})+$/.test(value)) {
                callback(new Error(__('请输入有效的微信号')))
            } else {
                return callback()
            }
        }, timeout)
    },
    chinesePlateNumber: (rule, value, callback) => {
        if (!value) {
            return callback()
        }
        setTimeout(() => {
            if (!/^[京津沪渝冀豫云辽黑湘皖鲁新苏浙赣鄂桂甘晋蒙陕吉闽贵粤青藏川宁琼使领A-Z]{1}[A-Z]{1}[A-Z0-9]{4}[A-Z0-9挂学警港澳]{1}$/.test(value)) {
                callback(new Error(__('请输入有效的中国车牌号')))
            } else {
                return callback()
            }
        }, timeout)
    },
    month: (rule, value, callback) => {
        if (!value) {
            return callback()
        }
        setTimeout(() => {
            if (!/^(0?[1-9]|1[0-2])$/.test(value)) {
                callback(new Error(__('请输入有效的月份')))
            } else {
                return callback()
            }
        }, timeout)
    },
    day: (rule, value, callback) => {
        if (!value) {
            return callback()
        }
        setTimeout(() => {
            if (!/^((0?[1-9])|((1|2)[0-9])|30|31)$/.test(value)) {
                callback(new Error(__('请输入有效的月份')))
            } else {
                return callback()
            }
        }, timeout)
    },
    url: (rule, value, callback) => {
        if (!value) {
            return callback()
        }
        setTimeout(() => {
            if (!value.match(/(((^https?:(?:\/\/)?)(?:[-;:&=\+\$,\w]+@)?[A-Za-z0-9.-]+|(?:www.|[-;:&=\+\$,\w]+@)[A-Za-z0-9.-]+)((?:\/[\+~%\/.\w-_]*)?\??(?:[-\+=&;%@.\w_]*)#?(?:[\w]*))?)$/g)) {
                callback(new Error(__('请输入有效的网址')))
            } else {
                return callback()
            }
        }, timeout)
    }
}

export default validate
