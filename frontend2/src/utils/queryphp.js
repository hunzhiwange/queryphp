import {sprintf} from 'sprintf-js';
//(function(window) {
    /**
 * 定义 queryphp 构造函数
 */
    var queryphp = function(objOpt) {

        objOpt = objOpt || {};

        /**
     * 版本
     */
        this.numVersion = 1.0,

        /**
         * 最后更新时间
         */
        this.strUpdate = '2016.11.23',

        /**
         * 语言包映射数据
         */
        this.objI18nMap = {
            'zh-cn': {}
        },

        /**
         * 默认配置
         */
        this.objDefaults = {

            /**
             * 语言包
             */
            i18n: 'zh-cn', // 传入语言包
            default_i18n: 'zh-cn' // 默认语言包

        },

        /**
         * 合并配置
         */
        this.objOptions = Object.assign({},this.objDefaults, objOpt);
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
        __init: function() {
            // 检查语言包
            //if (this.objOptions.i18n != this.objOptions.default_i18n && typeof this.objI18nMap[this.i18n] == 'undefined') {
            //    this.objI18nMap[this.objOptions.i18n] = {};
            //}
        },

        /**
     * 修改配置
     *
     * @param object objOpt 修改配置
     * @return void
     */
        options: function(objOpt) {
            if (typeof objOpt != 'object') {
                throw "params must be a object";
            }

            this.objOptions = Object.assign(this.objOptions, objOpt);
        },

        lang: function(strLang) {

            this.objOptions['i18n'] = strLang;
        },

        /**
     * 格式化语句
     *
     * @param format
     * @param args
     * @return string
     */
        sprintf: function() {
            if (arguments.length == 0) {
                throw "Not enough arguments for sprintf";
            }
            return sprintf.apply(null, arguments);
        },

        /**
     * 新增语言包
     *
     * @param string strName 语言名字
     * @param object objData 语言包数据
     * @return  void
     */
        locale: function(strName, objData) {
            if (typeof strName != 'string' || !strName) {
                throw "package name not allowed empty";
            } else if (typeof objData != 'object') {
                throw "package data must be a object";
            }

            if (typeof this.objI18nMap[strName] == 'undefined') {
                this.objI18nMap[strName] = {};
            }

        this.objI18nMap[strName] = Object.assign(this.objI18nMap[strName], objData);

        },

        /**
     * 语言包
     *
     * @param string arguments[0] 语句
     * @return string
     */
        gettext: function() {
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

        __: function() {
            return this.gettext.apply(this, arguments);
        }

    }

    let instance = new queryphp({});
    instance.__init(arguments);
    export default  instance;

    export   function  gettext (){
        return instance.gettext.apply(instance, arguments);
    }

//})(typeof window === 'undefined' ? this : window);
