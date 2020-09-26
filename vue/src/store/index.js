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
        },
        logout(state) {
            state.token = '';
            state.isAuthenticated = false;

            state.user = {};
            localStorage.removeItem('_token');
        }
    },
    actions: { //Asynchronous Actions
        async getAndSetAuthenticatedUser(state) {
            const res = await axios.get('http://localhost:8000/api/user', {
                headers: {
                    'Accept': 'application/json',
                    'Authorization': `Bearer ${localStorage.getItem('_token')}`
                }
            });

            state.commit('setUserAsAuthenticated', res.data);
        },
        setToken(state) {
            state.commit('setToken');
        },
        logout(state) {
            axios.post('http://localhost:8000/api/logout', {
                headers: {
                    'Accept': 'application/json',
                    'Authorization': `Bearer ${localStorage.getItem('_token')}`
                }
            }).then((res) => {
                if (res.status === 200) {
                    state.commit('logout');
                }
            }).catch(err => {
                console.log(err);
            });
        }
    },
    modules: {},
    getters: {
        getAuthenticatedUser: state => state.user
    }
})