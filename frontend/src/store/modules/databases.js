import API from "@/api";
import config from "@/config";

export const databasesModule = {
    state: () => ({
        databases: null,
    }),
    getters: {
        getDatabases: state => state.databases,
        getDatabase:(state) => (id) => {
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
                let db_version = response?.data[0]?.versions[0];
                db_version.database = response?.data[0];
                commit('sandbox/setDatabaseVersionObject', db_version, { root: true });
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
