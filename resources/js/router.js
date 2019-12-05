import Vue from "vue";
import VueRouter from "vue-router";

import Home from "./pages/Home";
import Park from "./pages/Park";
import Pay from "./pages/Pay";
import Exit from "./pages/Exit";

Vue.use(VueRouter);

export default new VueRouter({
  mode: "history",
  routes: [
    {
      path: "/park",
      name: "park",
      component: Park
    },
    {
      path: "/pay",
      name: "pay",
      component: Pay
    },
    {
      path: "/exit",
      name: "exit",
      component: Exit
    },
    {
      path: "/",
      name: "home",
      component: Home
    },
    {
      path: "*",
      redirect: "/"
    }
  ]
});
