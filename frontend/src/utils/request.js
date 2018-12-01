import axios from 'axios'
import isJSON from 'validator/lib/isJSON'

// 创建 axios 实例
const service = axios.create({
    baseURL: ENV.BASE_API + '/:admin/', // api 的 base_url
    timeout: 15000, // 请求超时时间
})

// request 拦截器
service.interceptors.request.use(
    config => {
        let apiToken = bus.$store.state.user.token

        if (apiToken) {
            config.headers['token'] = apiToken
        }

        config.headers['Content-Type'] = 'application/json'
        return config
    },
    error => {
        return Promise.reject(error)
    }
)

// respone 拦截器
service.interceptors.response.use(
    response => {
        if ('object' !== typeof response.data) {
            utils.error('Response data must be JSON.')
            return Promise.reject()
        }

        if (!response.data.message) {
            response.data.message = __('操作成功')
        }

        if (response.data[':trace']) {
            delete response.data[':trace']
        }

        return response.data

        // const res = response.data
        // if (res.code) {
        //     switch (res.code) {
        //         case 200:
        //             return response.data
        //             break
        //         case 101:
        //             utils.warning(res.message, res.code)
        //             setTimeout(() => {
        //                 router.replace('/login')
        //             }, 1500)
        //             // 为了重新实例化 vue-router 对象,避免 bug
        //             // location.reload()
        //             break
        //         case 102:
        //             utils.warning(res.message, res.code)
        //             setTimeout(() => {
        //                 router.push({name: 'locking'});
        //             }, 1500)
        //             break
        //         case 103:
        //             utils.warning(res.message, res.code)
        //             setTimeout(() => {
        //                 router.replace('/login')
        //             }, 1500)
        //             // 为了重新实例化 vue-router 对象,避免 bug
        //             // location.reload()
        //             break
        //         case 400:
        //             utils.warning(res.message)
        //             break;
        //         default:
        //             utils.warning(res.message, res.code)
        //     }
        //     return Promise.reject(response.data)
        // } else {
        //     return Promise.reject([])
        // }
    },
    err => {
        if (err && err.response) {
            // switch (err.response.status) {
            //     case 400:
            //         err.message = '请求错误'
            //         break

            //     case 401:
            //         err.message = '未授权，请登录'
            //         break

            //     case 403:
            //         err.message = '拒绝访问'
            //         break

            //     case 404:
            //         err.message = '请求地址出错'
            //         break

            //     case 408:
            //         err.message = '请求超时'
            //         break

            //     case 500:
            //         err.message = '服务器内部错误'
            //         break

            //     case 501:
            //         err.message = '服务未实现'
            //         break

            //     case 502:
            //         err.message = '网关错误'
            //         break

            //     case 503:
            //         err.message = '服务不可用'
            //         break

            //     case 504:
            //         err.message = '网关超时'
            //         break

            //     case 505:
            //         err.message = 'HTTP版本不受支持'
            //         break

            //     default:
            // }

            if (isJSON(err.response.data.error.message)) {
                let tmp = JSON.parse(err.response.data.error.message)

                Object.keys(tmp).forEach(key => {
                    tmp[key].forEach(v => {
                        utils.error(v)
                    })
                })
            } else {
                utils.error(err.response.data.error.message)
            }

            if (401 === err.response.status) {
                setTimeout(() => {
                    bus.$store.dispatch('logout')
                    router.replace('/login')
                }, 1000)
            }
        }

        return Promise.reject(err)
    }
)

export default service
