<template>
    <div>
        <template v-for="(item, index) in menuList">
            <div style="text-align: center;" :key="index">
                <Dropdown transfer v-if="item.children.length !== 1" placement="right-start" :key="index" @on-click="changeMenu">
                    <i-button style="width: 70px;margin-left: -5px;padding:10px 0;" type="text">
                        <Icon :size="20" :color="iconColor" :type="item.icon" :style="!item.permission ? 'color:#c5c8ce;' : ''"></Icon>
                    </i-button>
                    <DropdownMenu style="width: 200px;" slot="list">
                        <template v-for="(child, i) in item.children">
                            <DropdownItem :name="child.name" :key="i" :disabled="!child.permission"
                                ><Icon :type="child.icon"></Icon
                                ><span style="padding-left:10px;">
                                    <template v-if="!child.permission">
                                        {{ itemTitle(child) }}
                                        <Icon type="ios-lock" color="#dcdee2" style="position:relative;top:-1px;" />
                                    </template>
                                    <template v-else>{{ itemTitle(child) }}</template>
                                </span></DropdownItem
                            >
                        </template>
                    </DropdownMenu>
                </Dropdown>
                <Dropdown transfer v-else placement="right-start" :key="index" @on-click="changeMenu">
                    <i-button @click="changeMenu(item.children[0].name)" style="width: 70px;margin-left: -5px;padding:10px 0;" type="text">
                        <Icon :size="20" :color="iconColor" :type="item.icon" :style="!item.permission ? 'color:#c5c8ce;' : ''"></Icon>
                    </i-button>
                    <DropdownMenu style="width: 200px;" slot="list">
                        <DropdownItem :name="item.children[0].name" :key="'d' + index"
                            ><Icon :type="item.icon" :style="!item.children[0].permission ? 'color:#c5c8ce;' : ''"></Icon
                            ><span style="padding-left:10px;" :style="!item.children[0].permission ? 'color:#c5c8ce;' : ''">{{
                                itemTitle(item.children[0])
                            }}</span></DropdownItem
                        >
                    </DropdownMenu>
                </Dropdown>
            </div>
        </template>
    </div>
</template>

<script src="./assets/sidebarMenuShrink.js"></script>
