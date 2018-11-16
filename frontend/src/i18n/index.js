import Vue from "vue";
import zhCnApp from "./zh-CN";
import enUsApp from "./en-US";
import zhTwApp from "./zh-TW";
import zhCnLocale from "iview/src/locale/lang/zh-CN";
import enUsLocale from "iview/src/locale/lang/en-US";
import zhTwLocale from "iview/src/locale/lang/zh-TW";
import VueI18n from "vue-i18n";

Vue.use(VueI18n);

// 自动设置语言
const navLang = navigator.language;
const localLang = navLang === "zh-CN" || navLang === "en-US" ? navLang : false;
const lang = window.localStorage.lang || localLang || "zh-CN";

Vue.config.lang = lang;

Vue.locale("zh-CN", Object.assign(zhCnLocale, zhCnApp));
Vue.locale("zh-TW", Object.assign(zhTwLocale, zhTwApp));
Vue.locale("en-US", Object.assign(enUsLocale, enUsApp));
