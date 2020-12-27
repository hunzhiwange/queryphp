import {getToken, setToken, removeToken} from '@/utils/auth'

const user = {
    state: {
        token: getToken(),
        menus: [],
        rules: [],
        users: {},
    },

    mutations: {
        setToken: (state, token) => {
            state.token = token
        },
        setRules(state, rules) {
            state.rules = rules
        },
        setUsers(state, users) {
            state.users = users
        },
    },

    actions: {
        login({commit}, data) {
            setToken(data.token, data.keepLogin)
        },
        loginStorage({commit}) {
            let userInfo = localStorage.getItem('userInfo')
            let authList = localStorage.getItem('authList')
            let menus = localStorage.getItem('menus')

            userInfo = userInfo ? JSON.parse(userInfo) : []
            authList = authList ? JSON.parse(authList) : []
            menus = menus ? JSON.parse(menus) : []

            commit('setToken', getToken())
            commit('setRules', authList)
            commit('setUsers', userInfo)
        },
        logout({commit}) {
            commit('setToken', '')
            commit('setRules', [])
            commit('setUsers', [])

            removeToken()

            localStorage.removeItem('menus')
            localStorage.removeItem('authList')
            localStorage.removeItem('userInfo')
        },
        setRules({commit}, rules) {
            rules = Object.assign({static: [], dynamic: []}, rules)
            commit('setRules', rules)
            localStorage.setItem('authList', JSON.stringify(rules))
        },
        setUsers({commit}, users) {
            commit('setUsers', users)
            localStorage.setItem('userInfo', JSON.stringify(users))
        },
    },
}

export default user
