<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h1>LogIn</h1>
                <hr />

                <form @submit.prevent="login">
                    <div v-if="Object.keys(validationErrors).length > 0">
                        <div>
                            <ul>
                                <li v-for="(value, key) in validationErrors" :key="key">{{ value[0] }}</li>
                            </ul>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Адрес электронной почты</label>
                        <input type="email" name="email" v-model="email" class="form-control" id="email" aria-describedby="emailHelp">
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Пароль</label>
                        <input type="password" name="password" v-model="password" class="form-control" id="password">
                    </div>
                    <div>
                        <button type="submit" class="btn btn-primary">
                            Login
                        </button>
                    </div>
                    <div>
                        <label>
                            Don't have an account? <router-link :to="{name:'register'}">Register Now!</router-link>
                        </label>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
import { mapActions } from 'vuex'
import axios from 'axios';

export default {
    name:"login",
    data(){
        return {
            email: null,
            password: null,
            validationErrors:{}
        }
    },
    methods:{
        async login() {
            await axios.get('/sanctum/csrf-cookie');

            try {
                const response = await axios.post('/login', {
                    email: this.email,
                    password: this.password,
                });

                localStorage.setItem('x_xsrf_token', response.config.headers['X-XSRF-TOKEN']);

                // Вызывайте действие Vuex login для установки данных пользователя и статуса аутентификации
                this.$store.dispatch('auth/login');
            } catch (error) {
                console.log(error.response);
            }
        },
    }
}
</script>

<style scoped>

</style>
