<template>
    <div class="search-wrap">
        <Row :gutter="16">
            <Col span="18">
                <Row :gutter="16">
                    <Col span="8">
                        <Input v-model="searchForm.key" :placeholder="__('关键字')" clearable>
                        </Input>
                    </Col>
                    <Col span="4">
                        <i-select
                            v-model="searchForm.status"
                            style="width:120px"
                            :placeholder="__('选择状态')"
                            clearable
                            @on-change="search()"
                        >
                            <i-option value="">{{ __('选择状态') }}</i-option>
                            <i-option
                                v-for="item in searchItem.status"
                                :key="item.status"
                                :value="item.status"
                                >{{ item.title }}</i-option
                            >
                        </i-select>
                    </Col>
                    <Col span="4"></Col>
                    <Col span="4"></Col>
                    <Col span="4"></Col>
                </Row>
                <Row v-show="searchShow" :gutter="16" class="m-t-10">
                    <Col span="8"></Col>
                    <Col span="4"></Col>
                    <Col span="4"></Col>
                    <Col span="4"></Col>
                    <Col span="4"></Col>
                </Row>
            </Col>
            <Col span="4">
                <Button type="primary" icon="ios-search" @click.native.prevent="search()" class="m-r-5">搜索</Button>
                <Button type="ghost" icon="refresh" @click.native.prevent="reset()" class="m-r-5">重置</Button>
                <a @click="toggleShow()" style="display:none;">
                    {{ searchShow ? __('收起') : __('展开') }} <Icon :type="( searchShow ? __('chevron-up') : __('chevron-down') )"></Icon>
                </a>
            </Col>
            <Col span="2" style="text-align:right">
                <i-button
                    size="small"
                    type="text"
                    @click="add()"
                    class="add-extra"
                    ><Icon type="android-add-circle"></Icon>
                    {{ __('新增') }}</i-button
                >
            </Col>
        </Row>
    </div>
</template>

<script src="./assets/index.js"></script>
