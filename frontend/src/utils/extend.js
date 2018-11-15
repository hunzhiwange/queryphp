import {sprintf} from 'sprintf-js'

exports.install = function (Vue, options) {
    Vue.prototype.gettext = function (){
        return this.__.apply(this, arguments)
    };

    Vue.prototype.__ = function (){
        arguments[0] = this.$t(arguments[0]);

        if (arguments.length > 1) {
            return sprintf.apply(null, arguments);
        } else {
            return arguments[0];
        }
    };
}
