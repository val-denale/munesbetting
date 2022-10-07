export const state = () => ({
    plan: ''
  })
  
  export const getters = {
    getPlan(state) {
      return state.plan
    }
  }
  
  export const mutations = {
    setPlan(state, data) {
      state.plan = data
    }
  }
