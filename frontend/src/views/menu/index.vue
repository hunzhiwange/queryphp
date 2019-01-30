<template>
    <div class="menu-page">
        <Row>
            <div class="min-form" v-show="minForm">
                <div class="min-form-inner">
                    <legend>
                        {{ formItem.id ? __('编辑菜单') : __('新增菜单') }}
                    </legend>
                    <div class="min-form-body">
                        <i-form ref="form" :rules="rules" :model="formItem" :label-width="110" class="w-1000">
                            <Row :gutter="16">
                                <i-col span="12">
                                    <FormItem :label="__('上级菜单')" prop="pid">
                                        <Cascader
                                            v-model="formItem.pid"
                                            :data="pidOptions"
                                            :disabled="pidDisabled"
                                            filterable
                                            change-on-select
                                            @on-change="changeParentId"
                                        ></Cascader>
                                    </FormItem>
                                    <FormItem :label="__('菜单类型')" prop="type">
                                        <RadioGroup v-model="formItem.type">
                                            <Radio label="app" :disabled="this.typeDisabled">{{ __('应用') }}</Radio>
                                            <Radio label="category" :disabled="this.typeDisabled">{{ __('控制器分组') }}</Radio>
                                            <Radio label="controller" :disabled="this.typeDisabled">{{ __('控制器') }}</Radio>
                                            <Radio label="action" :disabled="this.typeDisabled">{{ __('方法') }}</Radio>
                                        </RadioGroup>
                                    </FormItem>
                                    <FormItem :label="__('应用')" prop="app">
                                        <i-input v-model.trim="formItem.app" placeholder=""></i-input>
                                    </FormItem>
                                    <FormItem :label="__('控制器')" prop="controller" v-show="showController">
                                        <i-input v-model.trim="formItem.controller" placeholder=""></i-input>
                                    </FormItem>
                                    <FormItem :label="__('方法')" prop="action" v-show="showAction">
                                        <i-input v-model.trim="formItem.action" placeholder=""></i-input>
                                    </FormItem>
                                    <FormItem :label="__('兄弟方法')" prop="siblings" v-show="showSiblings">
                                        <i-select v-model="siblings" multiple placement="top">
                                            <i-option v-for="item in siblingsList" :value="item.id" :key="item.id">{{ item.title }}</i-option>
                                        </i-select>
                                    </FormItem>
                                    <FormItem :label="__('方法权限')" v-show="showRule">
                                        <RadioGroup v-model="formItem.rule">
                                            <Radio label="T">{{ __('是') }}</Radio>
                                            <Radio label="F">{{ __('否') }}</Radio>
                                        </RadioGroup>
                                    </FormItem>
                                    <FormItem :label="__('状态')">
                                        <i-switch v-model="formItem.status" size="large">
                                            <span slot="open">{{ __('启用') }}</span>
                                            <span slot="close">{{ __('禁用') }}</span>
                                        </i-switch>
                                    </FormItem>
                                </i-col>
                                <i-col span="12">
                                    <FormItem :label="__('路由标题')" prop="title">
                                        <i-input v-model.trim="formItem.title" placeholder=""></i-input>
                                    </FormItem>
                                    <FormItem :label="__('路由名称')" prop="name">
                                        <i-input v-model.trim="formItem.name" placeholder=""></i-input>
                                    </FormItem>
                                    <FormItem :label="__('路由路径')" prop="path">
                                        <i-input v-model.trim="formItem.path" placeholder=""></i-input>
                                    </FormItem>
                                    <FormItem :label="__('路由组件')" prop="component">
                                        <i-input v-model.trim="formItem.component" placeholder=""></i-input>
                                    </FormItem>
                                    <FormItem :label="__('路由图标')" prop="icon">
                                        <i-input v-model.trim="formItem.icon" placeholder=""></i-input>
                                    </FormItem>
                                </i-col>
                            </Row>
                        </i-form>
                    </div>
                    <div class="min-form-footer">
                        <i-button type="primary" :loading="loading" @click.native.prevent="handleSubmit('form')">{{ __('确定') }}</i-button>
                        <i-button style="margin-left: 8px;" @click="cancelMinForm('form')">{{ __('取消') }}</i-button>
                    </div>
                </div>
            </div>

            <Card>
                <div slot="title">
                    <Poptip confirm :title="__('你确认同步菜单数据吗？')" @on-ok="synchrodataMenu" placement="bottom-start">
                        <i-button type="primary" :loading="loadingSynchrodata" icon="loop">
                            <span v-if="!loadingSynchrodata">{{ __('菜单数据同步') }}</span>
                            <span v-else>{{ __('菜单数据同步中，请稍后') }}...</span>
                        </i-button>
                    </Poptip>
                    <Checkbox v-model="synchrodataReplace" class="synchrodata-replace">{{ __('覆盖') }}</Checkbox>
                    <Poptip trigger="hover" :title="__('帮助说明')" :content="__('系统将会自动从控制器注释中读取菜单信息并同步')" placement="right">
                        <Icon type="help-circled" class="pointer"></Icon>
                    </Poptip>
                </div>
                <a href="javascript:void(0);" slot="extra" @click="add()" class="add-extra">
                    <Icon type="android-add-circle"></Icon>
                    {{ __('新增') }}
                </a>
                <div>
                    <Row>
                        <i-col span="24">
                            <Tree :data="dataTree" ref="tree" show-checkbox multiple :render="renderContent"></Tree>
                        </i-col>
                    </Row>
                </div>
            </Card>
        </Row>

        <Row class="m-t-10">
            <ButtonGroup shape="circle">
                <i-button type="primary" icon="md-eye" @click="statusMany('enable')">{{ __('启用') }}</i-button>
                <i-button type="primary" icon="md-eye-off" @click="statusMany('disable')">{{ __('禁用') }}</i-button>
            </ButtonGroup>
        </Row>
    </div>
</template>

<style lang="less" src="./assets/index.less"></style>
<script src="./assets/index.js"></script>
