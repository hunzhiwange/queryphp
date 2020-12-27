import Vue from 'vue'
import errLog from '@/store/errLog'

// 生产环境错误日志
if (process.env.NODE_ENV === 'production') {
    Vue.config.errorHandler = function(err, vm) {
        errLog.pushLog({
            err,
            url: window.location.href,
            vm,
        })
    }
}
