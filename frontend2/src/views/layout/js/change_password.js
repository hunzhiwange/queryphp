import http from '@/utils/http'

export default {
    data() {
        var validateConfirmPassword = (rule, value, callback) => {
            if (value === '') {
                callback(new Error('请再次输入密码'))
            } else if (value !== this.form.new_pwd) {
                callback(new Error('两次输入密码不一致!'))
            } else {
                callback()
            }
        }

        return {
            disable: false,
            dialogVisible: false,
            form: {
                auth_key: '',
                old_pwd: '',
                new_pwd: '',
                confirm_pwd: ''
            },
            rules: {
                old_pwd: [{
                        required: true,
                        message: '请输入旧密码',
                        trigger: 'blur'
                    },
                    {
                        min: 6,
                        max: 12,
                        message: '长度在 6 到 12 个字符',
                        trigger: 'blur'
                    }
                ],
                new_pwd: [{
                        required: true,
                        message: '请输入新密码',
                        trigger: 'blur'
                    },
                    {
                        min: 6,
                        max: 12,
                        message: '长度在 6 到 12 个字符',
                        trigger: 'blur'
                    }
                ],
                confirm_pwd: [{
                        validator: validateConfirmPassword,
                        trigger: 'blur'
                    },
                    {
                        min: 6,
                        max: 12,
                        message: '长度在 6 到 12 个字符',
                        trigger: 'blur'
                    }
                ]
            }
        }
    },
    methods: {
        open() {
            this.dialogVisible = true
        },
        close() {
            this.dialogVisible = false
        },
        submit() {
            this.$refs.form.validate((pass) => {
                if (pass) {
                    this.disable = !this.disable
                    this.apiPost('user/change_password', this.form).then((res) => {
                        this.handelResponse(res, (data) => {
                            _g.toastMsg('success', res.message)
                            setTimeout(() => {
                                this.$emit('logout')
                            }, 1000)
                        }, () => {
                            this.disable = !this.disable
                        })
                    })
                }
            })
        }
    },
    created() {
        this.form.auth_key = Lockr.get('authKey')
    },
    mixins: [http]
}
