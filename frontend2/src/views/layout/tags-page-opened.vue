<template>
<div ref="scrollCon" @DOMMouseScroll="handlescroll" @mousewheel="handlescroll" class="tags-outer-scroll-con">
    <div class="leftmove-tag-con">
        <Dropdown transfer @on-click="handleTagsOption">
            <Button size="small" type="primary">
                <Icon type="android-more-vertical" :size="22"></Icon>
            </button>
            <DropdownMenu slot="list">
                <DropdownItem name="refreshTag"><Icon type="refresh" :size="22"></Icon></DropdownItem>
                <DropdownItem name="clearTag">关闭标签</DropdownItem>
                <DropdownItem name="clearOthers">关闭其他</DropdownItem>
                <DropdownItem name="clearRights">关闭右侧</DropdownItem>
                <DropdownItem name="clearLefts">关闭左侧</DropdownItem>
                <DropdownItem name="clearAll">关闭所有</DropdownItem>
            </DropdownMenu>
        </Dropdown>
    </div>
    <div class="close-all-tag-con">
        <Dropdown transfer @on-click="handleTagsOption">
            <Button size="small" type="primary">
                <Icon type="android-more-vertical" :size="22"></Icon>
            </Button>
            <DropdownMenu slot="list">
                <DropdownItem name="refreshTag"><Icon type="refresh" :size="22"></Icon></DropdownItem>
                <DropdownItem name="clearTag">关闭标签</DropdownItem>
                <DropdownItem name="clearOthers">关闭其他</DropdownItem>
                <DropdownItem name="clearRights">关闭右侧</DropdownItem>
                <DropdownItem name="clearLefts">关闭左侧</DropdownItem>
                <DropdownItem name="clearAll">关闭所有</DropdownItem>
            </DropdownMenu>
        </Dropdown>
    </div>
    <div ref="scrollBody" class="tags-inner-scroll-body" :style="{left: tagBodyLeft + 'px'}">
        <draggable v-model="pageTagsList" :move="dragMove" @update="dragEnd">
            <transition-group name="taglist-moving-animation">
                <Tag type="dot" v-for="(item, index) in pageTagsList" ref="tagsPageOpened" :key="item.name" :name="item.name" @on-close="closePage" @click.native="linkTo(item)" :closable="item.name==='dashboard'?false:true" :color="item.children?(item.children[0].name===currentPageName?'blue':'default'):(item.name===currentPageName?'blue':'default')">
                    <Tooltip :content="itemTitle(item)" placement="bottom">
                        {{ itemTitle(item) }}
                    </Tooltip>
                </Tag>
            </transition-group>
        </draggable>
    </div>
</div>
</template>

<script>
import Vue from 'vue';
import VueI18n from 'vue-i18n';
Vue.use(VueI18n);
import draggable from 'vuedraggable'

