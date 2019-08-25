<template>
    <div class="body">
        <div class="min-form" v-show="minForm">
            <Card :bordered="false">
                <p slot="title">{{ formItem.id ? __('编辑角色') : __('新增角色') }}</p>
                <div class="min-form-inner">
                    <div class="min-form-body">
                        <i-form ref="form" :rules="rules" :model="formItem" :label-width="110" class="w-1000">
                            <Row :gutter="16">
                                <i-col span="12">
                                    <FormItem :label="__('名字')" prop="name"> <i-input v-model.trim="formItem.name" placeholder=""></i-input> </FormItem>
                                    <FormItem :label="__('编号')" prop="num">
                                        <i-input v-model.trim="formItem.num" placeholder=""> </i-input>
                                    </FormItem>
                                    <FormItem :label="__('状态')">
                                        <i-switch v-model="formItem.status" size="large" :true-value="1" :false-value="0">
                                            <span slot="open">{{ __('启用') }}</span> <span slot="close">{{ __('禁用') }}</span>
                                        </i-switch>
                                    </FormItem>
                                </i-col>
                                <i-col span="12"> </i-col>
                            </Row>
                        </i-form>
                    </div>
                    <div class="min-form-footer">
                        <i-button type="primary" :loading="loading" @click.native.prevent="handleSubmit('form')">{{ __('确定') }}</i-button>
                        <i-button style="margin-left: 8px;" @click="cancelMinForm('form')">{{ __('取消') }}</i-button>
                    </div>
                </div>
            </Card>
        </div>

        <div class="wrap">
            <div class="fixed-footer-offset">
                <Row>
                    <i-col span="24">
                        <search ref="search" @getDataFromSearch="getDataFromSearch" @add="add"></search>

                        <i-table
                            stripe
                            :loading="loadingTable"
                            ref="table"
                            :border="false"
                            :columns="columns"
                            :data="data"
                            class="search-table"
                            :height="tableHeight"
                            @on-selection-change="onSelectionChange"
                        >
                        </i-table>
                    </i-col>
                </Row>
            </div>
        </div>
        <div class="fixed-footer">
            <Row justify="end">
                <i-col span="8">
                    <ButtonGroup shape="circle">
                        <i-button type="primary" icon="md-eye" @click="statusMany('1')" :disabled="!utils.permission('role_status_button')">{{
                            __('启用')
                        }}</i-button>
                        <i-button type="primary" icon="md-eye-off" @click="statusMany('0')" :disabled="!utils.permission('role_status_button')">{{
                            __('禁用')
                        }}</i-button>
                    </ButtonGroup>
                </i-col>
                <i-col span="16" class-name="fr">
                    <Page class="fr" :total="total" show-sizer @on-change="changePage" @on-page-size-change="changePageSize"></Page>
                </i-col>
            </Row>
        </div>

        <Drawer :title="viewDetail.name + ' 授权'" v-model="rightForm" width="800" :mask-closable="false" :styles="styles">
            <i-form ref="formPermission" :model="formPermission">
                <Row :gutter="32">
                    <i-col span="24">
                        <FormItem label="请选择权限" label-position="top">
                            <div class="tree-for-role">
                                <Tree :data="dataTree" ref="tree" show-checkbox multiple :render="renderContent"></Tree>
                            </div>
                        </FormItem>
                    </i-col>
                </Row>
            </i-form>
            <div class="demo-drawer-footer">
                <i-button style="margin-right: 8px" @click="rightForm = false">取消</i-button>
                <i-button type="primary" :loading="loading" @click.native.prevent="handlePermissionSubmit('formPermission')">确定</i-button>
            </div>
        </Drawer>
    </div>
</template>

<style lang="less" src="./assets/index.less"></style>
<script src="./assets/index.js"></script>
