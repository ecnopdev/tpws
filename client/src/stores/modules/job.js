import Vue from 'vue'

export default {
    namespaced: true,
    state: {},
    getters: {},
    mutations: {},
    actions: {
        getAll: (context) => {
            const apiPath = `${context.rootState.apiHost}:${context.rootState.apiPort}${context.rootState.apiBasePath}`;
            const accessToken = context.rootState.user.accessToken;

            return Vue.axios.get(`${apiPath}/job/read_jobs.php`,{
                headers: { 'Authorization': accessToken }
            })
        }
    },
}