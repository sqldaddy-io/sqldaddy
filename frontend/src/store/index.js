import { createStore } from 'vuex'
import {databasesModule} from "@/store/modules/databases";
import {sandboxModule} from "@/store/modules/sandbox";
import {statisticsModule} from "@/store/modules/statistics";


export default createStore({
  state: {
      meta: {
        title: 'Real-time SQL database environment',
        description: 'Open-source sandbox and environment for real-time SQL experimentation'
      },
      error: null
  },
  getters:{
    getTitle(state){
      return state.meta.title + ' | sql<>daddy.io'
    },
    getDescription(state){
      return state.meta.description;
    }
  },
  mutations: {
    setError(state, data) {
      state.error = data;
    },
    setMetaTitle(state, data = null) {
      if(data === null){
        data = 'Real-time SQL database environment'
      }
      state.meta.title = data;
    },
    setMetaDescription(state, data = null) {
      if(data === null){
        data = 'Open-source sandbox and environment for real-time SQL experimentation';
      }
      state.meta.description = data;
    },
  },
  actions: {
    setMetaTitle({commit}, data) {
      commit('setMetaTitle', data);
    },
    setMetaDescription({commit}, data) {
      commit('setMetaDescription', data);
    },
    updateMeta({state, getters}) {
      document.querySelector('title').innerHTML = getters.getTitle;
      document.querySelector('meta[name="description"]').setAttribute("content", state.meta.description);
    }
  },
  modules: {
    databases: databasesModule,
    statistics: statisticsModule,
    sandbox: sandboxModule
  }
})
