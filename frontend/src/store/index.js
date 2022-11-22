import { createStore } from 'vuex'
import {databasesModule} from "@/store/modules/databases";
import {sandboxModule} from "@/store/modules/sandbox";


export default createStore({
  state: {
      meta: {
        title: 'Real-time SQL database environment',
        description: 'Open-source sandbox and environment for real-time SQL experimentation with PostgreSQL and MySQL',
      },
      error: null
  },
  getters:{
    getTitle(state){
      return state.meta.title + ' | sql<>daddy.io'
    }
  },
  mutations: {
    setError(state, data) {
      state.error = data;
    },
    setMetaTitle(state, data) {
      state.meta.title = data;
    },
  },
  actions: {
    updateMeta({state, getters}) {
      document.querySelector('title').innerHTML = getters.getTitle;
      document.querySelector('meta[name="description"]').setAttribute("content", state.meta.description);
    }
  },
  modules: {
    databases: databasesModule,
    sandbox: sandboxModule
  }
})
