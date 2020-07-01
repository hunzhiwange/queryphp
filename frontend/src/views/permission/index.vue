<template>
    <div class="body" id="permission-page">
        <div class="min-form" v-show="minForm">
            <Card :bordered="false">
                <p slot="title">
                    {{ formItem.id ? __('编辑权限') : __('新增权限') }}
                </p>
                <div class="min-form-inner">
                    <div class="min-form-body">
                        <i-form ref="form" :rules="rules" :model="formItem" :label-width="130" class="w-1000">
                            <Row :gutter="16">
                                <i-col span="12">
                                    <FormItem :label="__('上级权限')" prop="pid">
                                        <Cascader
                                            v-model="formItem.pid"
                                            :data="pidOptions"
                                            :disabled="pidDisabled"
                                            filterable
                                            change-on-select
                                        ></Cascader>
                                    </FormItem>
                                    <FormItem :label="__('状态')">
                                        <i-switch
                                            v-model="formItem.status"
                                            size="large"
                                            :true-value="1"
                                            :false-value="0"
                                        >
                                            <span slot="open">{{ __('启用') }}</span>
                                            <span slot="close">{{ __('禁用') }}</span>
                                        </i-switch>
                                    </FormItem>
                                </i-col>
                                <i-col span="12">
                                    <FormItem :label="__('名字')" prop="name">
                                        <i-input v-model.trim="formItem.name" placeholder=""></i-input>
                                    </FormItem>
                                    <FormItem :label="__('编号')" prop="num">
                                        <i-input v-model.trim="formItem.num" placeholder=""> </i-input>
                                    </FormItem>
                                </i-col>
                            </Row>
                        </i-form>
                    </div>
                    <div class="min-form-footer">
                        <i-button type="primary" :loading="loading" @click.native.prevent="handleSubmit('form')">{{
                            __('确定')
                        }}</i-button>
                        <i-button style="margin-left: 8px;" @click="cancelMinForm('form')">{{ __('取消') }}</i-button>
                    </div>
                </div>
            </Card>
        </div>
        <Card shadow>
            <div slot="title">
                <i-button
                    size="small"
                    type="text"
                    @click="add()"
                    class="add-extra"
                    :disabled="!utils.permission('permission_add_button')"
                    ><Icon type="md-add-circle"></Icon> {{ __('新增') }}</i-button
                >
            </div>
            <div class="tree-for-list">
                <Row>
                    <i-col span="24">
                        <Tree :data="dataTree" ref="tree" show-checkbox2 multiple :render="renderContent"></Tree>
                    </i-col>
                </Row>
            </div>
        </Card>

        <!--<Row class="m-t-10">
            <ButtonGroup shape="circle">
                <i-button type="primary" icon="md-eye" @click="statusMany('enable')">{{ __('启用') }}</i-button>
                <i-button type="primary" icon="md-eye-off" @click="statusMany('disable')">{{ __('禁用') }}</i-button>
            </ButtonGroup>
        </Row>-->

        <Drawer
            :title="viewDetail.name + ' ' + __('资源授权')"
            v-model="rightForm"
            width="800"
            :mask-closable="false"
            :styles="styles"
        >
            <i-form ref="formResource" :model="formResource">
                <Row :gutter="32">
                    <i-col span="24">
                        <FormItem :label="__('请输入资源关键字')" label-position="top">
                            <i-select
                                v-model="selectResource"
                                multiple
                                filterable
                                remote
                                :remote-method="searchResource"
                                @on-change="changeResource"
                                :loading="loadingResource"
                            >
                                <i-option
                                    v-for="r in resources"
                                    :value="r.id + '``' + r.name + '|' + r.num"
                                    :key="r.id"
                                    :label="r.name"
                                >
                                    <span :class="r.status ? '' : 'item-removed'">{{ r.name }}</span>
                                    <span class="resource-text">{{ r.num }}</span>
                                </i-option>
                            </i-select>
                        </FormItem>
                    </i-col>
                    <i-col span="24"> </i-col>
                </Row>
            </i-form>
            <div class="demo-drawer-footer">
                <i-button style="margin-right: 8px" @click="rightForm = false">{{ __('取消') }}</i-button>
                <i-button
                    type="primary"
                    :loading="loading"
                    @click.native.prevent="handleResourceSubmit('formResource')"
                    >{{ __('确定') }}</i-button
                >
            </div>
        </Drawer>
    </div>
</template>

<style lang="less" src="./assets/index.less"></style>
<script src="./assets/index.js"></script>
