<template>
  <div>
    <div class="m-b-20 content-title">
      <el-breadcrumb separator="/">
        <el-breadcrumb-item :to="{ path: '/admin/home/index' }">首页</el-breadcrumb-item>
        <el-breadcrumb-item :to="{ path: '/admin/structure/list' }">部门管理</el-breadcrumb-item>
        <el-breadcrumb-item>编辑部门</el-breadcrumb-item>
      </el-breadcrumb>
    </div>

    <el-card class="box-card" style="width:100%;">
      <el-form ref="form" :model="form" :rules="rules" label-width="110px">
        <el-form-item label="部门名字" prop="name">
          <el-input v-model.trim="form.name" class="h-40 w-200"></el-input>
        </el-form-item>
        <el-form-item label="上级部门" prop="pid">
          <el-cascader
            class="w-200"
            :options="pid_options"
            v-model="form.pid"
            placeholder="试试搜索"
            filterable
            change-on-select>
          </el-cascader>
        </el-form-item>
        <el-form-item>
          <el-button type="primary" @click="edit('form')" :loading="isLoading">提交</el-button>
          <el-button @click="goback()">返回</el-button>
        </el-form-item>
      </el-form>
    </el-card>
  </div>
</template>

<script>
import http from '../../../../assets/js/http'
import fomrMixin from '../../../../assets/js/form_com'

export default {
  data() {
    return {
      isLoading: false,
      id: null,
      form: {
        name: '',
        pid: [-1]
      },
      pid_options: [],
      rules: {
        name: [
          { required: true, message: '请输入部门名字' }
        ]
      }
    }
  },
  methods: {
    edit(form) {
      this.$refs.form.validate((pass) => {
        if (pass) {
          this.isLoading = !this.isLoading
          this.apiPut('/admin/structure/', this.id, this.form).then((res) => {
            this.handelResponse(res, (data, message) => {
              _g.toastMsg('success', res.message)
              setTimeout(() => {
                router.replace('/admin/structure/list')
              }, 1000)
            }, () => {
              this.isLoading = !this.isLoading
            })
          })
        }
      })
    },
    goback() {
      router.go(-1)
    }
  },
  created() {
    this.id = this.$route.params.id
    this.apiGet('/admin/structure/' + this.id + '/edit').then((res) => {
      this.handelResponse(res, (data) => {
        if (!data.menu_type) {
          data.menu_type = 1
        }
        data.menu_type = data.menu_type.toString()
        this.form = data.one
        this.pid_options = data.list
      })
    })
  },
  components: {},
  mixins: [http, fomrMixin]
}
</script>
