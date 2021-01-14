import Vue from 'vue'
import zhCnApp from './zh-CN'
import enUsApp from './en-US'
import zhTwApp from './zh-TW'
import zhCnLocale from 'view-design/src/locale/lang/zh-CN'
import enUsLocale from 'view-design/src/locale/lang/en-US'
import zhTwLocale from 'view-design/src/locale/lang/zh-TW'
import VueI18n from 'vue-i18n'

Vue.use(VueI18n)

// 自动设置语言
const navLang = navigator.language
const localLang = navLang === 'zh-CN' || navLang === 'en-US' ? navLang : false
const lang = window.localStorage.lang || localLang || 'zh-CN'

//Vue.config.lang = lang

const i18n = new VueI18n({
    locale: lang,
    messages: {
      'zh-CN': Object.assign(zhCnLocale, zhCnApp),
      'zh-TW': Object.assign(zhTwLocale, zhTwApp),
      'en-US': Object.assign(enUsLocale, enUsApp),
    }
})

export default i18n
