<template>
    <div class="dashboard-page2 body">
        <div class="wrap">
            <Row>
                <Card>
                    <p slot="title">{{ __('基本配置') }}</p>
                    <div>
                        <Row :gutter="16">
                            <i-col span="12">
                                <i-form :model="formItem" :label-width="80" :rules="rules" ref="form">
                                    <FormItem :label="__('站点名字')" prop="site_name">
                                        <i-input v-model="formItem.site_name" placeholder=""></i-input>
                                    </FormItem>
                                    <FormItem :label="__('站点状态')" prop="site_close">
                                        <i-switch v-model="formItem.site_close" size="large" true-value="1" false-value="0">
                                            <span slot="open">{{ __('启用') }}</span> <span slot="close">{{ __('关闭') }}</span>
                                        </i-switch>
                                    </FormItem>
                                    <FormItem>
                                        <i-button type="primary" :loading="loading" @click.native.prevent="handleSubmit('form')">{{ __('确定') }}</i-button>
                                    </FormItem>
                                </i-form>
                            </i-col>
                            <i-col span="12" style="text-align:right;"> </i-col>
                        </Row>
                    </div>
                </Card>
            </Row>
        </div>
    </div>
</template>

<script src="./asserts/option.js"></script>
