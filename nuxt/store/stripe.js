export const state = () => ({
    client_secret: ''
  })
  
  export const getters = {
    getClientSecret(state) {
      return state.client_secret
    }
  }
  
  export const mutations = {
    setClientSecret(state, data) {
      state.client_secret = data
    }
  }
