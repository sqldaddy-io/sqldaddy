import API from "@/api";
import config from "@/config";
import router from '@/router'
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
            let axiosConfig = {
                headers: {
                    'accept': 'application/json',
                }
            };
            API.get(config.hostname + '/api/databases',  axiosConfig).then((response) => {
                commit('setDatabases', response.data);
                let db_id = null;
                let dbv_id = null;
                if(router.currentRoute?.value?.query?.database){
                   db_id = (state.databases).find(x => x.name === router.currentRoute?.value?.query.database)?.id;
                }
                if(!db_id){
                    db_id = response?.data[0]?.id;
                }
                if(router.currentRoute?.value?.query?.version){
                    dbv_id = ((state.databases).find(x => x.id === db_id).versions.find(x => x.name === router.currentRoute?.value?.query?.version))?.id;
                }
                if(!dbv_id){
                    dbv_id = null;
                }
                commit('setDatabaseToSandBox', [db_id, dbv_id]);
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
