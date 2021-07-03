import {sprintf} from 'sprintf-js'

export default function(Vue, options) {
    Vue.prototype.gettext = function() {
        return this.__.apply(this, arguments)
    }

    Vue.prototype.__ = function() {
        if ('zh-CN' !== this._i18n.locale) {
            arguments[0] = this.$t(arguments[0])
        }

        if (arguments.length > 1) {
            return sprintf.apply(null, arguments)
        } else {
            return arguments[0]
        }
    }
}
