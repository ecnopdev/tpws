import Vuex from '@/plugins/vuex';
import user from '@/stores/modules/user'
import booking from '@/stores/modules/booking'
import worker from '@/stores/modules/worker'
import job from '@/stores/modules/job'

export default new Vuex.Store({
    modules: {
        user,
        booking,
        worker,
        job
    },
    state:{
        apiHost : process.env.VUE_APP_API_HOST,
        apiPort : process.env.VUE_APP_API_PORT,
        apiBasePath : process.env.VUE_APP_API_BASE_PATH,
        isSnackBarVisible:false,
        snackBarText: "SnackBar text."
    },
    getters: {
        getSnackBarText : state => {return state.snackBarText},
        checkSnackBarVisible : state => {return state.isSnackBarVisible}
    },
    mutations:{
        showSnackBar : state => { state.isSnackBarVisible = true},
        hideSnackBar : state => { state.isSnackBarVisible = false},
        setSnackBarText : (state,newMessage) => {
            state.snackBarText = newMessage;
        }
    },
    actions:{}
})