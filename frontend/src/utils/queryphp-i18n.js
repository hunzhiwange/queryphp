import {sprintf} from 'sprintf-js';

let queryphp = function(objOpt) {

    objOpt = objOpt || {};

    this.numVersion = 1.0,

    this.strUpdate = '2016.11.23',

    this.objI18nMap = {
        'zh-CN': {}
    },

    this.objDefaults = {
        i18n: 'zh-CN',
        default_i18n: 'zh-CN'
    },

    this.objOptions = Object.assign({}, this.objDefaults, objOpt);
}

queryphp.prototype = {
    options: function(objOpt) {
        if (typeof objOpt != 'object') {
            throw "params must be a object";
        }

        this.objOptions = Object.assign(this.objOptions, objOpt);
    },

    lang: function(strLang) {
        this.objOptions['i18n'] = strLang;
    },

    sprintf: function() {
        if (arguments.length == 0) {
            throw "Not enough arguments for sprintf";
        }
        return sprintf.apply(null, arguments);
    },

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

let instance = new queryphp();
export default instance;

window.__ = window.gettext = function() {
    return instance.gettext.apply(instance, arguments)
}
