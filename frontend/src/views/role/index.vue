<template>
    <div class="position-category-page">
        <Row>
            <div class="min-form" v-show="minForm">
                <div class="min-form-inner">
                    <legend>
                        {{ formItem.id ? __('编辑角色') : __('新增角色') }}
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
                                    <FormItem :label="__('标识符')">
                                        <i-input
                                            v-model="formItem.identity"
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
                                            <span slot="true">{{
                                                __('启用')
                                            }}</span>
                                            <span slot="false">{{
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
                            @click.native.prevent="handleSubmit('form')"
                            >{{ __('确定') }}</i-button
                        >
                        <i-button
                            type="ghost"
                            style="margin-left: 8px;"
                            @click="cancelMinForm('form')"
                            >{{ __('取消') }}</i-button
                        >
                    </div>
                </div>
            </div>

            <Row>
                <i-col span="24">
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
                        @on-selection-change="onSelectionChange"
                    >
                        <div slot="header">
                            <search
                                ref="search"
                                @getDataFromSearch="getDataFromSearch"
                                @add="add"
                            ></search>
                        </div>
                    </i-table>
                </i-col>
            </Row>
        </Row>

        <Row class="m-t-10" justify="end">
            <i-col span="8">
                <ButtonGroup shape="circle">
                    <i-button
                        type="primary"
                        icon="eye"
                        @click="statusMany('1')"
                        >{{ __('启用') }}</i-button
                    >
                    <i-button
                        type="primary"
                        icon="eye-disabled"
                        @click="statusMany('0')"
                        >{{ __('禁用') }}</i-button
                    >
                </ButtonGroup>
            </i-col>
            <i-col span="8" offset="8" class-name="fr">
                <Page
                    :total="total"
                    show-sizer
                    @on-change="changePage"
                    @on-page-size-change="changePageSize"
                ></Page>
            </i-col>
        </Row>
    </div>
</template>

<style lang="less" src="./assets/index.less"></style>
<script src="./assets/index.js"></script>
