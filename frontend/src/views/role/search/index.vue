<template>
    <div class="search-wrap">
        <Row :gutter="16">
            <i-col span="18">
                <Row :gutter="16">
                    <i-col span="8"> <i-input v-model="searchForm.key" :placeholder="__('名字') + ',' + __('编号')" clearable> </i-input> </i-col>
                    <i-col span="4">
                        <i-select v-model="searchForm.status" :placeholder="__('选择状态')" clearable @on-change="search()">
                            <i-option value="">{{ __('选择状态') }}</i-option>
                            <i-option v-for="item in searchItem.status" :key="item.value" :value="item.value">{{ item.title }}</i-option>
                        </i-select>
                    </i-col>
                    <i-col span="6">
                        <i-button type="primary" icon="ios-search" @click.native.prevent="search()" class="m-r-5">{{ __('搜索') }}</i-button>
                        <i-button type="text" icon="md-refresh" @click.native.prevent="reset()" class="m-r-5">{{ __('重置') }}</i-button>
                        <a @click="toggleShow()" style="display:none;">
                            {{ searchShow ? __('收起') : __('展开') }}
                            <Icon :type="searchShow ? __('chevron-up') : __('chevron-down')"></Icon>
                        </a>
                    </i-col>
                    <i-col span="2"></i-col>
                    <i-col span="4"></i-col>
                </Row>
                <Row v-show="searchShow" :gutter="16" class="m-t-10">
                    <i-col span="8"></i-col>
                    <i-col span="4"></i-col>
                    <i-col span="4"></i-col>
                    <i-col span="4"></i-col>
                    <i-col span="4"></i-col>
                </Row>
            </i-col>
            <i-col span="4"> &nbsp; </i-col>
            <i-col span="2" style="text-align:right">
                <i-button size="small" type="text" @click="add()" class="add-extra" :disabled="!utils.permission('role_add_button')"
                    ><Icon type="md-add-circle"></Icon> {{ __('新增') }}</i-button
                >
            </i-col>
        </Row>
    </div>
</template>

<script src="./assets/index.js"></script>
