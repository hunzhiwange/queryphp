<template>
<div class="header">
    <div class="table-box" style="display: table;">
        <div class="table-cell">
            <Form class="search" ref="searchForm" :model="searchForm" :rules="searchRule" inline>
                <FormItem>
                    <Select v-model="searchForm.status" style="width:120px" :placeholder="__('选择状态')" clearable @on-change="search('searchForm')">
                        <Option value="">{{__('选择状态')}}</Option>
                        <Option v-for="item in searchItem.status" :key="item.status" :value="item.status">{{item.title}}</Option>
                    </Select>
                </FormItem>
                <FormItem class="search-key">
                    <Input v-model="searchForm.key" @on-change="search('searchForm')" :placeholder="__('名字')">
                        <em slot="prepend"></em>
                        <Button slot="append" icon="android-search" @click.native.prevent="search('searchForm')"></Button>
                    </Input>
                </FormItem>
            </Form>
        </div>
        <div class="table-cell tx-r btn-drop-box" id="pLsitHeader">
            <Button size="small" type="text" @click="add()" class="add-extra"><Icon type="android-add-circle"></Icon> {{__('新增')}}</Button>
        </div>
    </div>
</div>
</template>

<script src="./assets/index.js"></script>
