import Cookies from 'js-cookie'

const app = {
  state: {
      showLeftMenu: true,
      globalLoading: true,
      menus: [],
      rules: [],
      users: {},
      userGroups: [],
      organizes: []
  },
  mutations: {
      showLeftMenu(state, status) {
          state.showLeftMenu = status
      },
      showLoading(state, status) {
          state.globalLoading = status
      },
      setMenus(state, menus) {
          state.menus = menus
      },
      setRules(state, rules) {
          state.rules = rules
      },
      setUsers(state, users) {
          state.users = users
      },
      setUserGroups(state, userGroups) {
          state.userGroups = userGroups
      },
      setOrganizes(state, organizes) {
          state.organizes = organizes
      }
  },
  actions: {
      showLeftMenu({
          commit
      }, status) {
          commit('showLeftMenu', status)
      },
      showLoading({
          commit
      }, status) {
          commit('showLoading', status)
      },
      setMenus({
          commit
      }, menus) {
          commit('setMenus', menus)
      },
      setRules({
          commit
      }, rules) {
          commit('setRules', rules)
      },
      setUsers({
          commit
      }, users) {
          commit('setUsers', users)
      },
      setUserGroups({
          commit
      }, userGroups) {
          commit('setUserGroups', userGroups)
      },
      setOrganizes({
          commit
      }, organizes) {
          commit('setOrganizes', organizes)
      }
  }
}

export default app
