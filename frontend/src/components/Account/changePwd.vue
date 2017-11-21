<template>
<el-dialog ref="dialog" :visible.sync="dialogVisible" width="30%" title="修改密码">
    <div class="ovf-auto">
        <el-form ref="form" :model="form" :rules="rules" label-width="80px">
            <el-form-item label="旧密码" prop="old_pwd">
                <el-input type="password" v-model.trim="form.old_pwd" auto-complete="off"></el-input>
            </el-form-item>
            <el-form-item label="新密码" prop="new_pwd">
                <el-input type="password" v-model.trim="form.new_pwd" auto-complete="off"></el-input>
            </el-form-item>
            <el-form-item label="确认密码" prop="confirm_pwd">
                <el-input type="password" v-model.trim="form.confirm_pwd" auto-complete="off"></el-input>
            </el-form-item>
        </el-form>
    </div>
    <span slot="footer" class="dialog-footer">
        <el-button @click="dialogVisible = false">取 消</el-button>
        <el-button type="primary" :disabled="disable" @click="submit('form')">确 定</el-button>
    </span>
</el-dialog>
</template>
<style>

</style>
<script>
import http from '../../assets/js/http'

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
                    this.apiPost('admin/user/changePassword', this.form).then((res) => {
                        this.handelResponse(res, (data) => {
                            _g.toastMsg('success', res.message)
                            Lockr.rm('menus')
                            Lockr.rm('authKey')
                            Lockr.rm('rememberKey')
                            Lockr.rm('authList')
                            Lockr.rm('userInfo')
                            Cookies.remove('rememberPwd')
                            setTimeout(() => {
                                router.replace('/')
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
</script>
