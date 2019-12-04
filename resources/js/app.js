window.axios = require("axios");
window.axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";

import Vue from "vue";
import PortalVue from "portal-vue";
import router from "./router";
import store from "./store";
import App from "./App.vue";

Vue.use(PortalVue);

new Vue({
  router,
  store,
  render: h => h(App)
}).$mount("#app");
