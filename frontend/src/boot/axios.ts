import { boot } from 'quasar/wrappers';
import axios from 'axios';
import { LocalStorage } from 'quasar';
const token = LocalStorage.getItem('token');
const api = axios.create({
  baseURL: process.env.BASE_URL,
  headers: {
    'Content-Type': 'application/json',
    Accept: 'application/json',
    Authorization: token ? `Bearer ${token}` : '',
  },
});

export default boot(({ app, router }) => {
  // for use inside Vue files (Options API) through this.$axios and this.$api

  app.config.globalProperties.$axios = axios;
  // ^ ^ ^ this will allow you to use this.$axios (for Vue Options API form)
  //       so you won't necessarily have to import axios in each vue file

  app.config.globalProperties.$api = api;
  // ^ ^ ^ this will allow you to use this.$api (for Vue Options API form)
  //       so you can easily perform requests against your app's API

  router.beforeEach((to, from, next) => {
    if (to.meta?.requiresAuth) {
    } else {
      next();
    }
    next();
  });
});

export { axios, api };
