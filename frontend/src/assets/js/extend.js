exports.install = function (Vue, options) {
    Vue.prototype.gettext = function (){
        return gettext.apply(this, arguments);
    };

    Vue.prototype.__ = function (){
        return gettext.apply(this, arguments);
    };
}
