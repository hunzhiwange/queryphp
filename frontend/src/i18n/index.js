import Vue from 'vue';
import zhApp from './zh-CN'
import enApp from './en-US'
import twApp from './zh-TW'
import zhLocale from 'iview/src/locale/lang/zh-CN'
import enLocale from 'iview/src/locale/lang/en-US'
import zhTLocale from 'iview/src/locale/lang/zh-TW'
import queryphpI18n from '@/utils/queryphp-i18n'

// 自动设置语言
const navLang = navigator.language;
const localLang = (navLang === 'zh-CN' || navLang === 'en-US') ? navLang : false;
const lang = window.localStorage.lang || localLang || 'zh-CN';

Vue.config.lang = lang;

queryphpI18n.locale('zh-CN',zhApp)
queryphpI18n.locale('en-US',enApp)
queryphpI18n.locale('zh-TW',twApp)

queryphpI18n.lang(lang)

// 多语言配置
// const mergeZH = Object.assign(zhLocale, zhApp);
// const mergeEN = Object.assign(enLocale, enApp);
// const mergeTW = Object.assign(zhTLocale, twApp);
//Vue.locale('zh-CN', zhLocale)
//Vue.locale('en-US', enLocale)
//Vue.locale('zh-TW', zhTLocale)
