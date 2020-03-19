import VueRouter from '@/plugins/vue-router'
import Login from '@/components/Login'
import Dashboard from '@/components/Dashboard'

const routes = [
    { path: '/login', component: Login },
    { path: '/:name', component: Dashboard },
    { path: '/', component: Dashboard }
  ]

const router = new VueRouter({
  routes
});

router.beforeEach((to, from, next) => {
  console.log(from);
  console.log(to);
  console.log(router.app.$store.getters['user/getActiveUser']);
  if(router.app.$store.getters['user/getActiveUser'] !== null){
    if(to.path != "/"){ 
      next('/');
    }else{ 
      next();
    }
  }else{
    if(to.path != "/login"){
      next('/login');
    }else {
      next();
    }  
  }  
})


export default router;