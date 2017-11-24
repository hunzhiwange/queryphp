import http from '@/utils/http'
import validate from '@/utils/validate'
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
                seccode: ''
            },
            seccodeUrl: '',
            seccodeImg: window.HOST + _g.url('login/seccode'),
            rules: {
                name: [{
                    required: true,
                    message: '请输入账号',
                    trigger: 'blur'
                }],
                password: [{
                        required: true,
                        message: '请输入密码',
                        trigger: 'blur'
                    },
                    {
                        min: 6,
                        max: 12,
                        message: '长度在 6 到 12 个字符',
                        trigger: 'blur'
                    }
                ],
                seccode: [{
                        required: true,
                        message: '请输入验证码',
                        trigger: 'blur'
                    },
                    {
                        min: 4,
                        max: 4,
                        message: '长度为 4 个字符',
                        trigger: 'blur'
                    },
                    {
                        validator: validate.alpha,
                        trigger: 'blur'
                    }
                ]
            },
            checked: false,
            remember_me: 0
        }
    },
    methods: {
        refreshSeccode() {
            this.seccodeUrl = ''
            setTimeout(() => {
                this.seccodeUrl = this.seccodeImg + '?v=' + moment().unix()
            }, 300)
        },
        handleSubmit(form) {
            if (this.loading) return
            this.$refs.form.validate((valid) => {
                if (valid) {
                    this.loading = !this.loading
                    let data = {}
                    data.name = this.form.name
                    data.password = this.form.password
                    data.seccode = this.form.seccode
                    if (this.checked) {
                        data.remember_me = 1
                    } else {
                        data.remember_me = 0
                    }
                    this.apiPost(_g.url('login/check'), data).then((res) => {
                        if (res.code != 200) {
                            this.loading = !this.loading
                            this.handleError(res)
                        } else {
                            this.refreshSeccode()
                            this.resetCommonData(res.data)
                            _g.toastMsg('success', res.message)
                        }
                    })
                } else {
                    return false
                }
            })
        },
        checkIsLogin() {
            let data = {
                is_login: 'T'
            }
            this.apiPost(_g.url('login/is_login'), data).then((res) => {
                if (res.code == 200) {
                    router.replace('/')
                }
            })
        },
        keepLogin(event){
            if(event.target.tagName == 'SPAN'){
    		    return;
            }

            Cookies.set('keep_login', !this.checked ? 'T' : 'F', {
                expires: 1
            })
        },
        checkKeepLogin() {
            let keepLogin = Cookies.get('keep_login')
            this.checked = keepLogin == 'T' ? true : false
        }
    },
    created() {
        this.checkIsLogin()
        this.seccodeUrl = this.seccodeImg
        this.checkKeepLogin()
    },
    mounted() {
        window.addEventListener('keyup', (e) => {
            if (e.keyCode === 13) {
                this.handleSubmit('form')
            }
        })
    },
    mixins: [http]
}
