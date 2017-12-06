<template>
<div class="menu-page">
    <Row>
        <div class="min-form" v-show="minForm">
            <div class="min-form-inner">
                <legend>{{formItem.id ? __('编辑菜单') : __('新增菜单')}}</legend>
                <div class="min-form-body">
                    <Form ref="form" :rules="rules" :model="formItem" :label-width="110" class="w-600">
                        <FormItem :label="__('标题')" prop="title">
                            <Input v-model.trim="formItem.title" placeholder=""></Input>
                        </FormItem>
                        <FormItem :label="__('上级菜单')" prop="pid">
                            <Cascader v-model="formItem.pid" :data="pidOptions" :disabled="pidDisabled" filterable change-on-select></Cascader>
                        </FormItem>
                        <FormItem :label="__('菜单类型')" prop="menu_type">
                            <RadioGroup v-model="formItem.menu_type">
                                <Radio label="1">{{__('普通三级菜单')}}</Radio>
                                <Radio label="2">{{__('单页菜单')}}</Radio>
                                <Radio label="3">{{__('外链')}}</Radio>
                            </RadioGroup>
                        </FormItem>
                        <FormItem :label="__('路径')" prop="url">
                            <Input v-model.trim="formItem.url" placeholder=""></Input>
                        </FormItem>
                        <FormItem :label="__('模块')" prop="module">
                            <Input v-model.trim="formItem.module" placeholder=""></Input>
                        </FormItem>
                        <FormItem :label="__('所属菜单')" prop="menu">
                            <Input v-model.trim="formItem.menu" placeholder=""></Input>
                        </FormItem>
                        <FormItem :label="__('图标')" prop="menu_icon">
                            <Input v-model.trim="formItem.menu_icon" placeholder=""></Input>
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
            <p slot="title">
                {{__('菜单管理')}}
            </p>
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
