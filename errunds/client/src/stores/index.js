import Vuex from '@/plugins/vuex';
import user from '@/stores/modules/user'
import booking from '@/stores/modules/booking'

export default new Vuex.Store({
    modules: {
        user,
        booking
    },
    state:{
        apiHost : process.env.VUE_APP_API_HOST,
        apiPort : process.env.VUE_APP_API_PORT,
        apiBasePath : process.env.VUE_APP_API_BASE_PATH
    },
    mutations:{},
    actions:{}
})