<template>
<div class="position-category-page">
    <Row>
        <div class="min-form" v-show="minForm">
            <div class="min-form-inner">
                <legend>{{formItem.id ? __('编辑职位分类') : __('新增职位分类')}}</legend>
                <div class="min-form-body">
                    <Form ref="form" :rules="rules" :model="formItem" :label-width="110" class="w-1000">
                        <Row :gutter="16">
                            <Col span="12">

                                <FormItem :label="__('名字')" prop="name">
                                    <Input v-model.trim="formItem.name" placeholder=""></Input>
                                </FormItem>
                                 <FormItem :label="__('备注')">
                                    <Input v-model="formItem.remark" type="textarea" :autosize="{minRows: 2,maxRows: 5}" placeholder=""></Input>
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
                    <Button vtype="primary" :loading="loading" @click.native.prevent="handleSubmit('form')">{{__('确定')}}</Button>
                    <Button type="ghost" style="margin-left: 8px;" @click="cancelMinForm('form')">{{__('取消')}}</Button>
                </div>
            </div>
        </div>

        <Row>
            <Col span="24">
                <Table stripe :loading="loadingTable" border ref="table" :border="false" :columns="columns" :data="data" class="search-table" :height="tableHeight" >
                    <div slot="header">
                        <search @getDataFromSearch="getDataFromSearch" @add="add"></search>
                    </div>
                </Table>
            </Col>
        </Row>
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
