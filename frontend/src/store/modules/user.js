import { getToken, setToken, removeToken } from '@/utils/auth'

const user = {
  state: {
    token: getToken(),
    menus: [],
    rules: [],
    users: {}
  },

  mutations: {
      setToken: (state, token) => {
        state.token = token
      },
      setMenus(state, menus) {
        state.menus = menus
      },
      setRules(state, rules) {
        state.rules = rules
      },
      setUsers(state, users) {
        state.users = users
      }
  },

  actions: {
      login ({ commit }, data) {
        commit('setToken', data.authKey)
        commit('setMenus', data.menusList)
        commit('setRules', data.authList)
        commit('setUsers', data.userInfo)

        setToken(data.authKey)
        localStorage.setItem('menus', JSON.stringify(data.menusList))
        localStorage.setItem('authList', JSON.stringify(data.authList))
        localStorage.setItem('userInfo', JSON.stringify(data.userInfo))
      },
      loginStorage ({ commit }) {
        let userInfo = localStorage.getItem('userInfo')
        let authList = localStorage.getItem('authList')
        let menus = localStorage.getItem('menus')

        userInfo = userInfo ? JSON.parse(userInfo) : []
        authList = authList ? JSON.parse(authList) : []
        menus = menus ? JSON.parse(menus) : []

        commit('setMenus', menus)
        commit('setRules', authList)
        commit('setUsers', userInfo)
      },
      setToken({ commit }, token) {
        commit('setToken', token)
        setToken(token)
      },
      setMenus({ commit }, menus) {
        commit('setMenus', menus)
        localStorage.setItem('menus', JSON.stringify(menus))
      },
      setRules({ commit }, rules) {
        commit('setRules', rules)
        localStorage.setItem('authList', JSON.stringify(rules))
      },
      setUsers({ commit }, users) {
        commit('setUsers', users)
        localStorage.setItem('authList', JSON.stringify(users))
      }
  }
}

export default user
