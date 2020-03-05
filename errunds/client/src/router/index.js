import VueRouter from '@/plugins/vue-router'
import Login from '@/components/Login'
import Dashboard from '@/components/Dashboard'

const routes = [
    { path: '/login', component: Login },
    { path: '/:name', component: Dashboard },
    { path: '/', component: Dashboard }
  ]

export default new VueRouter({
    routes
});