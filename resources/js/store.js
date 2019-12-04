import Vue from "vue";
import Vuex from "vuex";

Vue.use(Vuex);

export default new Vuex.Store({
  state: {
    rates: []
  },
  mutations: {
    UPDATE_RATES(state, rates) {
      state.rates = rates;
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
    }
  },
  getters: {
    rates: state => {
      return state.rates;
    },
    hasRates: state => {
      return state.rates.length > 0;
    }
  },
  strict: process.env.NODE_ENV !== "production"
});
