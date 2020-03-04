import Vue from 'vue'

export default {
    namespaced:true,
    state:{},
    getters:{},
    mutation:{},
    actions:{
        create: (context) => {       
            const apiPath = `${context.rootState.apiHost}:${context.rootState.apiPort}${context.rootState.apiBasePath}`;
            
            const payload = {
                name: "Test User name",
                type: "House Keeping",
            };

            Vue.axios.post(`${apiPath}/booking/createBooking.php`,{payload})
            .then(results => console.log(results))
            .catch(error => console.log(error));
        }
    },
}