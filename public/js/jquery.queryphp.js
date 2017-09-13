// [$QueryPHP] The PHP Framework For Code Poem As Free As Wind. <Query Yet Simple>
// ©2010-2017 http://queryphp.com All rights reserved.

/*
 ##########################################################
 #   ____                          ______  _   _ ______   #
 #  /     \       ___  _ __  _   _ | ___ \| | | || ___ \  #
 # |   (  ||(_)| / _ \| '__|| | | || |_/ /| |_| || |_/ /  #
 #  \____/ |___||  __/| |   | |_| ||  __/ |  _  ||  __/   #
 #       \__   | \___ |_|    \__  || |    | | | || |      #
 #     Query Yet Simple      __/  |\_|    |_| |_|\_|      #
 #                          |___ /  Since 2010.10.03      #
 ##########################################################
 */

/**
 * QueryPHP Javascript V1.0
 * 
 * @author Xiangmin Liu <635750556@qq.com>
 * @version $$
 * @date 2016.11.23
 * @since 1.0
 */

/**
 * globals window, exports, define https://github.com/alexei/sprintf.js
 */
(function(window) {
    'use strict'

    var re = {
        not_string : /[^s]/,
        not_bool : /[^t]/,
        not_type : /[^T]/,
        not_primitive : /[^v]/,
        number : /[diefg]/,
        numeric_arg : /bcdiefguxX/,
        json : /[j]/,
        not_json : /[^j]/,
        text : /^[^\x25]+/,
        modulo : /^\x25{2}/,
        placeholder : /^\x25(?:([1-9]\d*)\$|\(([^\)]+)\))?(\+)?(0|'[^$])?(-)?(\d+)?(?:\.(\d+))?([b-gijostTuvxX])/,
        key : /^([a-z_][a-z_\d]*)/i,
        key_access : /^\.([a-z_][a-z_\d]*)/i,
        index_access : /^\[(\d+)\]/,
        sign : /^[\+\-]/
    }

    function sprintf() {
        var key = arguments[0], cache = sprintf.cache
        if (!(cache[key] && cache.hasOwnProperty(key))) {
            cache[key] = sprintf.parse(key)
        }
        return sprintf.format.call(null, cache[key], arguments)
    }

    sprintf.format = function(parse_tree, argv) {
        var cursor = 1, tree_length = parse_tree.length, node_type = '', arg, output = [], i, k, match, pad, pad_character, pad_length, is_positive = true, sign = ''
        for (i = 0; i < tree_length; i++) {
            node_type = get_type(parse_tree[i])
            if (node_type === 'string') {
                output[output.length] = parse_tree[i]
            } else if (node_type === 'array') {
                match = parse_tree[i] // convenience purposes only
                if (match[2]) { // keyword argument
                    arg = argv[cursor]
                    for (k = 0; k < match[2].length; k++) {
                        if (!arg.hasOwnProperty(match[2][k])) {
                            throw new Error(sprintf(
                                    '[sprintf] property "%s" does not exist',
                                    match[2][k]))
                        }
                        arg = arg[match[2][k]]
                    }
                } else if (match[1]) { // positional argument (explicit)
                    arg = argv[match[1]]
                } else { // positional argument (implicit)
                    arg = argv[cursor++]
                }

                if (re.not_type.test(match[8])
                        && re.not_primitive.test(match[8])
                        && get_type(arg) == 'function') {
                    arg = arg()
                }

                if (re.numeric_arg.test(match[8])
                        && (get_type(arg) != 'number' && isNaN(arg))) {
                    throw new TypeError(sprintf(
                            "[sprintf] expecting number but found %s",
                            get_type(arg)))
                }

                if (re.number.test(match[8])) {
                    is_positive = arg >= 0
                }

                switch (match[8]) {
                case 'b':
                    arg = parseInt(arg, 10).toString(2)
                    break
                case 'c':
                    arg = String.fromCharCode(parseInt(arg, 10))
                    break
                case 'd':
                case 'i':
                    arg = parseInt(arg, 10)
                    break
                case 'j':
                    arg = JSON.stringify(arg, null,
                            match[6] ? parseInt(match[6]) : 0)
                    break
                case 'e':
                    arg = match[7] ? parseFloat(arg).toExponential(match[7])
                            : parseFloat(arg).toExponential()
                    break
                case 'f':
                    arg = match[7] ? parseFloat(arg).toFixed(match[7])
                            : parseFloat(arg)
                    break
                case 'g':
                    arg = match[7] ? parseFloat(arg).toPrecision(match[7])
                            : parseFloat(arg)
                    break
                case 'o':
                    arg = arg.toString(8)
                    break
                case 's':
                    arg = String(arg)
                    arg = (match[7] ? arg.substring(0, match[7]) : arg)
                    break
                case 't':
                    arg = String(!!arg)
                    arg = (match[7] ? arg.substring(0, match[7]) : arg)
                    break
                case 'T':
                    arg = get_type(arg)
                    arg = (match[7] ? arg.substring(0, match[7]) : arg)
                    break
                case 'u':
                    arg = parseInt(arg, 10) >>> 0
                    break
                case 'v':
                    arg = arg.valueOf()
                    arg = (match[7] ? arg.substring(0, match[7]) : arg)
                    break
                case 'x':
                    arg = parseInt(arg, 10).toString(16)
                    break
                case 'X':
                    arg = parseInt(arg, 10).toString(16).toUpperCase()
                    break
                }
                if (re.json.test(match[8])) {
                    output[output.length] = arg
                } else {
                    if (re.number.test(match[8]) && (!is_positive || match[3])) {
                        sign = is_positive ? '+' : '-'
                        arg = arg.toString().replace(re.sign, '')
                    } else {
                        sign = ''
                    }
                    pad_character = match[4] ? match[4] === '0' ? '0'
                            : match[4].charAt(1) : ' '
                    pad_length = match[6] - (sign + arg).length
                    pad = match[6] ? (pad_length > 0 ? str_repeat(
                            pad_character, pad_length) : '') : ''
                    output[output.length] = match[5] ? sign + arg + pad
                            : (pad_character === '0' ? sign + pad + arg : pad
                                    + sign + arg)
                }
            }
        }
        return output.join('')
    }

    sprintf.cache = {}

    sprintf.parse = function(fmt) {
        var _fmt = fmt, match = [], parse_tree = [], arg_names = 0
        while (_fmt) {
            if ((match = re.text.exec(_fmt)) !== null) {
                parse_tree[parse_tree.length] = match[0]
            } else if ((match = re.modulo.exec(_fmt)) !== null) {
                parse_tree[parse_tree.length] = '%'
            } else if ((match = re.placeholder.exec(_fmt)) !== null) {
                if (match[2]) {
                    arg_names |= 1
                    var field_list = [], replacement_field = match[2], field_match = []
                    if ((field_match = re.key.exec(replacement_field)) !== null) {
                        field_list[field_list.length] = field_match[1]
                        while ((replacement_field = replacement_field
                                .substring(field_match[0].length)) !== '') {
                            if ((field_match = re.key_access
                                    .exec(replacement_field)) !== null) {
                                field_list[field_list.length] = field_match[1]
                            } else if ((field_match = re.index_access
                                    .exec(replacement_field)) !== null) {
                                field_list[field_list.length] = field_match[1]
                            } else {
                                throw new SyntaxError(
                                        "[sprintf] failed to parse named argument key")
                            }
                        }
                    } else {
                        throw new SyntaxError(
                                "[sprintf] failed to parse named argument key")
                    }
                    match[2] = field_list
                } else {
                    arg_names |= 2
                }
                if (arg_names === 3) {
                    throw new Error(
                            "[sprintf] mixing positional and named placeholders is not (yet) supported")
                }
                parse_tree[parse_tree.length] = match
            } else {
                throw new SyntaxError("[sprintf] unexpected placeholder")
            }
            _fmt = _fmt.substring(match[0].length)
        }
        return parse_tree
    }

    var vsprintf = function(fmt, argv, _argv) {
        _argv = (argv || []).slice(0)
        _argv.splice(0, 0, fmt)
        return sprintf.apply(null, _argv)
    }

    /**
     * helpers
     */
    function get_type(variable) {
        if (typeof variable === 'number') {
            return 'number'
        } else if (typeof variable === 'string') {
            return 'string'
        } else {
            return Object.prototype.toString.call(variable).slice(8, -1)
                    .toLowerCase()
        }
    }

    var preformattedPadding = {
        '0' : [ '', '0', '00', '000', '0000', '00000', '000000', '0000000' ],
        ' ' : [ '', ' ', '  ', '   ', '    ', '     ', '      ', '       ' ],
        '_' : [ '', '_', '__', '___', '____', '_____', '______', '_______' ],
    }
    function str_repeat(input, multiplier) {
        if (multiplier >= 0 && multiplier <= 7 && preformattedPadding[input]) {
            return preformattedPadding[input][multiplier]
        }
        return Array(multiplier + 1).join(input)
    }

    /**
     * export to either browser or node.js
     */
    if (typeof exports !== 'undefined') {
        exports.sprintf = sprintf
        exports.vsprintf = vsprintf
    }
    if (typeof window !== 'undefined') {
        window.sprintf = sprintf
        window.vsprintf = vsprintf

        if (typeof define === 'function' && define.amd) {
            define(function() {
                return {
                    sprintf : sprintf,
                    vsprintf : vsprintf
                }
            })
        }
    }
})(typeof window === 'undefined' ? this : window);

