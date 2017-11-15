<template>
<div>
    <div class="m-b-20 content-title">
        <el-breadcrumb separator="/">
            <el-breadcrumb-item :to="{ path: '/admin/home/index' }">首页</el-breadcrumb-item>
            <el-breadcrumb-item :to="{ path: '/admin/structure/list' }">部门管理</el-breadcrumb-item>
            <el-breadcrumb-item>添加部门</el-breadcrumb-item>
        </el-breadcrumb>
    </div>

    <el-card class="box-card" style="width:100%;">
        <el-form ref="form" :model="form" :rules="rules" label-width="110px">
            <el-form-item label="部门名字" prop="name">
                <el-input v-model.trim="form.name" class="h-40 w-200"></el-input>
            </el-form-item>
            <el-form-item label="上级部门" prop="pid">
                <el-cascader class="w-200" :options="pid_options" v-model="form.pid" placeholder="试试搜索" filterable change-on-select>
                </el-cascader>
            </el-form-item>
            <el-form-item>
                <el-button type="primary" @click="add('form')" :loading="isLoading">提交</el-button>
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
            form: {
                name: '',
                pid: [-1]
            },
            pid_options: [],
            rules: {
                name: [{
                    required: true,
                    message: '请输入部门名字'
                }]
            }
        }
    },
    methods: {
        add(form) {
            this.$refs.form.validate((pass) => {
                if (pass) {
                    this.isLoading = !this.isLoading
                    this.apiPost('/admin/structure', this.form).then((res) => {
                        this.handelResponse(res, (data) => {
                            _g.clearVuex('setRules')
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
        }
    },
    created() {
        this.apiGet('/admin/structure/create' + (this.$route.params.pid ? '?pid=' + this.$route.params.pid : '')).then((res) => {
            this.handelResponse(res, (data) => {
                this.pid_options = data.list
                this.form.pid = data.selected.length > 0 ? data.selected : [-1]
            })
        })
    },
    components: {},
    mixins: [http, fomrMixin]
}
</script>
