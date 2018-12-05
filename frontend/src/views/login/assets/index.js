import Cookies from 'js-cookie'
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
            this.codeUrl = ''
            setTimeout(() => {
                this.codeUrl = this.codeImg + '?id=' + this.form.name + '&time=' + moment().unix()
            }, 300)
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

                            this.$store.dispatch('login', res)

                            setTimeout(() => {
                                router.replace('/')
                            }, 1000)
                        },
                        res => {
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
                expires: 30,
            })
        },
        checkKeepLogin() {
            this.checked = this.isKeepLogin()
        },
        isKeepLogin() {
            return Cookies.get('keep_login') === 'T'
        },
    },
    created() {
        this.codeUrl = this.codeImg
        this.checkKeepLogin()
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
