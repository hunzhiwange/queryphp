<template>
    <div class="header">
        <div class="table-box" style="display: table;">
            <div class="table-cell">
                <i-form
                    class="search"
                    ref="searchForm"
                    :model="searchForm"
                    :rules="searchRule"
                    inline
                >
                    <FormItem>
                        <i-select
                            v-model="searchForm.status"
                            style="width:120px"
                            :placeholder="__('选择状态')"
                            clearable
                            @on-change="search('searchForm')"
                        >
                            <i-option value="">{{ __('选择状态') }}</i-option>
                            <i-option
                                v-for="item in searchItem.status"
                                :key="item.status"
                                :value="item.status"
                                >{{ item.title }}</i-option
                            >
                        </i-select>
                    </FormItem>
                    <FormItem class="search-key">
                        <i-input
                            v-model="searchForm.key"
                            @on-change="search('searchForm')"
                            :placeholder="__('名字')"
                        >
                            <em slot="prepend"></em>
                            <i-button
                                slot="append"
                                icon="android-search"
                                @click.native.prevent="search('searchForm')"
                            ></i-button>
                        </i-input>
                    </FormItem>
                </i-form>
            </div>
            <div class="table-cell tx-r btn-drop-box" id="pLsitHeader">
                <i-button
                    size="small"
                    type="text"
                    @click="add()"
                    class="add-extra"
                    ><Icon type="android-add-circle"></Icon>
                    {{ __('新增') }}</i-button
                >
            </div>
        </div>
    </div>
</template>

<script src="./assets/index.js"></script>
