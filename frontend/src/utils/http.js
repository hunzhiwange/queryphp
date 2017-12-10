import service from './request'

const apiMethods = {
    methods: {
        apiGet(url, data, params) {
            return this.api(url,data,'get', params)
        },
        apiPost(url, data, params) {
            return this.api(url,data,'post', params)
        },
        apiDelete(url, id, data, params) {
            return this.api(url + (id ? '/'+id : ''),data,'delete', params)
        },
        apiPut(url, id, data, params) {
            return this.api(url + (id ? '/'+id : ''),data,'put', params)
        },
        api(url, data, type, params) {
            data = data || {}
            type = type || 'get'
            params = params || {}
            return new Promise((resolve, reject) => {
                service({
                    url: url,
                    method: type,
                    data: data,
                    params: params
                }).then((response) => {
                    resolve(response)
                }, (response) => {
                    reject(response)
                })
            })
        }
    }
}

export default apiMethods
