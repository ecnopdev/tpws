import Vue from 'vue'

export default {
    namespaced:true,
    state:{
        activeUser: "Jose"
    },
    getters:{
        getActiveUser(state) {
            return state.activeUser;
        }
    },
    mutation:{},
    actions:{
        create: (context) => {       
            const apiPath = `${context.rootState.apiHost}:${context.rootState.apiPort}${context.rootState.apiBasePath}`;
            
            const payload = {
                name: "Test User name",
                type: "Customer",
            };

            Vue.axios.post(`${apiPath}/user/createUser.php`,{payload})
            .then(results => console.log(results))
            .catch(error => console.log(error));
        }
    },
}