<template>
    <div @click="handleSelect" class="switch-theme-con">
        <Icon
            :style="{verticalAlign: 'middle'}"
            type="tshirt"
            :size="22"
        ></Icon>
        <Modal v-model="themeSelect" width="360" class="switch-theme-select">
            <p>
                <Row type="flex" justify="center" align="middle">
                    <i-col
                        v-for="(item, index) in themeList"
                        :key="index"
                        :name="item.name"
                        span="6"
                        class="tx-c"
                    >
                        <div @click="setTheme(item.name)">
                            <Tooltip
                                :content="item.title"
                                :placement="item.placement"
                            >
                                <Avatar
                                    :style="{
                                        'background-color': item.element,
                                        color: item.menu,
                                    }"
                                    :icon="
                                        item.name.substr(0, 1) !== 'b'
                                            ? 'happy-outline'
                                            : 'happy'
                                    "
                                    class="pointer"
                                    @on-click="setTheme(item.name)"
                                ></Avatar>
                            </Tooltip>
                        </div>
                    </i-col>
                </Row>
            </p>
            <div slot="footer">
                <i-button
                    type="primary"
                    size="large"
                    long
                    :loading="modalLoading"
                    >{{ __('确定') }}</i-button
                >
            </div>
        </Modal>
    </div>
</template>

<script src="./assets/index.js"></script>
