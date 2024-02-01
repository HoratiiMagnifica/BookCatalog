import axios from 'axios'
import {router} from '../router.js'

export default {
    namespaced: true,
    state:{
        authenticated:false,
        user:{}
    },
    getters:{
        authenticated(state){
            return state.authenticated
        },
        user(state){
            return state.user
        }
    },
    mutations:{
        SET_AUTHENTICATED (state, value) {
            state.authenticated = value
        },
        SET_USER (state, value) {
            state.user = value
        }
    },
    actions: {
        async login({ commit }) {
            try {
                const response = await axios.post('/login'); // Используйте правильный маршрут для аутентификации
                const userResponse = await axios.get('/api/user');
                const user = userResponse.data;

                commit('SET_USER', user);
                commit('SET_AUTHENTICATED', true);

                router.push({ name: 'home' });
            } catch (error) {
                console.error('Error logging in:', error.message);
                commit('SET_USER', {});
                commit('SET_AUTHENTICATED', false);
            }
        },
        logout({ commit }) {
            commit('SET_USER', {});
            commit('SET_AUTHENTICATED', false);
        },
    },
}
