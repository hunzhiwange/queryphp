<template>
    <div class="main" :class="{'main-hide-text': shrink}">
        <div slot="top" class="logo-con" :style="{width: shrink ? '60px' : '200px'}">
            <img v-show="!shrink" :src="img_logo" key="max-logo" />
            <img v-show="shrink" :src="img_mini_logo" key="min-logo" />
        </div>
        <div
            class="sidebar-menu-con"
            :style="{
                width: shrink ? '60px' : '200px',
                overflow: shrink ? 'visible' : 'auto',
            }"
        >
            <shrinkable-menu
                :shrink="shrink"
                @on-change="handleSubmenuChange"
                :theme="menuTheme"
                :before-push="beforePush"
                :open-names="openedSubmenuArr"
                :menu-list="menuList"
            >
            </shrinkable-menu>
        </div>
        <div class="main-header-con" :style="{paddingLeft: shrink ? '60px' : '200px'}">
            <div class="main-header">
                <div class="navicon-con">
                    <i-button
                        :style="{
                            transform: 'rotateZ(' + (this.shrink ? '180' : '0') + 'deg)',
                        }"
                        type="text"
                        @click="toggleClick"
                    >
                        <Icon type="md-return-left" size="22"></Icon>
                    </i-button>
                </div>
                <div class="header-middle-con">
                    <div class="tags-con">
                        <tags-page-opened :pageTagsList="pageTagsList"></tags-page-opened>
                    </div>
                </div>
                <div class="header-avator-con">
                    <i-menu mode="horizontal" theme="primary" class="pull-right">
                        <!-- prettier-ignore -->
                        <MenuItem name="2" style="padding: 0;">
                    <Dropdown transfer class="header-menuitem">
                        <span class="main-option">
                            <Icon type="ios-settings-outline" :size="22"></Icon>
                        </span>
                        <DropdownMenu slot="list">
                            <DropdownItem>
                                <theme-switch></theme-switch>
                            </DropdownItem>
                            <DropdownItem>
                                <i18n-switch></i18n-switch>
                            </DropdownItem>
                            <DropdownItem>
                                <lock-screen></lock-screen>
                            </DropdownItem>
                            <DropdownItem>
                                <full-screen v-model="isFullScreen" @on-change="fullscreenChange"></full-screen>
                            </DropdownItem>
                        </DropdownMenu>
                    </Dropdown>
                    <!-- prettier-ignore -->
                    </MenuItem>
                        <!-- prettier-ignore -->
                        <MenuItem name="3" style="padding: 0;">
                    <message-tip v-model="mesCount"></message-tip>
                    <!-- prettier-ignore -->
                    </MenuItem>
                        <!-- prettier-ignore -->
                        <MenuItem name="1" class="header-user" style="padding: 0;">
                    <Dropdown transfer @on-click="handleClickUserDropdown" class="header-menuitem">
                        <span class="header-username">
                            <Avatar :src="avatorPath" class="user-avatar"></Avatar>
                        </span>
                        <DropdownMenu slot="list">
                            <DropdownItem name="information">
                                <Icon type="md-person" size="22" ></Icon> {{username}}</DropdownItem>
                            <DropdownItem name="changePassword">
                                <Icon type="md-key"></Icon> {{__('修改密码')}}</DropdownItem>
                            <DropdownItem name="logout">
                                <Icon type="md-log-out"></Icon> {{__('退出')}}</DropdownItem>
                        </DropdownMenu>
                    </Dropdown>
                    <!-- prettier-ignore -->
                    </MenuItem>
                    </i-menu>
                </div>
            </div>
        </div>
        <div class="single-page-con" :style="{left: shrink ? '60px' : '200px'}">
            <div class="single-page">
                <Row>
                    <div class="main-breadcrumb">
                        <breadcrumb-nav :currentPath="currentPath"></breadcrumb-nav>
                    </div>
                </Row>
                <keep-alive :include="cachePage">
                    <router-view></router-view>
                </keep-alive>
            </div>
        </div>
        <changePassword ref="changePassword" @logout="changePasswordLogout"></changePassword>
        <information ref="information"></information>
    </div>
</template>

<style lang="less" src="./assets/layout.less"></style>
<script src="./assets/layout.js"></script>
