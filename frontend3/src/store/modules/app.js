import Cookies from 'js-cookie'

const app = {
  state: {
      showLeftMenu: true,
      globalLoading: true,
      menus: [],
      rules: [],
      users: {},
      userGroups: [],
      organizes: [],
      visitedViews: []
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
      },
      ADD_VISITED_VIEWS: (state, view) => {
        if (state.visitedViews.some(v => v.path === view.path)) return
        state.visitedViews.push({ name: view.name, path: view.path })
      },
      DEL_VISITED_VIEWS: (state, view) => {
        let index
        for (const [i, v] of state.visitedViews.entries()) {
          if (v.path === view.path) {
            index = i
            break
          }
        }
        state.visitedViews.splice(index, 1)
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
      },
      addVisitedViews({ commit }, view) {
        commit('ADD_VISITED_VIEWS', view)
      },
      delVisitedViews({ commit, state }, view) {
        return new Promise((resolve) => {
          commit('DEL_VISITED_VIEWS', view)
          resolve([...state.visitedViews])
        })
      }
  }
}

export default app
