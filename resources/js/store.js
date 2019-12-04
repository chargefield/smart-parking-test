import Vue from "vue";
import Vuex from "vuex";

Vue.use(Vuex);

export default new Vuex.Store({
  state: {
    rates: [],
    spaces: {
      spacesAvailable: 0,
      hasSpaces: false,
      totalSpaces: 0
    }
  },
  mutations: {
    UPDATE_RATES(state, rates) {
      state.rates = rates;
    },
    UPDATE_SPACES(state, spaces) {
      state.spaces = spaces;
    }
  },
  actions: {
    fetchRates({ commit, getters }) {
      if (getters.hasRates) {
        return;
      }

      axios.get("/api/rates").then(res => {
        commit("UPDATE_RATES", res.data);
      });
    },
    fetchSpacesAvailable({ commit }) {
      axios.get("/api/spaces/available").then(res => {
        commit("UPDATE_SPACES", res.data);
      });
    }
  },
  getters: {
    rates: state => {
      return state.rates;
    },
    hasRates: state => {
      return state.rates.length > 0;
    },
    spaces: state => {
      return state.spaces;
    }
  },
  strict: process.env.NODE_ENV !== "production"
});
