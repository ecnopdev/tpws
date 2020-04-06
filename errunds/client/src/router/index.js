import VueRouter from '@/plugins/vue-router'
import Login from '@/components/Login'
import Dashboard from '@/components/Dashboard'
import Profile from '@/components/Profile'
import Booking from '@/components/Booking'

const routes = [
    { path: '/login', component: Login },
    { path: '/profile', component: Profile },
    { path: '/', component: Dashboard },
    { path: '/booking/:id', component: Booking }
  ]

const router = new VueRouter({
  routes
});

router.beforeEach((to, from, next) => {
  const currentUser = router.app.$store.getters['user/getActiveUser'];
  if(currentUser == null){
    if(to.path != '/login'){
      next({
          path: '/login',
          params: { nextUrl: to.fullPath }
      });
    }else {
      next();
    }
  }else{
    if(to.path == '/login'){
      next({
        path: '/',
        params: { nextUrl: to.fullPath }
      });
    }else{
      next();
    }

  }  
})


export default router;