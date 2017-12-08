import service from './request'

const apiMethods = {
    methods: {
        apiGet(url, data) {
            return this.api(url,data,'get')
        },
        apiPost(url, data) {
            return this.api(url,data,'post')
        },
        apiDelete(url, id, data) {
            return this.api(url + (id ? '/'+id : ''),data,'delete')
        },
        apiPut(url, id, data) {
            return this.api(url + (id ? '/'+id : ''),data,'put')
        },
        api(url, data, type) {
            data = data || {}
            type = type || 'get'
            return new Promise((resolve, reject) => {
                service({
                    url: url,
                    method: type,
                    params: data
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
