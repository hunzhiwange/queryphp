import Cookies from 'js-cookie'

const tokenKey = 'api-token'
const lockKey = 'user-lock'
const lastPageKey = 'lock-last-page'

export function getToken() {
    return Cookies.get(tokenKey)
}

export function setToken(token, keepLogin) {
    return Cookies.set(tokenKey, token, {
        expires: keepLogin === true ? 60 : null,
    })
}

export function removeToken() {
    return Cookies.remove(tokenKey)
}

export function isLock() {
    return Cookies.get(lockKey) == 1
}

export function lockLastPage() {
    return Cookies.get(lastPageKey)
}

export function lock(lastPage) {
    Cookies.set(lastPageKey, lastPage, {expires: 60})
    return Cookies.set(lockKey, 1, {expires: 60})
}

export function unlock() {
    return Cookies.set(lockKey, 0, {expires: 60})
}