;
(function($, window, document, undefined) {
    var $ = window.$, jQuery = window.jQuery;

    /**
     * 定义 queryphp 构造函数
     */
    var queryphp = function(objEle, objOpt) {

        /**
         * 版本
         */
        this.numVersion = 1.0,

        /**
         * 最后更新时间
         */
        this.strUpdate = '2016.11.23',

        /**
         * 选择元素
         */
        this.$objElement = objEle,

        /**
         * 对象实例
         */
        this.objInstance,

        /**
         * 语言包映射数据
         */
        this.objI18nMap = {
            'zh-cn' : {}
        },

        /**
         * 默认配置
         */
        this.objDefaults = {

            /**
             * URL 相关
             */
            root : '',// 应用root URL地址
            enter : '',// 入口文件index.php
            app_name : '',
            controller_name : '',
            action_name : '',

            /**
             * 语言包
             */
            i18n : 'zh-cn',// 传入语言包
            default_i18n : 'zh-cn'// 默认语言包

        },

        /**
         * 合并配置
         */
        this.objOptions = $.extend({}, this.objDefaults, objOpt);
    }

    /**
     * 定义 queryphp 方法
     */
    queryphp.prototype = {

        /**
         * 初始化
         * 
         * @return void
         */
        __init : function() {
            // 检查语言包
            if (this.objOptions.i18n != this.objOptions.default_i18n
                    && typeof this.objI18nMap[this.i18n] == 'undefined') {
                this.objI18nMap[this.objOptions.i18n] = {};
            }
        },

        /**
         * 修改配置
         * 
         * @param object
         *            objOpt 修改配置
         * @return void
         */
        options : function(objOpt) {
            if (typeof objOpt != 'object') {
                $.error('params must be a object');
                return;
            }

            this.objOptions = $.extend({}, this.objOptions, objOpt);
        },

        /**
         * 框架 Javascript 生成函数
         * $Q.url('app://controller/action?param1=1&param1=2',{extraparam:'hello',extraparam2:'hello2',extraparam3:'hello3'});
         * $Q.url('@://controller/action?param1=1&param1=2',{extraparam:'hello',extraparam2:'hello2',extraparam3:'hello3'});
         * $Q.url('controller/action?param1=1&param1=2',{extraparam:'hello',extraparam2:'hello2',extraparam3:'hello3'}); >
         * 
         * @param string
         *            strUrl 初始化URL
         * @param object
         *            objParams 附加参数
         * @return string
         */
        url : function(strUrl, objParams) {
            var objUrlData = {
                enter : '',// 入口文件index.php
                app_name : '',// 应用名字
                controller_name : '',// 控制器
                action_name : '',// 方法
                extend : ''// 额外参数
            }, arrTemp, objOptions = this.objOptions, strReturnUrl;

            /**
             * 分析URL中的参数
             */

            // 提取URL中的 额外参数
            if (strUrl && strUrl.indexOf('?') > -1) {
                arrTemp = strUrl.split('?');
                if (typeof arrTemp[1] != 'undefined') {
                    objUrlData.extend = arrTemp[1];
                }
                strUrl = arrTemp[0];
            }

            // 提取 app
            if (strUrl && strUrl.indexOf('://') > -1) {
                arrTemp = strUrl.split('://');
                if (temp[0] == '@') {
                    objUrlData.app_name = objOptions.app_name;
                    strUrl = arrTemp[1];
                } else {
                    objUrlData.app_name = temp[0];
                    strUrl = arrTemp[1];
                }
            }

            // 入口文件
            objUrlData.enter = objOptions.enter;

            // 提取控制器和方法
            if (strUrl && strUrl.indexOf('/') > -1) {
                arrTemp = strUrl.split('/');
                if (arrTemp[0] == '@') {
                    objUrlData.controller_name = objOptions.controller_name;
                } else {
                    objUrlData.controller_name = arrTemp[0];
                }
                if (arrTemp[1] == '@') {
                    objUrlData.action_name = objOptions.action_name;
                } else {
                    objUrlData.action_name = arrTemp[1];
                }
            } else {
                if (strUrl) {
                    objUrlData.controller_name = objOptions.controller_name;
                    objUrlData.action_name = strUrl;
                } else {
                    objUrlData.controller_name = objOptions.controller_name;
                    objUrlData.action_name = objOptions.action_name;
                }
            }

            strReturnUrl = this.objOptions.root
                    + objUrlData.enter
                    + (objUrlData.app_name ? '?app=' + objUrlData.app_name
                            + '&' : '?') + 'c=' + objUrlData.controller_name
                    + '&a=' + objUrlData.action_name
                    + (objUrlData.extend ? '&' + objUrlData.extend : '');

            // 额外参数
            if (objParams && $.param(objParams)) {
                strReturnUrl += '&' + $.param(objParams);
            }

            return strReturnUrl;
        },

        /**
         * 格式化语句
         * 
         * @param format
         * @param args
         * @return string
         */
        sprintf : function() {
            if (arguments.length == 0) {
                throw "Not enough arguments for sprintf";
            }
            return sprintf.apply(null, arguments);
        },

        /**
         * 新增语言包
         * 
         * @param string
         *            strName 语言名字
         * @param object
         *            objData 语言包数据
         * @return  void
         */
        i18nPackage : function(strName, objData) {
            if (typeof strName != 'string' || !strName) {
                $.error('package name not allowed empty');
                return;
            } else if (typeof objData != 'object') {
                $.error('package data must be a object');
                return;
            }

            // 已经存在，则合并
            if (typeof this.objI18nMap[strName] != 'undefind') {
                this.objI18nMap[strName] = $.extend({},
                        this.objI18nMap[strName], objData);
            } else {
                this.objI18nMap[strName] = objData;
            }
        },

        /**
         * 语言包
         * 
         * @param string
         *            arguments[0] 语句
         * @return string
         */
        i18n : function() {
            if (arguments.length == 0) {
                throw "Not enough arguments for sprintf";
            }
            var objOptions = this.objOptions;

            if (objOptions.default_i18n != objOptions.i18n) {
                if (typeof this.objI18nMap[objOptions.i18n][arguments[0]] != 'undefined') {
                    arguments[0] = this.objI18nMap[objOptions.i18n][arguments[0]];
                }
            }

            // 带入参数
            if (arguments.length > 1) {
                return this.sprintf.apply(null, arguments);
            } else {
                return arguments[0];
            }
        },

        /**
         * JS 模板引擎
         * 
         * @param mixed
         *            id ID、jquery对象或者DOM
         * @param $object
         *            objData 数据
         * @return string
         */
        template : function(mixId, $objData) {
            "use strict";

            var str = 'var ', arrTemp = [], strOut = '';

            // 变量赋值
            for ( var strK in $objData) {
                arrTemp.push(strK + " = $objData['" + strK + "']");
            }
            str += arrTemp.join(", ") + ";\n";

            // 模板内容
            if (typeof mixId == 'string') {
                mixId = $('#' + mixId);
            } else if (!(mixId instanceof jQuery)) {
                mixId = $(mixId);
            }
            str += "strOut += '" + mixId.html() + "';";

            // 去掉空格和回车换行
            str = str.replace(/\s+/g, ' ') // 去掉多个空格
            .replace(/[\r\n]/g, ""); // 去掉回车换行

            // 调试语句
            str = "try { "
                    + str
                    + "} catch ( e ) {"
                    + "strOut = '<font color=\"red\">template error, see console</font>';"
                    + "console.log( '%c Query Yet Simple [template] %c(http://www.queryphp.com)', 'color: #8A2BE2;', 'color: #528B8B;' );"
                    + "console.log('%c '+e.code + ': ' + e.message,'color: red;');"
                    + "}";

            // 执行编译
            eval(str);

            return strOut;
        }

    }

    /**
     * 入口文件
     * 
     * 封装 JS 语言包和输出 URL 等
     * 
     * @param mixed mixOptions
     * @author 小牛
     * @date 2016-12-13
     * @return mixed
     */
    $.fn.queryphp = function(mixOptions) {
        if (!(this.objInstance instanceof queryphp)) {
            if (typeof mixOptions == 'object') {
                // 创建 queryphp 对象
                this.objInstance = new queryphp(this, mixOptions);
                this.objInstance.__init(arguments);
                return this.objInstance;
            } else {
                $.error('jquery.queryphp.js is not initiated');
            }
        } else {
            if (typeof mixOptions == 'string'
                    && typeof this.objInstance[mixOptions] != 'undefined') {
                return this.objInstance[mixOptions].apply(this.objInstance,
                        Array.prototype.slice.call(arguments, 1));
            } else {
                $.error('Method ' + mixOptions
                        + ' does not exist on jquery.queryphp.js');
            }
        }
    }
})(jQuery, window, document);
