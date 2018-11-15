<template>
<div class="position-category-page">
    <Row>
        <div class="min-form" v-show="minForm">
            <div class="min-form-inner">
                <legend>{{formItem.id ? __('编辑资源') : __('新增资源')}}</legend>
                <div class="min-form-body">
                    <Form ref="form" :rules="rules" :model="formItem" :label-width="110" class="w-1000">
                        <Row :gutter="16">
                            <Col span="12">

                                <FormItem :label="__('名字')" prop="name">
                                    <Input v-model.trim="formItem.name" placeholder=""></Input>
                                </FormItem>
                                 <FormItem :label="__('标识符')">
                                    <Input v-model="formItem.identity" type="textarea" :autosize="{minRows: 2,maxRows: 5}" placeholder=""></Input>
                                </FormItem>
                                <FormItem :label="__('状态')">
                                    <i-switch v-model="formItem.status" size="large">
                                        <span slot="true">{{__('启用')}}</span>
                                        <span slot="false">{{__('禁用')}}</span>
                                    </i-switch>
                                </FormItem>
                            </Col>
                            <Col span="12">
                            </Col>
                        </Row>
                    </Form>
                </div>
                <div class="min-form-footer">
                    <Button vtype="primary" :loading="loading" @click.native.prevent="handleSubmit('form')">{{__('确定')}}</Button>
                    <Button type="ghost" style="margin-left: 8px;" @click="cancelMinForm('form')">{{__('取消')}}</Button>
                </div>
            </div>
        </div>

        <Row>
            <Col span="24">
                <Table stripe :loading="loadingTable" border ref="table" :border="false" :columns="columns" :data="data" class="search-table" :height="tableHeight" @on-selection-change="onSelectionChange">
                    <div slot="header">
                        <search ref="search" @getDataFromSearch="getDataFromSearch" @add="add"></search>
                    </div>
                </Table>
            </Col>
        </Row>
    </Row>

    <Row class="m-t-10" justify="end">
        <Col span="8">
            <ButtonGroup shape="circle">
                <Button type="primary" icon="eye" @click="statusMany('1')">{{__('启用')}}</Button>
                <Button type="primary" icon="eye-disabled" @click="statusMany('0')">{{__('禁用')}}</Button>
            </ButtonGroup>
        </Col>
        <Col span="8" offset="8" class-name="fr">
            <Page :total="total" show-sizer @on-change="changePage" @on-page-size-change="changePageSize"></Page>
        </Col>
    </Row>
</div>
</template>

<style lang="less" src="./assets/index.less"></style>
<script src="./assets/index.js"></script>
