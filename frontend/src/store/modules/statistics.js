import API from "@/api";
import config from "@/config";

export const statisticsModule = {
    state: () => ({
        statistics: [],
    }),
    getters: {
        getStatistics: state => state.statistics,
        getStatistic:(state) => (id) => {
            return (state.statistics).find(x => x.id === id);
        },
    },
    mutations: {
        setStatistics(state, data) {
            state.statistics = data;
        },
    },
    actions: {
        loadStatistics({state, commit}){
            let axiosConfig = {
                headers: {
                    'accept': 'application/json',
                }
            };
            API.get(config.hostname + '/api/statistics',  axiosConfig).then((response) => {
                commit('setStatistics', response.data);
            }) .catch((err) => {
                commit('setError',  err.response?.data?.message,  { root: true });
                if (!state.error) {
                    commit('setError', err.message,  { root: true });
                }
                commit('setStatistics', []);
            });
            return state.databases;
        }
    },
    namespaced: true
}

