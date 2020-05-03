import Vue from 'vue'

export default {
    namespaced:true,
    state:{
        activeUser: JSON.parse(localStorage.getItem('activeUser')) || null,
        activeRole: localStorage.getItem('activeRole') || null,
        accessToken: localStorage.getItem('accessToken') || null
    },
    getters:{
        getActiveUser(state) {
            return state.activeUser;
        },
        getActiveRole(state) {
            return state.activeRole;
        },
        getAccessToken(state) {
            return state.accessToken;
        }
    },
    mutations:{
        setActiveUser(context,params){
            context.activeUser = params;
            localStorage.setItem('activeUser',JSON.stringify(params));
        },
        setActiveRole(context,role){
            context.activeRole = role;
            localStorage.setItem('activeRole',role);
        },
        setAccessToken(context,token){
            context.accessToken = token;
            localStorage.setItem('accessToken',token);
        }
    },
    actions:{
        authenticate: (context,params) => {
            const apiPath = `${context.rootState.apiHost}:${context.rootState.apiPort}${context.rootState.apiBasePath}`;
            
            if(params.type == "Worker"){
                return Vue.axios.post(`${apiPath}/worker/login_worker.php`,{
                    username:params.username,
                    password:params.password
                });
            }else {
                return Vue.axios.post(`${apiPath}/customer/login_customer.php`,{
                    username:params.username,
                    password:params.password
                });
            }
        },
        signOut: (context,params) => {
            context.state.activeUser = null;
            localStorage.setItem('activeUser',null);
            params.vm.$router.push("/login");
        },
        update: (context,payload) => {    
            const apiPath = `${context.rootState.apiHost}:${context.rootState.apiPort}${context.rootState.apiBasePath}`;
            const accessToken = context.state.accessToken;
            const activeRole = context.state.activeRole;

            if(activeRole == "Worker"){
                return Vue.axios.put(`${apiPath}/worker/update_worker.php`, payload , { 
                    headers: { 'Authorization': accessToken }
                });
            }else {
                return Vue.axios.put(`${apiPath}/customer/update_customer.php`, payload , { 
                    headers: { 'Authorization': accessToken }
                });
            }
            
        },
    },
}