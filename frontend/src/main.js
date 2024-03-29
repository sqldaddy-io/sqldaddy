import { createApp } from 'vue'
import router from './router'
import store from './store'
import App from './App.vue'
import './assets/css/jquery-linedtextarea.css';
import './assets/css/main.css';
import './assets/js/jquery-linedtextarea.js';
import './assets/js/main.js';
import VueSocialSharing from 'vue-social-sharing'
createApp(App).use(router).use(store).use(VueSocialSharing).mount('#app')
