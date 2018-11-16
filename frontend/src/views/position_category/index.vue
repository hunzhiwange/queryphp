<template>
    <div id="resource-page">
        <Row>
            <div class="min-form" v-show="minForm">
                <div class="min-form-inner">
                    <legend>
                        {{
                            formItem.id
                                ? __('编辑职位分类')
                                : __('新增职位分类')
                        }}
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
                                    <FormItem :label="__('名字')" prop="name">
                                        <i-input
                                            v-model.trim="formItem.name"
                                            placeholder=""
                                        ></i-input>
                                    </FormItem>
                                    <FormItem :label="__('备注')">
                                        <i-input
                                            v-model="formItem.remark"
                                            type="textarea"
                                            :autosize="{minRows: 2, maxRows: 5}"
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
                                <i-col span="12"> </i-col>
                            </Row>
                        </i-form>
                    </div>
                    <div class="min-form-footer">
                        <i-button
                            vtype="primary"
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

            <Row>
                <i-col span="24">
                    <div
                        style="    position: relative;
    max-height: 100%;
    overflow: auto;"
                    >
                        <i-table
                            stripe
                            :loading="loadingTable"
                            border
                            ref="table"
                            :border="false"
                            :columns="columns"
                            :data="data"
                            class="search-table"
                            :height="tableHeight"
                        >
                            <div slot="header">
                                <search
                                    @getDataFromSearch="getDataFromSearch"
                                    @add="add"
                                ></search>
                            </div>
                        </i-table>
                    </div>
                </i-col>
            </Row>
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
