<template>
    <i-menu
        ref="sideMenu"
        :active-name="$route.name"
        :open-names="openNames"
        width="auto"
        @on-select="changeMenu"
        accordion
    >
        <template v-for="item in menuList">
            <!-- prettier-ignore -->
            <MenuItem v-if="
                item.permission &&
                    (item.children.length <= 1 &&
                    (!item.children[0].children || item.children[0].children.length < 1))" :name="item.children[0].name" :key="item.path">
                <Icon :v-if="item.icon" :type="item.icon" :size="iconSize" :key="item.path+'_icon'"></Icon>
                <div class="layout-text" :key="item.path+'_path'">{{ itemTitle(item) }}</div>
            <!-- prettier-ignore -->
            </MenuItem>

            <Submenu
                v-if="item.permission && (item.children.length > 1 || (item.children[0].children && item.children[0].children.length >= 1))"
                :name="item.name"
                :key="item.path + '_path_sub'"
            >
                <template slot="title">
                    <Icon
                        :v-if="item.icon"
                        :type="item.icon"
                        :size="iconSize"
                    ></Icon>
                    <div class="layout-text">
                        {{ itemTitle(item) }}
                    </div>
                </template>
                <template v-for="child in item.children">
                    <!-- prettier-ignore -->
                    <MenuItem v-if="child.permission && (!child.children || child.children.length<=0)" :name="child.name" :key="child.name+'_sub'">
                        <Icon :v-if="child.icon" :type="child.icon" :size="iconSize" :key="child.name+'_icon_sub'"></Icon>
                            <div class="layout-text" :key="child.name+'_sub'">
                                {{ itemTitle(child) }}
                            </div>
                    <!-- prettier-ignore -->
                    </MenuItem>

                    <Submenu
                        v-if="child.permission && child.children && child.children.length > 0"
                        :name="child.name"
                        :key="child.name + '_sub'"
                    >
                        <template slot="title">
                            <Icon
                                :v-if="child.icon"
                                :type="child.icon"
                                :size="iconSize"
                                :key="child.name + '_icon_sub'"
                            ></Icon>
                            <div class="layout-text">
                                {{ itemTitle(child) }}
                            </div>
                        </template>
                        <template v-for="childsub in child.children">
                            <!-- prettier-ignore -->
                             <template v-if="childsub.permission">
                                <MenuItem :name="childsub.name" :key="childsub.name + '_sub_sub'">
                                    <Icon
                                        :v-if="childsub.icon"
                                        :type="childsub.icon"
                                        :size="iconSize"
                                        :key="childsub.name + '_icon_sub'"
                                    ></Icon>
                                    <div class="layout-text">
                                        {{ itemTitle(childsub) }}
                                    </div>
                            <!-- prettier-ignore -->
                                </MenuItem>
                            </template>
                        </template>
                    </Submenu>
                </template>
            </Submenu>
        </template>
    </i-menu>
</template>

<script src="./assets/sidebarMenu.js"></script>
