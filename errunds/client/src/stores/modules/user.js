import Vue from 'vue'

export default {
    namespaced:true,
    state:{
        activeUser: JSON.parse(localStorage.getItem('activeUser')) || null
    },
    getters:{
        getActiveUser(state) {
            return state.activeUser;
        }
    },
    mutations:{
        setActiveUser(context,params){
            context.activeUser = params;
            localStorage.setItem('activeUser',JSON.stringify(params));
        }
    },
    actions:{
        authenticate: (context,params) => {
            const apiPath = `${context.rootState.apiHost}:${context.rootState.apiPort}${context.rootState.apiBasePath}`;
            
            return Vue.axios.post(`${apiPath}/customer/login_customer.php`,{
                username:params.username,
                password:params.password
            });
        },
        signOut: (context,params) => {
            context.state.activeUser = null;
            localStorage.setItem('activeUser',null);
            params.vm.$router.push("/login");
        },
        update: (context,payload) => {    
            const apiPath = `${context.rootState.apiHost}:${context.rootState.apiPort}${context.rootState.apiBasePath}`;
           
            return Vue.axios.put(`${apiPath}/customer/update_customer.php`,payload);
            
        },
    },
}