import { createApp } from 'vue'
import App from './App.vue'
import router from './router'
import store from './store'

//Misc
import axios from 'axios'
axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
// axios.defaults.withCredentials = true;
// axios.defaults.baseURL = 'https://jsonplaceholder.typicode.com';
// axios.defaults.headers.common['Authorization'] = 'AUTH TOKEN';

createApp(App).use(store).use(router).mount('#app')