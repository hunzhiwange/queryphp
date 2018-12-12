<template>
    <div id="main" class="app-main"><router-view v-if="isRouterAlive"></router-view></div>
</template>

<script>
export default {
    provide() {
        return {
            reload: this.reload,
        }
    },
    data() {
        return {
            theme: this.$store.state.app.themeColor,
            isRouterAlive: true,
        }
    },
    methods: {
        reload() {
            this.isRouterAlive = false

            this.$nextTick(function() {
                this.isRouterAlive = true
            })
        },
    },
}
</script>

<style>
@import './assets/css/font-awesome.css';
.app-main {
    width: 100%;
    height: 100%;
}
</style>
