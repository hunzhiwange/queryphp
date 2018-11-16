<template>
    <div class="rule-page">
        <Row>
            <div class="min-form" v-show="minForm">
                <div class="min-form-inner">
                    <legend>
                        {{ formItem.id ? __('编辑菜单') : __('新增菜单') }}
                    </legend>
                    <div class="min-form-body">
                        <i-form
                            ref="form"
                            :rules="rules"
                            :model="formItem"
                            :label-width="110"
                            class="w-1000"
                        >
                            <Row :gutter="16">
                                <i-col span="12">
                                    <FormItem
                                        :label="__('上级权限')"
                                        prop="pid"
                                    >
                                        <Cascader
                                            v-model="formItem.pid"
                                            :data="pidOptions"
                                            :disabled="pidDisabled"
                                            filterable
                                            change-on-select
                                            @on-change="changeParentId"
                                        ></Cascader>
                                    </FormItem>
                                    <FormItem
                                        :label="__('权限类型')"
                                        prop="type"
                                    >
                                        <RadioGroup v-model="formItem.type">
                                            <Radio
                                                label="app"
                                                :disabled="this.typeDisabled"
                                                >{{ __('应用') }}</Radio
                                            >
                                            <Radio
                                                label="category"
                                                :disabled="this.typeDisabled"
                                                >{{ __('权限分组') }}</Radio
                                            >
                                            <Radio
                                                label="rule"
                                                :disabled="this.typeDisabled"
                                                >{{ __('权限') }}</Radio
                                            >
                                        </RadioGroup>
                                    </FormItem>
                                    <FormItem :label="__('应用')" prop="app">
                                        <i-input
                                            v-model.trim="formItem.app"
                                            placeholder=""
                                        ></i-input>
                                    </FormItem>
                                    <FormItem :label="__('标题')" prop="title">
                                        <i-input
                                            v-model.trim="formItem.title"
                                            placeholder=""
                                        ></i-input>
                                    </FormItem>
                                    <FormItem :label="__('名称')" prop="name">
                                        <i-input
                                            v-model.trim="formItem.name"
                                            placeholder=""
                                        ></i-input>
                                    </FormItem>
                                    <FormItem :label="__('状态')">
                                        <i-switch
                                            v-model="formItem.status"
                                            size="large"
                                        >
                                            <span slot="open">{{
                                                __('启用')
                                            }}</span>
                                            <span slot="close">{{
                                                __('禁用')
                                            }}</span>
                                        </i-switch>
                                    </FormItem>
                                </i-col>
                                <i-col span="12">
                                    <FormItem
                                        :label="__('权限')"
                                        prop="value"
                                        v-show="showMenuTree"
                                    >
                                        <Card>
                                            <div class="rule-box">
                                                <Tree
                                                    ref="menuTree"
                                                    :data="dataMenuTree"
                                                    show-checkbox
                                                ></Tree>
                                            </div>
                                        </Card>
                                    </FormItem>
                                </i-col>
                            </Row>
                        </i-form>
                    </div>
                    <div class="min-form-footer">
                        <i-button
                            type="primary"
                            :loading="loading"
                            @click.native.prevent="handleSubmit('form');"
                            >{{ __('确定') }}</i-button
                        >
                        <i-button
                            type="ghost"
                            style="margin-left: 8px;"
                            @click="cancelMinForm('form');"
                            >{{ __('取消') }}</i-button
                        >
                    </div>
                </div>
            </div>

            <Card>
                <div slot="title">
                    <Poptip
                        confirm
                        :title="__('你确认同步菜单数据吗？')"
                        @on-ok="synchrodataMenu"
                        placement="bottom-start"
                    >
                        <i-button
                            type="default"
                            :loading="loadingSynchrodata"
                            icon="loop"
                        >
                            <span v-if="!loadingSynchrodata">{{
                                __('菜单数据同步')
                            }}</span>
                            <span v-else
                                >{{ __('菜单数据同步中，请稍后') }}...</span
                            >
                        </i-button>
                    </Poptip>
                    <Checkbox v-model="synchrodataReplace">{{
                        __('覆盖')
                    }}</Checkbox>
                    <Poptip
                        trigger="hover"
                        :title="__('帮助说明')"
                        :content="
                            __('系统将会自动从控制器注释中读取菜单信息并同步')
                        "
                        placement="right"
                    >
                        <Icon type="help-circled" class="pointer"></Icon>
                    </Poptip>
                </div>
                <i-button slot="extra" type="primary" @click="addMenu();"
                    ><Icon type="android-add-circle"></Icon>
                    {{ __('新增') }}</i-button
                >
                <div>
                    <Row>
                        <i-col span="24">
                            <Tree
                                :data="dataTree"
                                ref="tree"
                                show-checkbox
                                multiple
                                :render="renderContent"
                                class="main-tree"
                            ></Tree>
                        </i-col>
                    </Row>
                </div>
            </Card>
        </Row>

        <Row class="m-t-10">
            <ButtonGroup shape="circle">
                <i-button
                    type="primary"
                    icon="eye"
                    @click="statusMany('enable');"
                    >{{ __('启用') }}</i-button
                >
                <i-button
                    type="primary"
                    icon="eye-disabled"
                    @click="statusMany('disable');"
                    >{{ __('禁用') }}</i-button
                >
            </ButtonGroup>
        </Row>
    </div>
</template>

<style lang="less" src="./assets/index.less"></style>
<script src="./assets/index.js"></script>
