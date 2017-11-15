<template>
<div>
    <div class="m-b-20 content-title">
        <el-breadcrumb separator="/">
            <el-breadcrumb-item :to="{ path: '/admin/home/index' }">首页</el-breadcrumb-item>
            <el-breadcrumb-item :to="{ path: '/admin/menu/list' }">菜单管理</el-breadcrumb-item>
            <el-breadcrumb-item>编辑菜单</el-breadcrumb-item>
        </el-breadcrumb>
    </div>

    <el-card class="box-card" style="width:100%;">
        <el-form ref="form" :model="form" :rules="rules" label-width="110px">
            <el-form-item label="标题" prop="title">
                <el-input v-model.trim="form.title" class="h-40 w-200"></el-input>
            </el-form-item>
            <el-form-item label="菜单类型" prop="menu_type">
                <el-radio-group v-model="form.menu_type">
                    <el-radio label="1">普通三级菜单</el-radio>
                    <el-radio label="2">单页菜单</el-radio>
                    <el-radio label="3">外链</el-radio>
                </el-radio-group>
            </el-form-item>
            <el-form-item label="上级菜单" prop="pid">
                <el-cascader class="w-200" :options="pid_options" v-model="form.pid" placeholder="试试搜索" filterable change-on-select>
                </el-cascader>
            </el-form-item>
            <el-form-item label="路径">
                <el-input v-model.trim="form.url" class="h-40 w-200"></el-input>
            </el-form-item>
            <el-form-item label="模块" prop="module">
                <el-input v-model.trim="form.module" class="h-40 w-200"></el-input>
            </el-form-item>
            <el-form-item label="所属菜单">
                <el-input v-model.trim="form.menu" class="h-40 w-200"></el-input>
            </el-form-item>
            <el-form-item label="图标">
                <el-input v-model.trim="form.menu_icon" class="h-40 w-200"></el-input>
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
                title: '',
                pid: [-1],
                menu_type: '',
                url: '',
                module: '',
                menu: '',
                menu_icon: ''
            },
            pid_options: [],
            rules: {
                title: [{
                    required: true,
                    message: '请输入菜单标题'
                }],
                menu_type: [{
                    required: true,
                    message: '请选择菜单类型'
                }],
                module: [{
                    required: true,
                    message: '请填写菜单模块'
                }]
            }
        }
    },
    methods: {
        edit(form) {
            this.$refs.form.validate((pass) => {
                if (pass) {
                    this.isLoading = !this.isLoading
                    this.apiPut('/admin/menu/', this.id, this.form).then((res) => {
                        this.handelResponse(res, (data, message) => {
                            _g.toastMsg('success', res.message)
                            setTimeout(() => {
                                router.replace('/admin/menu/list')
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
        this.apiGet('/admin/menu/' + this.id + '/edit').then((res) => {
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
