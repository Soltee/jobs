import { createStore } from 'vuex'
import axios from 'axios';

export default createStore({
    state: {
        token: localStorage.getItem('_token') || '',
        user: {},
        isAuthenticated: false,
    },
    mutations: { //Synchronous Actions
        setUserAsAuthenticated(state, payload) {
            // console.log(payload);
            state.user = payload;
            (state.user) ? (state.isAuthenticated = true) : (state.isAuthenticated = false);
        },
        setToken(state) {
            state.token = localStorage.getItem('_token') || '';
        }
    },
    actions: { //Asynchronous Actions
        async getAndSetAuthenticatedUser(state) {
            const res = await axios.get('http://localhost:8000/api/test', {
                headers: {
                    'Accept': 'application/json',
                    'Authorization': `Bearer ${state.token}`
                }
            });
            // const res = await axios.get('http://localhost:8000/api/user', {
            //     headers: {
            //         'Accept': 'application/json'
            //     }
            // });
            console.log(res);
            state.commit('setUserAsAuthenticated', res.data);
        },
        setToken(state) {
            state.commit('setToken');
        }
    },
    modules: {},
    getters: {
        getAuthenticatedUser: state => state.user
    }
})