import API from "@/api";
import config from "@/config";

export const databasesModule = {
    state: () => ({
        databases: null,
    }),
    getters: {
        getDatabases: state => state.databases,
        getDatabase:(state) => (id) => {
            if(!state.databases){
                return [];
            }
         return (state.databases).find(x => x.id === id);
       },
    },
    mutations: {
        setDatabases(state, data) {
            state.databases = data;
        },
        setDatabaseToSandBox(state, [db_id, version_id = null])  {
            let database = (state.databases).find(x => x.id === db_id);
            let version = null;
            if(version_id === null){
                version = database.versions[0];
            }else {
                version = database.versions.find(x => x.id === version_id);
            }
            version.database = database;
            this.commit('sandbox/setDatabaseVersionObject', version, { root: true });
        },
    },
    actions: {
        loadDatabases({state, commit}){
            if(state.databases){
                return true;
            }
            let axiosConfig = {
                headers: {
                    'accept': 'application/json',
                }
            };
            API.get(config.hostname + '/api/databases',  axiosConfig).then((response) => {
                commit('setDatabases', response.data);
                commit('setDatabaseToSandBox', [response?.data[0]?.id]);
            }) .catch((err) => {
                commit('setError',  err.response?.data?.message,  { root: true });
                if (!state.error) {
                    commit('setError', err.message,  { root: true });
                }
                commit('setDatabases', null);
            });
            return state.databases;
        }
    },
    namespaced: true
}
