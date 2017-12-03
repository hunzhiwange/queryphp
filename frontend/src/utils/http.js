const apiMethods = {
    methods: {
        apiGet(url, data) {
            return new Promise((resolve, reject) => {
                axios.get(url, data).then((response) => {
                    resolve(response.data)
                }, (response) => {
                    reject(response)
                    _g.closeGlobalLoading()
                    _g.warning('请求超时，请检查网络')
                })
            })
        },
        apiPost(url, data) {
            return new Promise((resolve, reject) => {
                axios.post(url, data).then((response) => {
                    resolve(response.data)
                }).catch((response) => {
                    resolve(response)
                    _g.warning('请求超时，请检查网络')
                })
            })
        },
        apiDelete(url, id) {
            return new Promise((resolve, reject) => {
                axios.delete(url + id).then((response) => {
                    resolve(response.data)
                }, (response) => {
                    reject(response)
                    _g.closeGlobalLoading()
                    _g.warning('请求超时，请检查网络')
                })
            })
        },
        apiPut(url, id, obj) {
            return new Promise((resolve, reject) => {
                axios.put(url + id, obj).then((response) => {
                    resolve(response.data)
                }, (response) => {
                    _g.closeGlobalLoading()
                    _g.warning('请求超时，请检查网络')
                    reject(response)
                })
            })
        },
        handelResponse(res, cb, errCb) {
            _g.closeGlobalLoading()
            if (res.code == 200) {
                cb(res.data)
            } else {
                if (typeof errCb == 'function') {
                    errCb()
                }
                this.handleError(res)
            }
        },
        handleError(res) {
            if (res.code) {
                switch (res.code) {
                    case 101:
                        _g.error(res.error)
                        setTimeout(() => {
                            router.replace('/login')
                        }, 1500)
                        break
                    case 103:
                        _g.error(res.error)
                        setTimeout(() => {
                            router.replace('/login')
                        }, 1500)
                        break
                    default:
                        _g.error(res.message)
                }
            } else {
                console.log('default error')
            }
        },
        resetCommonData(data) {
            _(data.menusList).forEach((res, key) => {
                if (key == 0) {
                    res.selected = true
                } else {
                    res.selected = false
                }
            })
            Lockr.set('menus', data.menusList) // 菜单数据
            Lockr.set('authKey', data.authKey) // 权限认证
            Lockr.set('authList', data.authList) // 权限节点列表
            Lockr.set('userInfo', data.userInfo) // 用户信息
            window.axios.defaults.headers.authKey = Lockr.get('authKey')
            
            let routerUrl = '/'
            setTimeout(() => {
                let path = this.$route.path
                if (routerUrl != path) {
                    router.replace(routerUrl)
                } else {
                    _g.shallowRefresh(this.$route.name)
                }
            }, 1000)
        },
        reAjax(url, data) {
            return new Promise((resolve, reject) => {
                axios.post(url, data).then((response) => {
                    resolve(response.data)
                }, (response) => {
                    reject(response)
                    _g.warning('请求超时，请检查网络')
                })
            })
        }
    },
    computed: {
        showLoading() {
            return store.state.globalLoading
        }
    }
}

export default apiMethods
