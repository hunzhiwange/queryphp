import Vue from "vue";
import iView from "iview";
import "iview/dist/styles/iview.css";
import App from "./app";
import "@/i18n";
import router from "./router";
import { appRouter } from "./router/router";
import store from "./store";
import * as filters from "./filters"; // 全局filter
import _ from "lodash";
import axios from "axios";
import moment from "moment";
import utils from "./utils";
import extend from "./utils/extend";
import "./errorLog"; // error log
import "./permission"; // 权限
import "assets/css/global.css";

Vue.use(iView);
Vue.use(extend);

window.axios = axios;

// register global utility filters.
Object.keys(filters).forEach(key => {
    Vue.filter(key, filters[key]);
});

Vue.config.productionTip = false;

window.utils = utils;
window.store = store;
window.ENV = ENV;
window.NODE_ENV = NODE_ENV;
window._ = _;
window.router = router;
window.moment = moment;

window.bus = new Vue({
    el: "#app",
    router,
    store,
    render: h => h(App),
    data: {
        currentPageName: ""
    },
    mounted() {
        this.currentPageName = this.$route.name;
        // 显示打开的页面的列表
        this.$store.commit("setOpenedList");
        //this.$store.commit('initCachepage');
        // 权限菜单过滤相关
        //this.$store.commit('updateMenulist');
    },
    created() {
        let tagsList = [];
        appRouter.map(item => {
            if (item.children.length <= 1) {
                tagsList.push(item.children[0]);
            } else {
                tagsList.push(...item.children);
            }
        });
        this.$store.commit("setTagsList", tagsList);
    }
});
