<template>
    <el-dialog title="账号设置" :visible.sync="dialogVisible" width="30%">
        <div>
            <el-form ref="form" :model="form" :rules="rules" label-width="80px">
                <el-form-item label="用户昵称" prop="nikename">
                  <el-input v-model="form.nikename"></el-input>
                </el-form-item>
                <el-form-item label="邮箱" prop="email">
                  <el-input v-model="form.email"></el-input>
                </el-form-item>
                <el-form-item label="手机号" prop="mobile">
                    <el-input type="number" v-model.number="form.mobile"></el-input>
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
    props: ['nikename', 'mobile', 'email'],
    data() {
      return {
        disable: false,
        dialogVisible: false,
        form: {
          nikename: '',
          email: '',
          mobile: ''
        },
        rules: {
          nikename: [
            { required: true, validator: validate.chineseAlphaDash }
          ],
          email: [
            { type: 'email', required: true, message: '请输入有效的邮箱' }
          ],
          mobile: [
            { type: 'number', validator: validate.mobile, required: true, message: '请输入有效的手机号' }
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
      submit(form) {
        this.$refs.form.validate((pass) => {
          if (pass) {
            this.disable = !this.disable
            this.apiPost('admin/user/updateInfo', this.form).then((res) => {
              this.handelResponse(res, (data) => {
                _g.toastMsg('success', res.message)
                setTimeout(() => {
                  this.disable = !this.disable
                  this.close()
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
      this.form.nikename = this.nikename
      this.form.email = this.email
      this.form.mobile = this.mobile
    },
    mixins: [http]
  }
</script>
