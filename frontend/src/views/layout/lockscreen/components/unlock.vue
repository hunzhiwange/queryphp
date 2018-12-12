<template>
    <transition name="show-unlock">
        <div class="unlock-body-con" v-if="showUnlock" @keydown.enter="handleUnlock">
            <div @click="handleClickAvator" class="unlock-avator-con" :style="{marginLeft: avatorLeft}">
                <img class="unlock-avator-img" :src="avatorPath" />
                <div class="unlock-avator-cover">
                    <span><Icon :type="inputLeft !== '0px' ? 'md-unlock' : 'md-lock'" :size="30"></Icon></span>
                    <p>{{ inputLeft !== '0px' ? __('解锁') : __('取消') }}</p>
                </div>
            </div>
            <div class="unlock-avator-under-back" :style="{marginLeft: avatorLeft}"></div>
            <div class="unlock-input-con">
                <div class="unlock-input-overflow-con">
                    <div class="unlock-overflow-body" :style="{right: inputLeft}">
                        <input ref="inputEle" v-model="password" class="unlock-input" type="password" :placeholder="__('密码同登录密码')" />
                        <i-button ref="unlockBtn" @mousedown="unlockMousedown" @mouseup="unlockMouseup" @click="handleUnlock" class="unlock-btn">
                            <Icon color="white" type="md-key"></Icon>
                        </i-button>
                    </div>
                </div>
            </div>
            <div class="unlock-locking-tip-con">
                <Dropdown @on-click="handleClickLock">
                    <i-button type="primary">
                        {{ __('已锁定') }}
                        <Icon type="arrow-down-b"></Icon>
                    </i-button>
                    <DropdownMenu slot="list">
                        <DropdownItem name="lock">
                            <Icon :type="inputLeft !== '0px' ? 'md-unlock' : 'md-lock'"></Icon>
                            {{ inputLeft !== '0px' ? __('解锁') : __('取消') }}</DropdownItem
                        >
                        <DropdownItem name="logout"> <Icon type="md-log-out"></Icon> {{ __('退出') }}</DropdownItem>
                    </DropdownMenu>
                </Dropdown>
            </div>
        </div>
    </transition>
</template>

<style lang="less" src="./assets/unlock.less"></style>
<script src="./assets/unlock.js"></script>
