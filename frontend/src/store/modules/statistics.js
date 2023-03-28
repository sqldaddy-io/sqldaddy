import API from "@/api";
import config from "@/config";

export const statisticsModule = {
    state: () => ({
        isLoading: false,
        statistics: [],
    }),
    getters: {
        getStatistics: state => state.statistics.sort((a, b) => b.all_time - a.all_time),
        getStatistic:(state) => (id) => {
            return (state.statistics).find(x => x.id === id);
        },
    },
    mutations: {
        setStatistics(state, data) {
            state.statistics = data;
        },
        setLoading(state, data) {
            state.isLoading = data;
            if(data === true){
                state.statistics = [
                    {
                        all_time:999999,
                        id:99,
                        last_7_days:9999,
                        last_90_days:999,
                        versions: [
                            {
                                id: 99,
                                name: 99,
                            },
                            {
                                id: 99,
                                name: 99,
                            },
                            {
                                id: 99,
                                name: 99,
                            },
                            {
                                id: 99,
                                name: 99,
                            },
                            {
                                id: 99,
                                name: 99,
                            },
                            {
                                id: 99,
                                name: 99,
                            },
                            {
                                id: 99,
                                name: 99,
                            }
                        ],
                        name:"MockupDB1" ,
                    },
                    {
                        all_time:999999,
                        id:99,
                        last_7_days:9999,
                        last_90_days:999,
                        versions: [
                            {
                                id: 99,
                                name: 99,
                            },
                            {
                                id: 99,
                                name: 99,
                            },
                            {
                                id: 99,
                                name: 99,
                            },
                            {
                                id: 99,
                                name: 99,
                            },
                            {
                                id: 99,
                                name: 99,
                            },
                            {
                                id: 99,
                                name: 99,
                            },
                            {
                                id: 99,
                                name: 99,
                            }
                        ],
                        name:"MockupDB2" ,
                    },
                    {
                        all_time:999999,
                        id:99,
                        last_7_days:9999,
                        last_90_days:999,
                        versions: [
                            {
                                id: 99,
                                name: 99,
                            },
                            {
                                id: 99,
                                name: 99,
                            },
                            {
                                id: 99,
                                name: 99,
                            },
                            {
                                id: 99,
                                name: 99,
                            },
                            {
                                id: 99,
                                name: 99,
                            },
                            {
                                id: 99,
                                name: 99,
                            },
                            {
                                id: 99,
                                name: 99,
                            }
                        ],
                        name:"MockupDB3" ,
                    },
                ];
            }
        },
    },
    actions: {
        loadStatistics({state, commit}){
            commit('setLoading', true);
            commit('setError', null,  { root: true });
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
            }).finally(() => {
                commit('setLoading', false);
            });
            return state.databases;
        }
    },
    namespaced: true
}

