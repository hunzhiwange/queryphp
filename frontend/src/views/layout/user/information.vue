<template>
    <Modal v-model="dialogVisible" :title="__('账号设置')" width="500">
        <div>
            <i-form ref="form" :model="form" :rules="rules" :label-width="80">
                <FormItem :label="__('邮箱')" prop="email">
                    <i-input v-model.trim="form.email" placeholder=""></i-input>
                </FormItem>
                <FormItem :label="__('手机号')" prop="mobile">
                    <i-input v-model.number="form.mobile" placeholder=""></i-input>
                </FormItem>
            </i-form>
        </div>
        <div slot="footer">
            <i-button type="text" @click="cancel">{{ __('取消') }}</i-button>
            <i-button type="primary" :loading="loading" @click="ok">{{ __('确认') }}</i-button>
        </div>
    </Modal>
</template>

<script src="./assets/information.js"></script>
