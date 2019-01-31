<template>
    <i-menu ref="sideMenu" :active-name="$route.name" :open-names="openNames" :theme="menuTheme" width="auto" @on-select="changeMenu" accordion>
        <template v-for="item in menuList">
            <!-- prettier-ignore -->
            <MenuItem v-if="item.children.length<=1" :name="item.children[0].name" :key="item.path">
                <Icon :type="item.icon" :size="iconSize" :key="item.path+'_icon'" :style="(!item.children[0].permission ? 'color:#c5c8ce;' : '')"></Icon>
                <span class="layout-text" :key="item.path+'_path'" :style="(!item.children[0].permission ? 'color:#c5c8ce;' : '')">{{ itemTitle(item) }}</span>
            <!-- prettier-ignore -->
            </MenuItem>

            <Submenu v-if="item.children.length > 1" :name="item.name + '_name_sub'" :key="item.path + '_path_sub'">
                <template slot="title">
                    <Icon :type="item.icon" :size="iconSize" :style="!item.permission ? 'color:#c5c8ce;' : ''"></Icon>
                    <span class="layout-text" :style="!item.permission ? 'color:#c5c8ce;' : ''">{{ itemTitle(item) }}</span>
                </template>
                <template v-for="child in item.children">
                    <!-- prettier-ignore -->
                    <MenuItem :name="child.name" :key="child.name+'_sub'" :disabled="!child.permission">
                        <Icon :type="child.icon" :size="iconSize" :key="child.name+'_icon_sub'" :style="(!child.permission ? 'color:#c5c8ce;' : '')"></Icon>
                            <span class="layout-text" :key="child.name+'_sub'" :style="(!child.permission ? 'color:#c5c8ce;' : '')">
                                <template v-if="!child.permission">
                                    {{ itemTitle(child) }}
                                    <Icon type="ios-lock" color="#dcdee2" style="position:relative;top:-1px;" />
                                </template>
                                <template v-else>{{ itemTitle(child) }}</template>
                            </span>
                    <!-- prettier-ignore -->
                    </MenuItem>
                </template>
            </Submenu>
        </template>
    </i-menu>
</template>

<script src="./assets/sidebarMenu.js"></script>
