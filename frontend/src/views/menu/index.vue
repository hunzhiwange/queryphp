<template>
<div class="menu-page">
    <Row>
        <div class="min-form" v-show="minForm">
            <div class="min-form-inner">
                <legend>{{formItem.id ? __('编辑菜单') : __('新增菜单')}}</legend>
                <div class="min-form-body">
                    <Form ref="form" :rules="rules" :model="formItem" :label-width="110" class="w-600">
                        <FormItem :label="__('上级菜单')" prop="pid">
                            <Cascader v-model="formItem.pid" :data="pidOptions" :disabled="pidDisabled" filterable change-on-select></Cascader>
                        </FormItem>
                        <FormItem :label="__('标题')" prop="title">
                            <Input v-model.trim="formItem.title" placeholder=""></Input>
                        </FormItem>
                        <FormItem :label="__('名字')" prop="name">
                            <Input v-model.trim="formItem.name" placeholder=""></Input>
                        </FormItem>
                        <FormItem :label="__('路径')" prop="path">
                            <Input v-model.trim="formItem.path" placeholder=""></Input>
                        </FormItem>
                        <FormItem :label="__('组件')" prop="component">
                            <Input v-model.trim="formItem.component" placeholder=""></Input>
                        </FormItem>
                        <FormItem :label="__('图标')" prop="icon">
                            <Input v-model.trim="formItem.icon" placeholder=""></Input>
                        </FormItem>
                        <FormItem :label="__('应用')" prop="app">
                            <Input v-model.trim="formItem.app" placeholder=""></Input>
                        </FormItem>
                        <FormItem :label="__('控制器')" prop="controller">
                            <Input v-model.trim="formItem.controller" placeholder=""></Input>
                        </FormItem>
                        <FormItem :label="__('方法')" prop="action">
                            <Input v-model.trim="formItem.action" placeholder=""></Input>
                        </FormItem>
                        <FormItem :label="__('按钮')">
                            <i-switch v-model="formItem.button" size="large">
                                <span slot="open">{{__('是')}}</span>
                                <span slot="close">{{__('否')}}</span>
                            </i-switch>
                        </FormItem>
                        <FormItem :label="__('状态')">
                            <i-switch v-model="formItem.status" size="large">
                                <span slot="open">{{__('启用')}}</span>
                                <span slot="close">{{__('禁用')}}</span>
                            </i-switch>
                        </FormItem>
                    </Form>
                </div>
                <div class="min-form-footer">
                    <Button type="primary" :loading="loading" @click.native.prevent="handleSubmit('form')">{{__('确定')}}</Button>
                    <Button type="ghost" style="margin-left: 8px;" @click="cancelMinForm">{{__('取消')}}</Button>
                </div>
            </div>
        </div>

        <Card>
            <div slot="title">
                <Poptip
                    confirm
                    :title="__('你确认同步菜单数据吗？')"
                    @on-ok="synchrodataMenu"
                    placement="bottom-start">
                    <Button type="default" :loading="loadingSynchrodata" icon="loop">
                        <span v-if="!loadingSynchrodata">{{__('菜单数据同步')}}</span>
                        <span v-else>{{__('菜单数据同步中，请稍后')}}...</span>
                    </Button>
                </Poptip>
                <Checkbox v-model="synchrodataReplace">{{__('覆盖')}}</Checkbox>
                <Poptip trigger="hover" :title="__('帮助说明')" :content="__('系统将会自动从控制器注释中读取菜单信息并同步')" placement="right">
                    <Icon type="help-circled" class="pointer"></Icon>
                </Poptip>
            </div>
            <Button slot="extra" type="primary" @click="addMenu()"><Icon type="android-add-circle"></Icon> {{__('新增')}}</Button>
            <div>
                <Row>
                    <Col span="24">
                    <Tree :data="dataTree" ref="tree" show-checkbox multiple :render="renderContent"></Tree>
                    </Col>
                </Row>
            </div>
        </Card>
    </Row>

    <Row class="m-t-10">
        <ButtonGroup shape="circle">
            <Button type="primary" icon="eye" @click="statusMany('enable')">{{__('启用')}}</Button>
            <Button type="primary" icon="eye-disabled" @click="statusMany('disable')">{{__('禁用')}}</Button>
        </ButtonGroup>
    </Row>
</div>
</template>

<style lang="less" src="./assets/index.less"></style>
<script src="./assets/index.js"></script>
