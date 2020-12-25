<template>
    <Modal v-model="dialogVisible" :title="__('修改密码')" width="500">
        <div>
            <i-form ref="form" :model="form" :rules="rules" :label-width="140">
                <FormItem :label="__('旧密码')" prop="old_pwd">
                    <i-input type="password" v-model.trim="form.old_pwd" placeholder="" auto-complete="off"></i-input>
                </FormItem>
                <FormItem :label="__('新密码')" prop="new_pwd">
                    <i-input type="password" v-model.trim="form.new_pwd" placeholder="" auto-complete="off"></i-input>
                </FormItem>
                <FormItem :label="__('确认密码')" prop="confirm_pwd">
                    <i-input
                        type="password"
                        v-model.trim="form.confirm_pwd"
                        placeholder=""
                        auto-complete="off"
                    ></i-input>
                </FormItem>
            </i-form>
        </div>
        <div slot="footer">
            <i-button type="text" @click="cancel">{{ __('取消') }}</i-button>
            <i-button type="error" :loading="loading" @click="ok">{{ __('确认') }}</i-button>
        </div>
    </Modal>
</template>

<script src="./assets/change_password.js"></script>
