import axios from 'axios'

// 创建 axios 实例
const service = axios.create({
    baseURL: BASE_API + '/admin/', // api 的 base_url
    timeout: 15000 // 请求超时时间
})

// request 拦截器
service.interceptors.request.use(config => {
    let apiToken = bus.$store.state.user.token
    if (apiToken) {
        config.headers['authKey'] = apiToken
    }
    config.headers['Content-Type'] = 'application/json'
    return config
}, error => {
    console.log(error)
    return Promise.reject(error)
})

// respone 拦截器
service.interceptors.response.use(response => {
    if (typeof response.data == 'object' &&　!response.data.message) {
        response.data.message = __('默认响应消息')
    }

    const res = response.data

    if (res.code) {
        switch (res.code) {
            case 200:
                return response.data
                break
            case 101:
                _g.warning(res.message, res.code)
                setTimeout(() => {
                    router.replace('/login')
                }, 1500)
                // 为了重新实例化 vue-router 对象,避免 bug
                // location.reload()
                break
            case 102:
                _g.warning(res.message, res.code)
                setTimeout(() => {
                    router.push({name: 'locking'});
                }, 1500)
                break
            case 103:
                _g.warning(res.message, res.code)
                setTimeout(() => {
                    router.replace('/login')
                }, 1500)
                // 为了重新实例化 vue-router 对象,避免 bug
                // location.reload()
                break
            case 400:
                _g.warning(res.message)
                break;
            default:
                _g.warning(res.message, res.code)
        }

        return Promise.reject(response.data)
        // return Promise.reject(`code: ${res.code}, message: ${res.message}`)
    }else {
        console.log(res)
        return Promise.reject('Return data is not a json')
    }
}, error => {
    console.log(error)
    _g.error(error.message)
    return Promise.reject(error)
})

export default service
