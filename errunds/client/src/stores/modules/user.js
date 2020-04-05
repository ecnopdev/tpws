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
            
            //replace this code with the correct authentication function
            const customerID = params.username == 'usermike'? 1 : 2;
            Vue.axios.get(`${apiPath}/customer/read_single_customer.php?id=${customerID}`)
            .then(results => {
                context.commit('setActiveUser',results.data);
                params.vm.$router.push("/" + results.data.first_name);
            })
            .catch(error => console.log(error));
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