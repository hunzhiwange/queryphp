<template>
    <div>
        <template v-for="(item, index) in menuList">
            <div style="text-align: center;" :key="index">
                <Dropdown
                    transfer
                    v-if="
                        item.permission &&
                            (item.children.length !== 1 ||
                            (item.children[0].children && item.children[0].children.length >= 1))
                    "
                    placement="right-start"
                    :key="index"
                    @on-click="changeMenu"
                >
                    <i-button style="width: 70px;margin-left: -5px;padding:10px 0;" type="text">
                        <Icon
                            :v-if="item.icon"
                            :size="20"
                            :color="iconColor"
                            :type="item.icon"
                        ></Icon>
                    </i-button>
                    <DropdownMenu style="width: 150px;" slot="list">
                        <template v-for="(child, i) in item.children">
                            <DropdownItem
                                :name="child.name"
                                v-if="child.permission && (!child.children || child.children.length <= 0)"
                                :key="i"
                                ><Icon :v-if="child.icon" :type="child.icon" v-if="child.icon"></Icon
                                ><span style="padding-left:10px;">
                                    {{ itemTitle(child) }}
                                </span></DropdownItem
                            >
                            <Dropdown
                                style="width: 150px;"
                                transfer
                                placement="right-start"
                                v-if="child.permission && child.children && child.children.length > 0"
                                @on-click="changeMenu"
                                :key="child.name"
                            >
                                <DropdownItem>
                                    <span style="padding-left:10px;">
                                        {{ itemTitle(child) }}
                                        <Icon type="ios-arrow-forward"></Icon>
                                    </span>
                                </DropdownItem>
                                <DropdownMenu slot="list">
                                    <template v-for="childsub in child.children" :name="childsub.name">
                                        <template v-if="childsub.permission">
                                            <DropdownItem style="width: 150px;" :name="childsub.name">
                                                <Icon
                                                    :v-if="childsub.icon"
                                                    :type="childsub.icon"
                                                    v-if="childsub.icon"
                                                ></Icon>
                                                <span style="padding-left:10px;">
                                                    {{ itemTitle(childsub) }}
                                                </span>
                                            </DropdownItem>
                                        </template>
                                    </template>
                                </DropdownMenu>
                            </Dropdown>
                        </template>
                    </DropdownMenu>
                </Dropdown>
                <Dropdown transfer v-else-if="item.permission" placement="right-start" :key="index" @on-click="changeMenu">
                    <i-button
                        @click="changeMenu(item.children[0].name)"
                        style="width: 70px;margin-left: -5px;padding:10px 0;"
                        type="text"
                    >
                        <Icon
                            :size="20"
                            :color="iconColor"
                            :type="item.icon"
                        ></Icon>
                    </i-button>
                    <DropdownMenu style="width: 200px;" slot="list">
                        <DropdownItem :name="item.children[0].name" :key="'d' + index"
                            ><Icon
                                :v-if="item.icon"
                                :type="item.icon"
                            ></Icon
                            ><span
                                style="padding-left:10px;"
                                >{{ itemTitle(item.children[0]) }}</span
                            ></DropdownItem
                        >
                    </DropdownMenu>
                </Dropdown>
            </div>
        </template>
    </div>
</template>

<script src="./assets/sidebarMenuShrink.js"></script>