export default {
    name: 'tagsPageOpened',
    data() {
        return {
            currentPageName: this.$route.name,
            tagBodyLeft: 0,
            refsTag: [],
            tagsCount: 1
        };
    },
    components: {
        draggable
    },
    props: {
        pageTagsList: Array,
        beforePush: {
            type: Function,
            default: (item) => {
                return true;
            }
        }
    },
    computed: {
        title() {
            return this.$store.state.app.currentTitle;
        },
        tagsList() {
            return this.$store.state.app.pageOpenedList;
        }
    },
    methods: {
        dragMove(evt) {
            // console.log(evt.draggedContext.element.id)
        },
        dragEnd(evt) {
            // console.log('拖动前的索引 :' + evt.oldIndex)
            // console.log('拖动后的索引 :' + evt.newIndex)
            //console.log(this.tags)
            this.$store.commit('saveTagLocalStorage', this)
        },
        itemTitle(item) {
            return item.title;
        },
        closePage(event, name) {
            let pageOpenedList = this.$store.state.app.pageOpenedList;
            let lastPageObj = pageOpenedList[0];
            if (this.currentPageName === name) {
                let len = pageOpenedList.length;
                for (let i = 1; i < len; i++) {
                    if (pageOpenedList[i].name === name) {
                        if (i < (len - 1)) {
                            lastPageObj = pageOpenedList[i + 1];
                        } else {
                            lastPageObj = pageOpenedList[i - 1];
                        }
                        break;
                    }
                }
            }
            this.$store.commit('removeTag', name);
            this.$store.commit('closePage', name);
            pageOpenedList = this.$store.state.app.pageOpenedList;
            localStorage.pageOpenedList = JSON.stringify(pageOpenedList);
            if (this.currentPageName === name) {
                this.linkTo(lastPageObj);
            }
        },
        linkTo(item) {
            let routerObj = {};
            routerObj.name = item.name;
            if (item.argu) {
                routerObj.params = item.argu;
            }
            if (item.query) {
                routerObj.query = item.query;
            }
            if (this.beforePush(item)) {
                this.$router.push(routerObj);
            }
        },
        handlescroll(e) {
            var type = e.type;
            let delta = 0;
            if (type === 'DOMMouseScroll' || type === 'mousewheel') {
                delta = (e.wheelDelta) ? e.wheelDelta : -(e.detail || 0) * 40;
            }
            let left = 0;
            if (delta > 0) {
                left = Math.min(0, this.tagBodyLeft + delta);
            } else {
                if (this.$refs.scrollCon.offsetWidth - 100 < this.$refs.scrollBody.offsetWidth) {
                    if (this.tagBodyLeft < -(this.$refs.scrollBody.offsetWidth - this.$refs.scrollCon.offsetWidth + 100)) {
                        left = this.tagBodyLeft;
                    } else {
                        left = Math.max(this.tagBodyLeft + delta, this.$refs.scrollCon.offsetWidth - this.$refs.scrollBody.offsetWidth - 100);
                    }
                } else {
                    this.tagBodyLeft = 0;
                }
            }
            this.tagBodyLeft = left;
        },
        handleTagsOption(type) {
            switch (type) {
                case 'clearAll':
                    this.$store.commit('clearAllTags', this)
                    break

                case 'clearOthers':
                    this.$store.commit('clearOtherTags', this);
                    break

                case 'clearTag':
                    this.$store.commit('clearCurrentTag', this);
                    break

                case 'clearLefts':
                    this.$store.commit('clearLeftsTag', this);
                    break

                case 'clearRights':
                    this.$store.commit('clearRightsTag', this);
                    break

                case 'refreshTag':
                    _g.shallowRefresh(this.currentPageName)
                    break
            }
            this.tagBodyLeft = 0;
        },
        moveToView(tag) {
            if (tag.offsetLeft < -this.tagBodyLeft) {
                // 标签在可视区域左侧
                this.tagBodyLeft = -tag.offsetLeft + 10;
            } else if (tag.offsetLeft + 10 > -this.tagBodyLeft && tag.offsetLeft + tag.offsetWidth < -this.tagBodyLeft + this.$refs.scrollCon.offsetWidth - 100) {
                // 标签在可视区域
            } else {
                // 标签在可视区域右侧
                this.tagBodyLeft = -(tag.offsetLeft - (this.$refs.scrollCon.offsetWidth - 100 - tag.offsetWidth) + 20);
            }
        }
    },
    mounted() {
        this.refsTag = this.$refs.tagsPageOpened;
        setTimeout(() => {
            this.refsTag.forEach((item, index) => {
                if (this.$route.name === item.name) {
                    let tag = this.refsTag[index].$el;
                    this.moveToView(tag);
                }
            });
        }, 1); // 这里不设定时器就会有偏移bug
        this.tagsCount = this.tagsList.length;
    },
    watch: {
        '$route' (to) {
            this.currentPageName = to.name;
            this.$nextTick(() => {
                this.refsTag.forEach((item, index) => {
                    if (to.name === item.name) {
                        let tag = this.refsTag[index].$el;
                        this.moveToView(tag);
                    }
                });
            });
            this.tagsCount = this.tagsList.length;
        }
    }
};
</script>
