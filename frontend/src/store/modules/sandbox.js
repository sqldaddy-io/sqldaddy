import API from "@/api";
import router from "@/router";
import config from "@/config";
import json2md from "json2md";
export const sandboxModule = {
    state: () => ({
        'isLoadingContent': false, // for loading content
        'isLoading': false, // for spinner on "run button"
        'mercureEventSource': null,
        'page': {
            'databaseVersion': null,
            'scripts': [],
        }
    }),
    getters: {
        getScriptRequest: (state) => (index) => {
            return state.page.scripts[index].request;
        },
        getScriptResponse: () => (data) => {
            let responses = [];
            Object.values(data).forEach(value=> {
                if(typeof value === 'object' || value instanceof Object){

                    let without_result = false;
                    Object.values(value).forEach(value_row => {
                        if(Object.values(value_row).length === 0){
                            without_result = true;
                        }
                    });
                    if( Object.values(value).length === 0 || without_result === true){
                        responses.push({ blockquote: "completed " + ((Object.keys(value).length>0)?Object.keys(value).length:'') });
                    }else {
                        let header = [];
                        Object.values(value).forEach(value_row => {
                            header = Object.keys(value_row);
                        });
                        responses.push({ table: { headers: header, rows: JSON.parse((JSON.stringify(value)).toString().replaceAll('null','"null"')) }, hr:'' });
                    }

                }else if( typeof value === 'string' || value instanceof String){
                    responses.push({ h5: value});
                }
            });
            if(responses.length>0){
                return json2md(responses);
            }
            return '';
        },
        getDatabaseName: (state) => {
            if(state.page?.databaseVersion?.database?.name === undefined){
                return null;
            }

            return state.page?.databaseVersion?.database?.name + ' ' + state.page?.databaseVersion?.name;
        },
        validate: (state) => {
            let is_empty = true;
            Object.values(state.page.scripts).forEach(value_row => {
                if(value_row.request.toString().trim().length !== 0){
                    is_empty = false;
                }
            });
            if(is_empty){
                return 'You cannot send blank fields. Please enter your sql query';
            }
            return true;
        },
    },
    mutations: {
        setDatabaseVersionObject(state, data) {
            state.page.databaseVersion = data;
            if( state.page?.databaseVersion?.database?.name){
                this.commit('setMetaTitle', state.page?.databaseVersion?.database?.name + ' ' + state.page?.databaseVersion?.name, {root: true});
            }
        },
        setLoading(state, data) {
            state.isLoading = data;
        },
        setLoadingContent(state, data) {
            state.isLoadingContent = data;
        },

        setPathPage(state, path) {
            if (state.page.path !== path) {
                state.page.path = path;
            }
        },
        setPage(state, page) {
            if (page.scripts.constructor === Object) {
                page.scripts = Object.values(page.scripts);
            }
            state.page = page;
        },
        setScripts(state, data) {
            state.page.scripts = data;
        },
        updateScriptRequest(state, data) {
            state.page.scripts[data.id].request = data.value;
        },
        addScriptRow(state) {
            state.page.scripts.push({
                'request': '\n' +
                    '\n' +
                    '\n' +
                    '\n' +
                    '\n' +
                    '\n' +
                    '\n',
                'response': [],
            });
        },
    },
    actions: {

        resetPage({state, commit}) {
            if(!confirm('Are you sure? This will remove all existing Schema and Query SQL.')){
                return false;
            }
            if (state.mercureEventSource) {
                state.mercureEventSource.close()
            }
            commit('setError', null, {root: true});
            commit('setPathPage', '');
            delete state.page.scripts;
            commit('setScripts', []);
            commit('setLoading', false)
            commit('setLoadingContent', false)
            commit('addScriptRow')
            router.push({name: 'page:index'})
        },
        setPathPage({commit, dispatch}, path) {
            commit('setPathPage', path)
            dispatch('loadPage')
        },
        initMercure({state, dispatch}) {
            let server = new URL(config.hostname + '/.well-known/mercure');
            server.searchParams.append('topic', '/pages/' + state.page.path);
            if (state.mercureEventSource) {
                if (state.mercureEventSource.url !== server.href) {
                    state.mercureEventSource.close();
                }else {
                    return false;
                }
            }
            state.mercureEventSource = new EventSource(server);
            state.mercureEventSource.onmessage = event => {
                dispatch('setPage', JSON.parse(event.data));
            };
            return true;
        },
        setPage({state, commit, dispatch}, page){
            commit('setPage', page);
            state.isLoading = !(state.page?.status === config.statuses.COMPLETED_SUCCESS);
            switch(state.page?.status) {
                case config.statuses.CREATED:
                    dispatch('initMercure');
                    state.mercureEventSource.onopen = () => {
                        dispatch('patch');
                    };
                    break;
                case config.statuses.IN_PROGRESS:
                    dispatch('initMercure');
                    break;
                case config.statuses.COMPLETED_ERROR:
                    state.isLoading = false;
                    commit('setError', 'Ooops. Something went wrong. Please try again later :(', {root: true});
                    break;

            }
        },
        loadPage({state, commit, dispatch}) {
            commit('setError', null, {root: true});
            commit('setLoadingContent', true);
            let axiosConfig = {
                headers: {
                    'accept': 'application/json',
                }
            };
            API.get(config.hostname + '/api/pages/' + state.page.path, axiosConfig).then((response) => {
                dispatch('setPage', response.data);
                commit('setLoadingContent', false);
            }).catch((err) => {
                commit('setError', err.response?.data?.message, {root: true});
                if (!state.error) {
                    commit('setError', err.message, {root: true});
                }
                commit('setLoadingContent', false);
            });
        },
        initPage({state, commit, getters, dispatch}) {
            if(getters.validate !== true){
                commit('setError', getters.validate, {root: true});
                return false;
            }
            if (state.page.path) {
                dispatch("update");
            } else {
                dispatch("create");
            }
        },
        create({state, commit, dispatch}){
            commit('setError', null, {root: true});
            commit('setLoading', true);
            let axiosConfig = {
                headers: {
                    'accept': 'application/json',
                }
            };
            let request = Object.assign({}, state.page);
            request.databaseVersion = '/api/database_versions/' + state.page.databaseVersion.id;
            delete request.id;
            API.post(config.hostname + '/api/pages', request, axiosConfig).then((response) => {
                dispatch('setPage', response.data);
                router.push({name: 'page:index', params: {path: state.page.path}})
            }).catch((err) => {
                commit('setError', err.response?.data?.message, {root: true});
                if (!state.error) {
                    commit('setError', err.message, {root: true});
                }
            });
        },
        update({state, commit, dispatch}){
            commit('setError', null, {root: true});
            commit('setLoading', true);
            let axiosConfig = {
                headers: {
                    'accept': 'application/json',
                }
            };
            let request = Object.assign({}, state.page);
            request.databaseVersion = '/api/database_versions/' + state.page.databaseVersion.id;
            Object.values(request.scripts).forEach(script => {
                script.response = [];
            });
            API.put(config.hostname + '/api/pages/' + request.path, request, axiosConfig).then((response) => {
                dispatch('setPage', response.data);
                router.push({name: 'page:index', params: {path: state.page.path}})
            }).catch((err) => {
                commit('setError', err.response?.data?.message, {root: true});
                if (!state.error) {
                    commit('setError', err.message, {root: true});
                }
            });
        },
        patch({state, commit, dispatch}){
            let axiosConfig = {
                headers: {
                    'accept': 'application/json',
                    'Content-Type': 'application/merge-patch+json',
                }
            };
            let request = {
                status: config.statuses.PENDING
            };
            API.patch(config.hostname + '/api/pages/' + state.page.path, request, axiosConfig).then((response) => {
                dispatch('setPage', response.data);
            }).catch((err) => {
                commit('setError', err.response?.data?.message, {root: true});
                if (!state.error) {
                    commit('setError', err.message, {root: true});
                }
            });
        }
    },
    namespaced: true
}
