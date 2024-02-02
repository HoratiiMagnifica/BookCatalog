import axios from 'axios'
import {router} from '../router.js'

export default {
    namespaced: true,
    state: {
        authenticated: false,
        user: {},
        isAdmin: false, // Добавляем поле для определения администратора
    },
    getters: {
        authenticated(state) {
            return state.authenticated;
        },
        user(state) {
            return state.user;
        },
        isAdmin(state) {
            return state.isAdmin; // Геттер для определения администратора
        },
    },
    mutations: {
        SET_AUTHENTICATED(state, value) {
            state.authenticated = value;
        },
        SET_USER(state, value) {
            state.user = value;
        },
        SET_ADMIN(state, value) { // Мутация для установки статуса администратора
            state.isAdmin = value;
        },
    },
    actions: {
        async login({commit}) {
            try {
                const response = await axios.get('/api/user');
                console.log('User data from server:', response.data);

                const user = response.data;
                commit('SET_USER', user);
                commit('SET_AUTHENTICATED', true);

                // Проверяем, является ли пользователь администратором
                const isAdmin = user && user.is_admin === 1; // Используем is_admin и сравниваем с 1
                console.log('Is admin:', isAdmin);

                commit('SET_ADMIN', isAdmin);
            } catch (error) {
                console.error('Ошибка при входе:', error.message);
                commit('SET_USER', {});
                commit('SET_AUTHENTICATED', false);
                commit('SET_ADMIN', false);
            }
        },
        logout({commit}) {
            commit('SET_USER', {});
            commit('SET_AUTHENTICATED', false);
            commit('SET_ADMIN', false); // Сбрасываем статус администратора при выходе
        },
    },
}
