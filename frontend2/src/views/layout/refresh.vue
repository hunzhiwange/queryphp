<template>
<div class="refresh-page">

    <Row>
        <Card>
            <div class="refresh-box">
                <Spin fix>
                    <Icon type="load-c" :size="200" class="refresh-spin-icon-load"></Icon>
                    <div>Loading</div>
                </Spin>
                <h3>The PHP Framework For Code Poem As Free As Wind</h3>
            </div>
        </Card>
    </Row>
</div>
</template>
<style>
.refresh-box {
    text-align: center;
    height: 270px;
}

.refresh-spin-icon-load {
    animation: ani-refresh-spin 1s linear infinite;
}

@keyframes ani-refresh-spin {
    from {
        transform: rotate(0deg);
    }
    50% {
        transform: rotate(180deg);
    }
    to {
        transform: rotate(360deg);
    }
}
</style>
<script>
export default {
    created() {},
    activated() {
        if (this.$route.query.name) {
            router.replace({
                name: this.$route.query.name,
                query: {
                    refresh: 'page'
                }
            })
        } else {
            console.log('refresh fail')
        }
    },
}
</script>
