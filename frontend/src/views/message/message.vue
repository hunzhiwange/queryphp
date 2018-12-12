<template>
    <div class="message-main-con">
        <div class="message-mainlist-con">
            <div>
                <i-button @click="setCurrentMesType('unread')" size="large" long type="text"
                    ><transition name="mes-current-type-btn"><Icon v-show="currentMessageType === 'unread'" type="checkmark"></Icon></transition
                    ><span class="mes-type-btn-text">{{ __('未读消息') }}</span
                    ><Badge class="message-count-badge-outer" class-name="message-count-badge" :count="unreadCount"></Badge
                ></i-button>
            </div>
            <div>
                <i-button @click="setCurrentMesType('hasread')" size="large" long type="text"
                    ><transition name="mes-current-type-btn"><Icon v-show="currentMessageType === 'hasread'" type="checkmark"></Icon></transition
                    ><span class="mes-type-btn-text">{{ __('已读消息') }}</span
                    ><Badge class="message-count-badge-outer" class-name="message-count-badge" :count="hasreadCount"></Badge
                ></i-button>
            </div>
            <div>
                <i-button @click="setCurrentMesType('recyclebin')" size="large" long type="text"
                    ><transition name="mes-current-type-btn"><Icon v-show="currentMessageType === 'recyclebin'" type="checkmark"></Icon></transition
                    ><span class="mes-type-btn-text">{{ __('回收站') }}</span
                    ><Badge class="message-count-badge-outer" class-name="message-count-badge" :count="recyclebinCount"></Badge
                ></i-button>
            </div>
        </div>
        <div class="message-content-con">
            <transition name="view-message">
                <div v-if="showMesTitleList" class="message-title-list-con">
                    <i-table ref="messageList" :columns="mesTitleColumns" :data="currentMesList" :no-data-text="noDataText"></i-table>
                </div>
            </transition>
            <transition name="back-message-list">
                <div v-if="!showMesTitleList" class="message-view-content-con">
                    <div class="message-content-top-bar">
                        <span class="mes-back-btn-con"
                            ><i-button type="text" @click="backMesTitleList"><Icon type="chevron-left"></Icon>&nbsp;&nbsp;{{ __('返回') }}</i-button></span
                        >
                        <h3 class="mes-title">{{ mes.title }}</h3>
                    </div>
                    <p class="mes-time-con"><Icon type="android-time"></Icon>&nbsp;&nbsp;{{ mes.time }}</p>
                    <div class="message-content-body">
                        <p class="message-content">{{ mes.content }}</p>
                    </div>
                </div>
            </transition>
        </div>
    </div>
</template>

<style lang="less" src="./assets/message.less"></style>
<script src="./assets/message.js"></script>
