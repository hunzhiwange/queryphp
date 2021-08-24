<template>
    <div>
        <template v-for="(item, index) in menuList">
            <div style="text-align: center;" :key="index">
                <div
                    v-if="
                        item.permission &&
                            (item.children.length !== 1 ||
                            (item.children[0].children && item.children[0].children.length >= 1))
                    "
                    @on-click="changeMenu"
                >
                    <i-button style="width: 70px;margin-left: -5px;padding:10px 0;" type="text">
                        <Icon
                            :v-if="item.icon"
                            :size="16"
                            :color="iconColor"
                            :type="item.icon"
                        ></Icon>
                    </i-button>
                </div>
                <div v-else-if="item.permission" @on-click="changeMenu">
                    <i-button
                        @click="changeMenu(item.children[0].name)"
                        style="width: 70px;margin-left: -5px;padding:10px 0;"
                        type="text"
                    >
                        <Icon
                            :size="16"
                            :color="iconColor"
                            :type="item.icon"
                        ></Icon>
                    </i-button>
                </div>
            </div>
        </template>
    </div>
</template>

<script src="./assets/sidebarMenuShrink.js"></script>
