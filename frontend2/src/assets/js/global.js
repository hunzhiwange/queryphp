const commonFn = {
    j2s(obj) {
        return JSON.stringify(obj)
    },
    shallowRefresh(name) {
        router.replace({
            path: '/refresh',
            query: {
                name: name
            }
        })
    },
    closeGlobalLoading() {
        setTimeout(() => {
            store.dispatch('showLoading', false)
        }, 0)
    },
    openGlobalLoading() {
        setTimeout(() => {
            store.dispatch('showLoading', true)
        }, 0)
    },
    cloneJson(obj) {
        return JSON.parse(JSON.stringify(obj))
    },
    success(message, title) {
        bus.$Notice.success({
            title: title
                ? title
                : '',
            desc: message
        })
    },
    info(message, title) {
        bus.$Notice.info({
            title: title
                ? title
                : '',
            desc: message
        })
    },
    warning(message, title) {
        bus.$Notice.warning({
            title: title
                ? title
                : '',
            desc: message
        })
    },
    error(message) {
        bus.$Message.error(message)
    },
    clearVuex(cate) {
        store.dispatch(cate, [])
    },
    getHasRule(val) {
        const moduleRule = 'admin'
        let userInfo = Lockr.get('userInfo')
        if (userInfo.id == 1) {
            return true
        } else {
            let authList = moduleRule + Lockr.get('authList')
            return _.includes(authList, val)
        }
    }
}

export default commonFn
