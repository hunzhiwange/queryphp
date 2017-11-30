import Vue from 'vue';
import zhApp from './zh-cn'
import enApp from './en-us'
import twApp from './zh-tw'
import zhLocale from 'iview/src/locale/lang/zh-CN'
import enLocale from 'iview/src/locale/lang/en-US'
import zhTLocale from 'iview/src/locale/lang/zh-TW'
import queryphp from '@/utils/queryphp'

// 自动设置语言
const navLang = navigator.language;
const localLang = (navLang === 'zh-CN' || navLang === 'en-US') ? navLang : false;
const lang = window.localStorage.lang || localLang || 'zh-CN';

Vue.config.lang = lang;

//import queryphp from '@/utils/queryphp'
queryphp.locale('zh-CN',zhApp)
queryphp.locale('en-US',enApp)
queryphp.locale('zh-TW',twApp)


queryphp.lang('zh-CN')

// console.log(zhApp)
// console.log(enApp)
// console.log(twApp)
//
 //console.log(zhApp)
 //console.log(zhLocale.i)

// 多语言配置
// const mergeZH = Object.assign(zhLocale, zhApp);
// const mergeEN = Object.assign(enLocale, enApp);
// const mergeTW = Object.assign(zhTLocale, twApp);
//Vue.locale('zh-CN', zhLocale)
//Vue.locale('en-US', enLocale)
//Vue.locale('zh-TW', zhTLocale)
