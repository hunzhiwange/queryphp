<template>
    <i-menu
        ref="sideMenu"
        :active-name="$route.name"
        :open-names="openNames"
        :theme="menuTheme"
        width="auto"
        @on-select="changeMenu"
        accordion
    >
        <template v-for="item in menuList">
            <!-- prettier-ignore -->
            <MenuItem v-if="item.children.length<=1" :name="item.children[0].name" :key="item.path">
                <Icon :type="item.icon" :size="iconSize" :key="item.path+'_icon'"></Icon>
                <span class="layout-text" :key="item.path+'_path'">{{ itemTitle(item) }}</span>
            <!-- prettier-ignore -->
            </MenuItem>

            <Submenu
                v-if="item.children.length > 1"
                :name="item.name+'_name_sub'"
                :key="item.path+'_path_sub'"
            >
                <template slot="title">
                    <Icon :type="item.icon" :size="iconSize"></Icon>
                    <span class="layout-text">{{ itemTitle(item) }}</span>
                </template>
                <template v-for="child in item.children">
                    <!-- prettier-ignore -->
                    <MenuItem :name="child.name" :key="child.name+'_sub'">
                        <Icon :type="child.icon" :size="iconSize" :key="child.name+'_icon_sub'"></Icon>
                        <span class="layout-text" :key="child.name+'_sub'">{{ itemTitle(child) }}</span>
                    <!-- prettier-ignore -->
                    </MenuItem>
                </template>
            </Submenu>
        </template>
    </i-menu>
</template>

<script src="./assets/sidebarMenu.js"></script>
