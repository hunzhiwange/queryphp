import Vue from 'vue'
import VueI18n from 'vue-i18n'
Vue.use(VueI18n)

//see https://github.com/SortableJS/Vue.Draggable
import draggable from 'vuedraggable'

export default {
    name: 'tagsPageOpened',
    inject: ['reload'],
    data() {
        return {
            currentPageName: this.$route.name,
            tagBodyLeft: 0,
            refsTag: [],
            tagsCount: 1,
            tagsOpenModel: [],
            pageOpenedDashboard: this.$store.state.app.pageOpenedDashboard,
        }
    },
    components: {
        draggable,
    },
    props: {
        pageTagsList: Array,
        beforePush: {
            type: Function,
            default: item => {
                return true
            },
        },
    },
    computed: {
        pageTagsLists: {
            get() {
                return this.$store.state.app.pageOpenedList
            },
            set(value) {
                this.$store.commit('dragTags', value)
            },
        },
        title() {
            return this.$store.state.app.currentTitle
        },
        tagsList() {
            return this.$store.state.app.pageOpenedList
        },
    },
    created() {
        this.tagsOpenModel = this.pageTagsList
    },
    methods: {
        itemTitle(item) {
            return item.meta ? item.meta.title : ''
        },
        closePage(event, name) {
            let pageOpenedList = this.$store.state.app.pageOpenedList
            let lastPageObj = pageOpenedList[0]
            if (this.currentPageName === name) {
                let len = pageOpenedList.length
                for (let i = 1; i < len; i++) {
                    if (pageOpenedList[i].name === name) {
                        if (i < len - 1) {
                            lastPageObj = pageOpenedList[i + 1]
                        } else {
                            lastPageObj = pageOpenedList[i - 1]
                        }
                        break
                    }
                }
            }
            this.$store.commit('removeTag', name)
            this.$store.commit('closePage', name)
            pageOpenedList = this.$store.state.app.pageOpenedList
            localStorage.pageOpenedList = JSON.stringify(pageOpenedList)
            if (this.currentPageName === name) {
                this.linkTo(lastPageObj)
            }
        },
        linkTo(item) {
            let routerObj = {}
            routerObj.name = item.name
            if (item.argu) {
                routerObj.params = item.argu
            }
            if (item.query) {
                routerObj.query = item.query
            }
            if (this.beforePush(item)) {
                this.$router.push(routerObj)
            }
        },
        handlescroll(e) {
            var type = e.type
            let delta = 0
            if (type === 'DOMMouseScroll' || type === 'mousewheel') {
                delta = e.wheelDelta ? e.wheelDelta : -(e.detail || 0) * 40
            }
            if (delta > 0) {
                this.seeRightTag(delta)
            } else {
                this.seeLeftTag(-delta)
            }
        },
        handleTagsOption(type) {
            switch (type) {
                case 'clearAll':
                    this.$store.commit('clearAllTags', this)
                    break

                case 'clearOthers':
                    this.$store.commit('clearOtherTags', this)
                    break

                case 'clearTag':
                    this.$store.commit('clearCurrentTag', this)
                    break

                case 'clearLefts':
                    this.$store.commit('clearLeftsTag', this)
                    break

                case 'clearRights':
                    this.$store.commit('clearRightsTag', this)
                    break

                case 'refreshTag':
                    this.reload()
                    break
            }
            this.tagBodyLeft = 0
        },
        moveToView(tag) {
            let rightWidth = 0

            // 标签在可视区域左侧
            if (tag.offsetLeft < -this.tagBodyLeft) {
                this.tagBodyLeft = -tag.offsetLeft // 标签在可视区域右侧
            } else if ((rightWidth = this.tagBodyLeft + tag.offsetLeft + tag.offsetWidth - this.viewWidth())) {
                if (this.tagBodyLeft - rightWidth > 0) {
                    this.tagBodyLeft = 0
                } else {
                    this.tagBodyLeft -= rightWidth
                }
            }
        },
        seeLeftTag(step) {
            if (this.refsTag.length == 0 || this.tagBodyLeft >= 0) {
                return
            }

            step = step || 150

            if (this.tagBodyLeft + step > 0) {
                this.tagBodyLeft = 0
            } else {
                this.tagBodyLeft += step
            }
        },
        seeRightTag(step) {
            let viewWidth = this.viewWidth()
            let bodyWidth = 0
            this.refsTag.forEach((item, index) => {
                bodyWidth += this.refsTag[index].$el.offsetWidth
            })
            let max = bodyWidth - viewWidth

            if (!max || -this.tagBodyLeft >= max) {
                return
            }

            step = step || 150

            if (-(this.tagBodyLeft - step) >= max) {
                this.tagBodyLeft = -max
            } else {
                this.tagBodyLeft -= step
            }
        },
        viewWidth() {
            return (
                this.$refs.scrollCon.offsetWidth -
                this.$refs.leftmoveTagCon.offsetWidth -
                this.$refs.closeAllTagCon.offsetWidth -
                this.$refs.tagDashboardCon.offsetWidth
            )
        },
    },
    mounted() {
        this.refsTag = this.$refs.tagsPageOpened || []

        // 这里不设定时器就会有偏移bug
        setTimeout(() => {
            this.refsTag.forEach((item, index) => {
                if (this.$route.name === item.name) {
                    let tag = this.refsTag[index].$el
                    this.moveToView(tag)
                }
            })
        }, 1)

        this.tagsCount = this.tagsList.length
    },
    watch: {
        $route(to) {
            this.currentPageName = to.name
            this.$nextTick(() => {
                this.refsTag.forEach((item, index) => {
                    if (to.name === item.name) {
                        let tag = this.refsTag[index].$el
                        this.moveToView(tag)
                    }
                })
            })
            this.tagsCount = this.tagsList.length
        },
    },
}
