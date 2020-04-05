import Vue from 'vue'

export default {
    namespaced: true,
    state: {
        activeWorker: null
    },
    getters: {
        getActiveWorker(state) {
            return state.activeWorker;
        }
    },
    mutations: {
        setActiveWorker(context, params) {
            context.activeWorker = params;
        }
    },
    actions: {
        getAll: (context, params) => {
            const apiPath = `${context.rootState.apiHost}:${context.rootState.apiPort}${context.rootState.apiBasePath}`;
            console.log(params);
            const apiParams = `booking_date=${params.bookingDate}&start_time=${params.startTime}&end_time=${params.endTime}`;

            return Vue.axios.get(`${apiPath}/worker/read_workers.php?${apiParams}`);
        }
    },
}