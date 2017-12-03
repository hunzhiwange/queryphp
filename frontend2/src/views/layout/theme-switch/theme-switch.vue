<template>
<div @click="handleSelect" class="switch-theme-con">
    <Icon :style="{verticalAlign: 'middle'}" type="tshirt" :size="22"></Icon>
    <Modal v-model="themeSelect" width="360" class="switch-theme-select">
        <p>
            <Row type="flex" justify="center" align="middle">
                <Col v-for="(item, index) in themeList" :key="index" :name="item.name" span="6" class="tx-c">
                    <div @click="setTheme(item.name)">
                        <Tooltip :content="item.title" :placement="item.placement">
                            <Avatar :style="{'background-color': item.element, color:item.menu }" :icon="item.name.substr(0, 1) !== 'b' ? 'happy-outline' : 'happy'" class="pointer" @on-click="setTheme(item.name)"></Avatar>
                        </Tooltip>
                    </div>
                </Col>
            </Row>
        </p>
        <div slot="footer">
            <Button type="primary" size="large" long :loading="modalLoading">确定</Button>
        </div>
    </Modal>
</div>
</template>

<script>
import Cookies from 'js-cookie';

export default {
    name: 'themeSwitch',
    data() {
        return {
            themeSelect: false,
            modalLoading: false,
            themeList: [{
                    name: 'black_b',
                    title: '青蓝冰水.暗夜',
                    menu: '#ffde00',
                    element: '#2d8cf0',
                    placement: 'top'
                },
                {
                    name: 'black_g',
                    title: '千山一碧.暗夜',
                    menu: 'rgba(174, 221, 129, 1)',
                    element: '#33b976',
                    placement: 'top'
                },
                {
                    name: 'black_y',
                    title: '灿若云霞.暗夜',
                    menu: 'rgba(219, 208, 167, 1)',
                    element: 'rgba(230, 155, 3, 1)',
                    placement: 'top'
                },
                {
                    name: 'black_r',
                    title: '红尘有你.暗夜',
                    menu: 'rgba(112, 149, 159, 1)',
                    element: 'rgba(186, 40, 53, 1)',
                    placement: 'top'
                },
                {
                    name: 'light_b',
                    title: '青蓝冰水.天光',
                    menu: '#eeeeee',
                    element: '#2d8cf0',
                    placement: 'bottom'
                },
                {
                    name: 'light_g',
                    title: '千山一碧.光天',
                    menu: '#eeeeee',
                    element: '#33b976',
                    placement: 'bottom'
                },
                {
                    name: 'light_y',
                    title: '灿若云霞.光天',
                    menu: '#eeeeee',
                    element: 'rgba(230, 155, 3, 1)',
                    placement: 'bottom'
                },
                {
                    name: 'light_r',
                    title: '红尘有你.光天',
                    menu: '#eee',
                    element: 'rgba(186, 40, 53, 1)',
                    placement: 'bottom'
                }
            ]
        };
    },
    methods: {
        handleSelect() {
            this.themeSelect = true
        },
        setTheme(themeFile) {
            let menuTheme = themeFile.substr(0, 1);
            let mainTheme = themeFile.substr(-1, 1);
            if (menuTheme === 'b') {
                this.$store.commit('changeMenuTheme', 'dark');
                menuTheme = 'dark';
            } else {
                this.$store.commit('changeMenuTheme', 'light');
                menuTheme = 'light';
            }

            let path = '';
            let themeLink = document.querySelector('link[name="theme"]');
            let userName = Lockr.get('userInfo').name

            if (localStorage.theme) {
                let themeList = JSON.parse(localStorage.theme);
                let index = 0;
                let hasThisUser = themeList.some((item, i) => {
                    if (item.userName === userName) {
                        index = i;
                        return true;
                    } else {
                        return false;
                    }
                });
                if (hasThisUser) {
                    themeList[index].mainTheme = mainTheme;
                    themeList[index].menuTheme = menuTheme;
                } else {
                    themeList.push({
                        userName: userName,
                        mainTheme: mainTheme,
                        menuTheme: menuTheme
                    });
                }
                localStorage.theme = JSON.stringify(themeList);
            } else {
                localStorage.theme = JSON.stringify([{
                    userName: userName,
                    mainTheme: mainTheme,
                    menuTheme: menuTheme
                }]);
            }
            let stylePath = '';
            if (ENV === 'development') {
                // stylePath = './src/views/layout/theme-switch/theme/'
                stylePath = '/';
            } else {
                stylePath = 'dist/';
            }
            if (mainTheme !== 'b') {
                path = stylePath + mainTheme + '.css';
            } else {
                path = '';
            }
            themeLink.setAttribute('href', path)

            this.themeSelect = false

            _g.success('主题切换成功')
        }
    },
    created() {
        let path = '';
        if (ENV === 'development') {
            // path = './src/views/layout/theme-switch/theme/'
            path = '/';
        } else {
            path = 'dist/';
        }
        let name = Lockr.get('userInfo').name
        if (localStorage.theme) {
            let hasThisUser = JSON.parse(localStorage.theme).some(item => {
                if (item.userName === name) {
                    this.$store.commit('changeMenuTheme', item.menuTheme);
                    this.$store.commit('changeMainTheme', item.mainTheme);
                    return true;
                } else {
                    return false;
                }
            });
            if (!hasThisUser) {
                this.$store.commit('changeMenuTheme', 'light');
                this.$store.commit('changeMainTheme', 'b');
            }
        } else {
            this.$store.commit('changeMenuTheme', 'light');
            this.$store.commit('changeMainTheme', 'b');
        }
        // 根据用户设置主题
        if (this.$store.state.app.themeColor !== 'b') {
            let stylesheetPath = path + this.$store.state.app.themeColor + '.css';
            let themeLink = document.querySelector('link[name="theme"]');
            themeLink.setAttribute('href', stylesheetPath);
        }
    }
};
</script>
