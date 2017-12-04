<template>
<div @click="handleSelect" class="i18n-theme-con">
    <Tooltip content="国际化" placement="left">
        <Icon type="earth"></Icon> 国际化
    </Tooltip>
    <Modal v-model="i18nSelect" width="360" class="i18n-theme-select">
        <p>
            <Row type="flex" justify="center" align="middle">
                <RadioGroup v-model="i18n" @on-change="setIi8n()">
                    <Radio v-for="(item, index) in i18nList" :key="index" :label="item.name">
                        <span>{{item.title}}</span>
                    </Radio>
                </RadioGroup>
            </Row>
        </p>
        <div slot="footer">
            <Button type="primary" size="large" long :loading="modalLoading">确定</Button>
        </div>
    </Modal>
</div>
</template>

<script src="./assets/index.js"></script>
