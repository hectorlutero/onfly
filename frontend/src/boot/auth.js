import { LocalStorage, Notify } from 'quasar';


export default ({ router }) => {
  router.beforeEach((to, from, next) => {
    if (to.meta?.requiresAuth) {
      if (!LocalStorage.getItem('token')) {
        Notify.create({
          message: 'You must be logged in to access this page',
          color: 'negative',
          position: 'top',
        });
        next('/login');
      } else {
        next();
      }
    } else {
      next();
    }
    console.log(to.meta);
    if (to.meta?.isAdmin === true) {
      const user = LocalStorage.getItem('user');
      if (!user.is_admin) {
        Notify.create({
          message: 'You must be an admin to access this page',
          color: 'negative',
          position: 'top',
        });
        window.location.href = '/dashboard'
      }
    } else {
      next();
    }

    if (to.meta?.name === 'logout') {
      LocalStorage.remove('token');
      LocalStorage.remove('user');
      next('/login');
    }

  });

  // router.afterEach((to, from) => {
  //   console.log(to, from);
  // })
};
