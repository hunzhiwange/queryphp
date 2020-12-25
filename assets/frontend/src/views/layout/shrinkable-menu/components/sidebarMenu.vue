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
            <MenuItem v-if="item.children.length<=1 && (!item.children[0].children || item.children[0].children.length<1)" :name="item.children[0].name" :key="item.path">
                <Icon :v-if="item.icon" :type="item.icon" :size="iconSize" :key="item.path+'_icon'" :style="(!item.children[0].permission ? 'color:#c5c8ce;' : '')"></Icon>
                <div class="layout-text" :key="item.path+'_path'" :style="(!item.children[0].permission ? 'color:#c5c8ce;' : '')">{{ itemTitle(item) }}</div>
            <!-- prettier-ignore -->
            </MenuItem>

            <Submenu
                v-if="item.children.length > 1 || (item.children[0].children && item.children[0].children.length >= 1)"
                :name="item.name"
                :key="item.path + '_path_sub'"
            >
                <template slot="title">
                    <Icon
                        :v-if="item.icon"
                        :type="item.icon"
                        :size="iconSize"
                        :style="!item.permission ? 'color:#c5c8ce;' : ''"
                    ></Icon>
                    <div class="layout-text" :style="!item.permission ? 'color:#c5c8ce;' : ''">
                        {{ itemTitle(item) }}
                    </div>
                </template>
                <template v-for="child in item.children">
                    <!-- prettier-ignore -->
                    <MenuItem v-if="!child.children || child.children.length<=0" :name="child.name" :key="child.name+'_sub'" :disabled="!child.permission">
                        <Icon :v-if="child.icon" :type="child.icon" :size="iconSize" :key="child.name+'_icon_sub'" :style="(!child.permission ? 'color:#c5c8ce;' : '')"></Icon>
                            <div class="layout-text" :key="child.name+'_sub'" :style="(!child.permission ? 'color:#c5c8ce;' : '')">
                                <template v-if="!child.permission">
                                    {{ itemTitle(child) }}
                                    <Icon type="ios-lock" color="#dcdee2" style="position:relative;top:-1px;" />
                                </template>
                                <template v-else>{{ itemTitle(child) }}</template>
                            </div>
                    <!-- prettier-ignore -->
                    </MenuItem>

                    <Submenu
                        v-if="child.children && child.children.length > 0"
                        :name="child.name"
                        :key="child.name + '_sub'"
                    >
                        <template slot="title">
                            <Icon
                                :v-if="child.icon"
                                :type="child.icon"
                                :size="iconSize"
                                :key="child.name + '_icon_sub'"
                                :style="!child.permission ? 'color:#c5c8ce;' : ''"
                            ></Icon>
                            <div class="layout-text" :style="!child.permission ? 'color:#c5c8ce;' : ''">
                                {{ itemTitle(child) }}
                            </div>
                        </template>
                        <template v-for="childsub in child.children">
                            <!-- prettier-ignore -->
                            <MenuItem :name="childsub.name" :key="childsub.name + '_sub_sub'">
                                <Icon
                                    :v-if="childsub.icon"
                                    :type="childsub.icon"
                                    :size="iconSize"
                                    :key="childsub.name + '_icon_sub'"
                                    :style="!childsub.permission ? 'color:#c5c8ce;' : ''"
                                ></Icon>
                                <div class="layout-text" :style="!childsub.permission ? 'color:#c5c8ce;' : ''">
                                    <template v-if="!childsub.permission">
                                        {{ itemTitle(childsub) }}
                                        <Icon type="ios-lock" color="#dcdee2" style="position:relative;top:-1px;" />
                                    </template>
                                    <template v-else>{{ itemTitle(childsub) }}</template>
                                </div>
                            <!-- prettier-ignore -->
                            </MenuItem>
                        </template>
                    </Submenu>
                </template>
            </Submenu>
        </template>
    </i-menu>
</template>

<script src="./assets/sidebarMenu.js"></script>
