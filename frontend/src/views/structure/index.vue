<template>
<div class="structure-page">
    <Row>
        <div class="min-form" v-show="minForm">
            <div class="min-form-inner">
                <legend>{{formItem.id ? __('编辑组织') : __('新增组织')}}</legend>
                <div class="min-form-body">
                    <Form ref="form" :rules="rules" :model="formItem" :label-width="110" class="w-1000">
                        <Row :gutter="16">
                            <Col span="12">
                                <FormItem :label="__('上级组织')" prop="pid">
                                    <Cascader v-model="formItem.pid" :data="pidOptions" :disabled="pidDisabled" filterable change-on-select></Cascader>
                                </FormItem>
                                <FormItem :label="__('组织名字')" prop="name">
                                    <Input v-model.trim="formItem.name" placeholder=""></Input>
                                </FormItem>
                                <FormItem :label="__('状态')">
                                    <i-switch v-model="formItem.status" size="large">
                                        <span slot="open">{{__('启用')}}</span>
                                        <span slot="close">{{__('禁用')}}</span>
                                    </i-switch>
                                </FormItem>
                            </Col>
                            <Col span="12">
                            </Col>
                        </Row>
                    </Form>
                </div>
                <div class="min-form-footer">
                    <Button type="primary" :loading="loading" @click.native.prevent="handleSubmit('form')">{{__('确定')}}</Button>
                    <Button type="ghost" style="margin-left: 8px;" @click="cancelMinForm('form')">{{__('取消')}}</Button>
                </div>
            </div>
        </div>

        <Card>
            <div slot="title">
                <Poptip trigger="hover" :title="__('帮助说明')" :content="__('公司整个部门的组织结构')" placement="right">
                    <Icon type="help-circled" class="pointer"></Icon>
                </Poptip>
            </div>
            <Button size="small" slot="extra" type="text" @click="add()" class="add-extra"><Icon type="android-add-circle"></Icon> {{__('新增')}}</Button>
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
