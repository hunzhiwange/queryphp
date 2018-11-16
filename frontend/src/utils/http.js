import service from "./request";

const apiMethods = {
    apiMultiData: [],
    apiMultiCalback: [],
    methods: {
        apiGet(url, data, params) {
            return this.api(url, data, "get", params);
        },
        apiPost(url, data, params) {
            return this.api(url, data, "post", params);
        },
        apiDelete(url, id, data, params) {
            return this.api(url + (id ? "/" + id : ""), data, "delete", params);
        },
        apiPut(url, id, data, params) {
            return this.api(url + (id ? "/" + id : ""), data, "put", params);
        },
        apiMulti(url) {
            if (arguments.length === 1) {
                return this.apiPost(url, {
                    api_multi: this.$options.apiMultiData
                });
            } else {
                arguments[0] = arguments[0].toUpperCase();

                let data = {
                    method: arguments[0]
                };

                if (["GET", "POST"].includes(arguments[0])) {
                    data.url = "admin/" + arguments[1];
                    data.data = arguments[2] ? arguments[2] : [];
                    data.url += arguments[3]
                        ? "?=" + this.param(arguments[3])
                        : "";
                } else {
                    data.url =
                        "admin/" +
                        arguments[1] +
                        (arguments[2] ? "/" + arguments[2] : "");
                    data.data = arguments[3] ? arguments[3] : [];
                    data.url += arguments[4]
                        ? "?=" + this.param(arguments[4])
                        : "";
                }

                this.$options.apiMultiData.push(data);
                // 尝试写一个空的回调,保证每一个 API 都有回调
                this.then(res => {}, true);
                return this;
            }
        },
        api(url, data, type, params) {
            data = data || {};
            type = type || "get";
            params = params || {};
            return new Promise((resolve, reject) => {
                service({
                    url: url,
                    method: type,
                    data: data,
                    params: params
                }).then(
                    response => {
                        resolve(response);
                    },
                    response => {
                        reject(response);
                    }
                );
            });
        },
        then(call, booPlace) {
            if (!booPlace) {
                this.$options.apiMultiCalback.pop();
            }
            this.$options.apiMultiCalback.push(call);
            return this;
        },
        thenCalback(res) {
            this.$options.apiMultiCalback.forEach((callback, index) => {
                callback(JSON.parse(res.data[index]));
            });
        },
        // https://www.cnblogs.com/wangbiao10086/p/7383090.html
        param(param, key) {
            let paramStr = "";
            if (["boolean", "string", "number"].includes(typeof param)) {
                paramStr += "&" + key + "=" + encodeURIComponent(param);
            } else {
                for (let i in param) {
                    let k =
                        key == null
                            ? i
                            : key +
                              (param instanceof Array
                                  ? "[" + i + "]"
                                  : "." + i);
                    paramStr += "&" + this.param(param[i], k);
                }
            }
            return paramStr.substr(1);
        }
    }
};

export default apiMethods;
