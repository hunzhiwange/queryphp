<template>
    <transition name="show-unlock">
        <div
            class="unlock-body-con"
            v-if="showUnlock"
            @keydown.enter="handleUnlock"
        >
            <div
                @click="handleClickAvator"
                class="unlock-avator-con"
                :style="{marginLeft: avatorLeft}"
            >
                <img class="unlock-avator-img" :src="avatorPath" />
                <div class="unlock-avator-cover">
                    <span><Icon type="unlocked" :size="30"></Icon></span>
                    <p>{{ __('解锁') }}</p>
                </div>
            </div>
            <div
                class="unlock-avator-under-back"
                :style="{marginLeft: avatorLeft}"
            ></div>
            <div class="unlock-input-con">
                <div class="unlock-input-overflow-con">
                    <div
                        class="unlock-overflow-body"
                        :style="{right: inputLeft}"
                    >
                        <input
                            ref="inputEle"
                            v-model="password"
                            class="unlock-input"
                            type="password"
                            :placeholder="__('密码同登录密码')"
                        />
                        <button
                            ref="unlockBtn"
                            @mousedown="unlockMousedown"
                            @mouseup="unlockMouseup"
                            @click="handleUnlock"
                            class="unlock-btn"
                        >
                            <Icon color="white" type="key"></Icon>
                        </button>
                    </div>
                </div>
            </div>
            <div class="unlock-locking-tip-con">{{ __('已锁定') }}</div>
        </div>
    </transition>
</template>

<style lang="less" src="./assets/unlock.less"></style>
<script src="./assets/unlock.js"></script>
