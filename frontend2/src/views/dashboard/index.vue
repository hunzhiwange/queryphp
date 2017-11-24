<template>
<div>
    <div class="m-b-20 content-title" style="position:relative;">
        <el-breadcrumb separator="/">
            <el-breadcrumb-item :to="{ path: '/' }">首页</el-breadcrumb-item>
        </el-breadcrumb>
    </div>

    <div class="content-main2">
        <el-row>
            <el-col :span="24">
                <el-card class="box-card">
                    <div slot="header" class="clearfix">
                        <span>The QueryPHP Vue SPA Application</span>
                        <el-button style="float: right; padding: 3px 0" type="text" @click="officeSite()">官网网站</el-button>
                    </div>
                    <div>
                        <el-row type="flex" class="row-bg" justify="space-between">
                            <el-col :span="16">
                                <div class="home-box">
                                    <p>欢迎使用 QueryPHP Vue 单页面通用极速后台开发框架，本框架包含了基本认证、权限和账号管理功能，开发者可以在此基础上快速构建自己的应用。</p>
                                    <div>
                                        <div style="margin-top: 20px">
                                            <el-button @click="officeSite()" round>官方网站</el-button>
                                            <el-button @click="supportSite()" round>捐 赠</el-button>
                                            <el-button @click="githubSite()" round>Github</el-button>
                                        </div>
                                    </div>
                                </div>
                            </el-col>
                            <el-col :span="8" style="text-align:right;">
                                <img src="../../assets/images/logo.png" class="home-logo" alt="QueryPHP" />
                            </el-col>
                        </el-row>
                        <el-row>
                            <el-col :span="24">
                                <h1>Vue 前端开发步骤</h1>
                                <el-steps :active="1" simple>
                                    <el-step title="阅读 Vue 开发文档" icon="el-icon-success"></el-step>
                                    <el-step title="学习基础功能示例" icon="el-icon-error"></el-step>
                                    <el-step title="根据业务改造基础框架" icon="el-icon-error"></el-step>
                                </el-steps>
                                <h1>PHP 后端开发步骤</h1>
                                <el-steps :active="1" finish-status="success" simple style="margin-top: 20px">
                                    <el-step title="阅读 QueryPHP 开发文档"></el-step>
                                    <el-step title="学习基础功能示例"></el-step>
                                    <el-step title="根据业务改造基础框架"></el-step>
                                </el-steps>
                            </el-col>
                        </el-row>
                    </div>
                </el-card>
            </el-col>
        </el-row>

        <el-row>
            <el-col :span="24">
                <el-alert title="感谢信" type="success" description="感谢 VueThink 提供的基础框架，使得我们才能够站在巨人的肩膀上腾飞。" show-icon>
                </el-alert>
                <el-tree
  :data="data4"
  :props="defaultProps"
  show-checkbox
  node-key="id"
  default-expand-all
  :expand-on-click-node="false"
  :render-content="renderContent">
</el-tree>
            </el-col>
        </el-row>
    </div>
</div>
</template>

<style>
img.home-logo {
    height: 80px
}
</style>

<script>
export default {
    methods: {
        officeSite() {
            window.open('http://www.queryphp.com')
        },
        supportSite() {
            window.open('http://www.queryphp.com/support/')
        },
        githubSite() {
            window.open('https://github.com/hunzhiwange/queryphp')
        }
    },

    data() {
        return {
            data4: [{
              id: 1,
              label: '一级 1',
              children: [{
                id: 4,
                label: '二级 1-1',
                children: [{
                  id: 9,
                  label: '三级 1-1-1'
                }, {
                  id: 10,
                  label: '三级 1-1-2'
                }]
              }]
            }, {
              id: 2,
              label: '一级 2',
              children: [{
                id: 5,
                label: '二级 2-1'
              }, {
                id: 6,
                label: '二级 2-2'
              }]
            }, {
              id: 3,
              label: '一级 3',
              children: [{
                id: 7,
                label: '二级 3-1'
              }, {
                id: 8,
                label: '二级 3-2'
              }]
            }]

        }
    },
    methods: {
        renderContent(h, { node, data, store }) {
          return (
            <span style="flex: 1; display: flex; align-items: center; justify-content: space-between; font-size: 14px; padding-right: 8px;">
              <span>
                <span>{node.label}</span>
              </span>
              <span>
                <el-button style="font-size: 12px;" type="text" on-click={ () => this.append(data) }>Append</el-button>
                <el-button style="font-size: 12px;" type="text" on-click={ () => this.remove(node, data) }>Delete</el-button>
              </span>
            </span>)
        }
    },
    created() {},
    components: {}
}
</script>
