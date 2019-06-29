import Cookies from 'js-cookie'
import moment from 'moment'
import http from '@/utils/http'
import {validateAlpha} from '@/utils/validate'
import img_logo from '@/assets/images/logo.png'
import img_login_banner from '@/assets/images/login_banner.png'

export default {
    data() {
        return {
            img_logo: img_logo,
            img_login_banner: img_login_banner,
            loading: false,
            form: {
                name: '',
                password: '',
                code: '',
            },
            codeUrl: '',
            codeImg: process.env.VUE_APP_BASE_API + '/:admin/login/code',
            rules: {
                name: [
                    {
                        required: true,
                        message: this.__('请输入账号'),
                        trigger: 'blur',
                    },
                ],
                password: [
                    {
                        required: true,
                        message: this.__('请输入密码'),
                        trigger: 'blur',
                    },
                    {
                        min: 6,
                        max: 12,
                        message: this.__('长度在 %d 到 %d 个字符', 6, 12),
                        trigger: 'blur',
                    },
                ],
                code: [
                    {
                        required: true,
                        message: this.__('请输入验证码'),
                        trigger: 'blur',
                    },
                    {
                        min: 4,
                        max: 4,
                        message: this.__('长度为 %d 个字符', 4),
                        trigger: 'blur',
                    },
                    {
                        validator: validateAlpha,
                        trigger: 'blur',
                    },
                ],
            },
            checked: false,
            remember: 0,
        }
    },
    methods: {
        refreshSeccode() {
            this.codeUrl = this.codeImg + '?id=' + this.form.name + '&time=' + moment().unix()
        },
        handleSubmit(form) {
            if (this.loading) return
            this.$refs.form.validate(valid => {
                if (valid) {
                    this.loading = !this.loading

                    let data = {}
                    data.name = this.form.name
                    data.password = this.form.password
                    data.code = this.form.code
                    data.app_id = process.env.VUE_APP_APP_ID
                    data.app_key = process.env.VUE_APP_APP_KEY

                    if (this.checked) {
                        data.remember = 1
                    } else {
                        data.remember = 0
                    }

                    this.apiPost('login/validate', data).then(
                        res => {
                            utils.success(this.__('登陆成功'))

                            res.keepLogin = this.isKeepLogin()
                            this.refreshPermission(res.token)
                            this.userInfo(res.token)
                            this.$store.dispatch('login', res)

                            setTimeout(() => {
                                window.location.href = '/'
                            }, 1000)
                        },
                        () => {
                            this.loading = !this.loading
                        }
                    )
                } else {
                    return false
                }
            })
        },
        keepLogin() {
            Cookies.set('keep_login', this.checked ? 'T' : 'F', {
                expires: 60,
            })
        },
        checkKeepLogin() {
            this.checked = this.isKeepLogin()
        },
        isKeepLogin() {
            return Cookies.get('keep_login') === 'T' || !Cookies.get('keep_login')
        },
        refreshPermission(token) {
            this.apiGet('user/permission', {refresh: '1', token: token}).then(res => {
                this.$store.dispatch('setRules', res)
            })
        },
        userInfo(token) {
            this.apiGet('user/info', {refresh: '1', token: token}).then(res => {
                this.$store.dispatch('setUsers', res)
            })
        },
        setTheme() {
            let stylePath = '/'
            if (localStorage.theme) {
                let theme = JSON.parse(localStorage.theme)
                this.$store.commit('changeMenuTheme', theme.menuTheme)
                this.$store.commit('changeMainTheme', theme.mainTheme)
            } else {
                this.$store.commit('changeMenuTheme', 'light')
                this.$store.commit('changeMainTheme', 'b')
            }
            // 根据用户设置主题
            if (this.$store.state.app.themeColor !== 'b') {
                let stylesheetPath = stylePath + this.$store.state.app.themeColor + '.css'
                let themeLink = document.querySelector('link[name="theme"]')
                themeLink.setAttribute('href', stylesheetPath)
            }
        },
    },
    created() {
        this.checkKeepLogin()
        this.setTheme()
    },
    mounted() {
        window.addEventListener('keyup', e => {
            if (e.keyCode === 13) {
                this.handleSubmit('form')
            }
        })
    },
    mixins: [http],
}
