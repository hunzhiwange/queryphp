<template>
    <div class="body">
        <div class="min-form" v-show="minForm">
            <Card :bordered="false">
                <p slot="title">
                    {{ __('新增项目') }}
                </p>
                <div class="min-form-inner">
                    <div class="min-form-body">
                        <i-form ref="form" :rules="rules" :model="formItem" :label-width="110" class="w-1000">
                            <Row :gutter="16">
                                <i-col span="12">
                                    <FormItem :label="__('名字')" :prop="formItem.id ? '' : 'name'">
                                        <i-input
                                            v-model.trim="formItem.name"
                                            placeholder=""
                                            :disabled="formItem.id ? true : false"
                                        ></i-input>
                                    </FormItem>
                                    <FormItem :label="__('项目模板')">
                                        <Select v-model="seletedProjectTemplate">
                                            <Option v-for="item in projectTemplate" :value="item.key" :key="item.key">{{ item.title }}</Option>
                                        </Select>
                                        <div class="m-t-20" style="height:200px;overflow:auto;">
                                            <Steps :current="0" direction="vertical">
                                                <Step v-for="item in seletedProjectTemplateData.data" :value="item.tag" :key="item.tag" :title="item.title" :content="item.description"></Step>
                                            </Steps>
                                        </div>
                                    </FormItem>
                                </i-col>
                                <i-col span="12">
                                    <FormItem :label="__('编号')" prop="num">
                                        <i-input v-model="formItem.num" placeholder=""></i-input>
                                    </FormItem>
                                    <FormItem :label="__('状态')">
                                        <i-switch
                                            v-model="formItem.status"
                                            size="large"
                                            :true-value=1
                                            :false-value=0
                                        >
                                            <span slot="open">{{ __('启用') }}</span>
                                            <span slot="close">{{ __('禁用') }}</span>
                                        </i-switch>
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

        <div class="min-form" v-show="minUser">
            <Card :bordered="false">
                <p slot="title">
                    {{ __('项目用户') }}
                </p>
                <a slot="extra">
                    <i-button
                    size="small"
                    type="text"
                    @click="addUser"
                    class="add-extra"
                    v-if="utils.permission('resource_add_button')"
                    ><Icon type="md-add-circle"></Icon> {{ __('新增') }}</i-button>
                </a>
                <div class="min-form-inner__">
                    <div class="m-b-10">
                        <Row :gutter="16">
                            <i-col span="6">
                                <i-input @on-search="searchUser()" search v-model="searchUserForm.key" :placeholder="'ID,'+__('名字') + ',' + __('编号')" clearable>
                                </i-input>
                            </i-col>
                            <i-col span="6">
                                <i-button type="primary" icon="ios-search" @click.native.prevent="searchUser()" class="m-r-5">{{
                                    __('搜索')
                                }}</i-button>
                                <i-button type="text" icon="md-refresh" @click.native.prevent="resetUser()" class="m-r-5">{{
                                    __('重置')
                                }}</i-button>
                            </i-col>
                        </Row>
                    </div>
                    <div class="min-form-body__">
                        <Table :columns="userColumns" :data="userData" :loading="loadingUserTable"></Table>
                    </div>
                    <div class="m-t-20">
                        <Row>
                            <Col span="18">
                                <Page
                                    :total="userTotal"
                                    :current="userPage"
                                    :page-size="userPageSize"
                                />
                            </Col>
                            <Col span="6">
                                <i-button class="fr" style="margin-left: 8px;" @click="cancelMinUser()">{{ __('关闭') }}</i-button>
                            </Col>
                        </Row>
                    </div>
                </div>
            </Card>
        </div>

        <div class="wrap">
            <div class="fixed-footer-offset">
                <Row>
                    <i-col span="24">
                        <search ref="search" @getDataFromSearch="getDataFromSearch" @getProjectFavorDataFromSearch="getProjectFavorDataFromSearch" @add="add"></search>
                        <i-table
                            stripe
                            :loading="loadingTable"
                            ref="table"
                            :border="false"
                            :columns="columns"
                            :data="data"
                            class="search-table"
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
                        <i-button
                            type="primary"
                            icon="md-eye"
                            @click="statusMany(1)"
                            v-if="utils.permission('project_status_button')"
                            >{{ __('启用') }}</i-button
                        >
                        <i-button
                            type="primary"
                            icon="md-eye-off"
                            @click="statusMany(0)"
                            v-if="utils.permission('project_status_button')"
                            >{{ __('禁用') }}</i-button
                        >
                    </ButtonGroup>
                </i-col>
                <i-col span="16" class-name="fr">
                    <Page
                        class="fr"
                        :total="total"
                        :current="page"
                        :page-size="pageSize"
                        show-sizer
                        @on-change="changePage"
                        @on-page-size-change="changePageSize"
                    ></Page>
                </i-col>
            </Row>
        </div>
        <Drawer
            :title="viewDetail.name + ' ' + __('添加用户')"
            v-model="rightForm"
            width="800"
            :mask-closable="false"
            :styles="styles"
        >
            <i-form ref="formCommonUser" :rules="commonUserRules" :model="formCommonUser">
                <Row :gutter="32">
                    <i-col span="24">
                        <FormItem :label="__('请输入用户关键字')" label-position="top" prop="selectUser">
                            <i-select
                                v-model="formCommonUser.selectUser"
                                multiple
                                filterable
                                remote
                                :remote-method="searchCommonUser"
                                @on-change="changeCommonUser"
                                :loading="loadingCommonUser"
                            >
                                <i-option
                                    v-for="r in commonUsers"
                                    :value="r.id"
                                    :key="r.id"
                                    :label="r.name"
                                >
                                    <span>{{ r.name }}</span>
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
                    @click.native.prevent="handleAddUserSubmit('formCommonUser')"
                    >{{ __('确定') }}</i-button
                >
            </div>
        </Drawer>
    </div>
</template>

<script src="./assets/index.js"></script>
