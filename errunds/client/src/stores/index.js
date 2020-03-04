import Vuex from '@/plugins/vuex';
import user from '@/stores/modules/user'
import booking from '@/stores/modules/booking'

export default new Vuex.Store({
    modules: {
        user,
        booking
    },
    state:{
        apiHost:"http://localhost",
        apiPort:"8080",
        apiBasePath:"/tpws/errunds/server/api"
    },
    mutations:{},
    actions:{}
})