import Vue from 'vue'

export default {
    namespaced: true,
    state: {},
    getters: {},
    mutation: {},
    actions: {
        create: (context, params) => {
            const apiPath = `${context.rootState.apiHost}:${context.rootState.apiPort}${context.rootState.apiBasePath}`;
            const payload = {
                creation_date: new Date().toISOString().substr(0, 10),
                booking_date: params.booking_date,
                start_time: params.start_time,
                end_time: params.end_time,
                status: "pending",
                rating: null,
                comments: "",
                customer_id: context.rootState.user.activeUser.id,
                worker_id: params.worker_id,
            };
            const accessToken = context.rootState.user.accessToken;

            return Vue.axios.post(`${apiPath}/booking/create_booking.php`, payload, {
                headers: { 'Authorization': accessToken }
            });

        },
        update: (context, payload) => {
            const apiPath = `${context.rootState.apiHost}:${context.rootState.apiPort}${context.rootState.apiBasePath}`;
            const accessToken = context.rootState.user.accessToken;

            return Vue.axios.put(`${apiPath}/booking/update_booking.php`, payload, {
                headers: { 'Authorization': accessToken }
            });

        },
        delete: (context, payload) => {
            const apiPath = `${context.rootState.apiHost}:${context.rootState.apiPort}${context.rootState.apiBasePath}`;
            const accessToken = context.rootState.user.accessToken;

            return Vue.axios.delete(`${apiPath}/booking/delete_booking.php`, {
                headers: { 'Authorization': accessToken },
                data : payload
            });

        },
        getAll: (context, params) => {
            const apiPath = `${context.rootState.apiHost}:${context.rootState.apiPort}${context.rootState.apiBasePath}`;
            const accessToken = context.rootState.user.accessToken;

            return Vue.axios.get(`${apiPath}/booking/read_customer_bookings.php?customer_id=${params.id}`, {
                headers: { 'Authorization': accessToken }
            });
        },
        getByID: (context, params) => {
            const apiPath = `${context.rootState.apiHost}:${context.rootState.apiPort}${context.rootState.apiBasePath}`;
            const accessToken = context.rootState.user.accessToken;

            return Vue.axios.get(`${apiPath}/booking/read_single_booking.php?id=${params.id}`, {
                headers: { 'Authorization': accessToken }
            });
        }
    },
}