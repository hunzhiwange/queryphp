import http from '@/utils/http'

export default {
    data() {
        var validateConfirmPassword = (rule, value, callback) => {
            if (value === '') {
                callback(new Error(__('请再次输入密码')))
            } else if (value !== this.form.new_pwd) {
                callback(new Error(__('两次输入密码不一致!')))
            } else {
                callback()
            }
        }

        return {
            dialogVisible: false,
            loading: false,
            form: {
                auth_key: '',
                old_pwd: '',
                new_pwd: '',
                confirm_pwd: ''
            },
            rules: {
                old_pwd: [
                        {
                            required: true,
                            message: __('请输入旧密码'),
                            trigger: 'blur'
                        }, {
                            min: 6,
                            max: 12,
                            message: __('长度在 %d 到 %d 个字符', 6, 12),
                            trigger: 'blur'
                        }
                ],
                new_pwd: [
                    {
                        required: true,
                        message: __('请输入新密码'),
                        trigger: 'blur'
                    }, {
                        min: 6,
                        max: 12,
                        message: __('长度在 %d 到 %d 个字符', 6, 12),
                        trigger: 'blur'
                    }
                ],
                confirm_pwd: [
                    {
                        validator: validateConfirmPassword,
                        trigger: 'blur'
                    }, {
                        min: 6,
                        max: 12,
                        message: __('长度在 %d 到 %d 个字符', 6, 12),
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
        ok() {
            this.$refs.form.validate((pass) => {
                if (pass) {
                    this.loading = true
                    this.apiPost('user/change_password', this.form).then((res) => {
                        _g.success(res.message)
                        setTimeout(() => {
                            this.$emit('logout')
                        }, 1000)
                    }, (res) => {
                        this.loading = !this.loading
                    })
                }
            })
        },
        cancel() {
            this.dialogVisible = false
        }
    },
    created() {
        this.form.auth_key = localStorage.getItem('authKey')
    },
    mixins: [http]
}
