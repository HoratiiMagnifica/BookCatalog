<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h1>Register</h1>
                <hr />

                <form @submit.prevent="register" method="post">
                    <div v-if="Object.keys(validationErrors).length > 0">
                        <div>
                            <ul>
                                <li v-for="(value, key) in validationErrors" :key="key">{{ value[0] }}</li>
                            </ul>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="name">Name</label>
                        <input type="text" name="name" v-model="name" class="form-control" id="name" placeholder="Enter name">
                    </div>
                    <div class="mb-3">
                        <label for="email">Email</label>
                        <input type="text" name="email" v-model="email" class="form-control" id="email" placeholder="Enter Email">
                    </div>
                    <div class="mb-3">
                        <label for="password">Password</label>
                        <input type="password" name="password" v-model="password" class="form-control" id="password" placeholder="Enter Password">
                    </div>
                    <div class="mb-3">
                        <label for="password_confirmation">Confirm Password</label>
                        <input type="password" name="password_confirmation" v-model="password_confirmation" class="form-control" id="password_confirmation" placeholder="Enter Password">
                    </div>
                    <div>
                        <button type="submit" class="btn btn-primary">
                            Register
                        </button>
                    </div>
                    <div class="mt-3">
                        <label>
                            Already have an account? <router-link :to="{name:'login'}">Login Now!</router-link>
                        </label>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
import { mapActions, mapMutations } from 'vuex';
import axios from 'axios';

export default {
    name: 'register',
    data() {
        return {

            name: null,
            email: null,
            password: null,
            password_confirmation: null,
            validationErrors: {},
        }
    },
    methods: {
        ...mapActions('auth', ['login']),
        ...mapMutations('auth', ['SET_USER']),
        async register() {
            try {
                await axios.get('/sanctum/csrf-cookie');
                const response = await axios.post('/register', {
                    email: this.email,
                    password: this.password,
                    name: this.name,
                    password_confirmation: this.password_confirmation,
                });

                // Добавляем пользователя в хранилище после успешной регистрации
                const user = response.data.user;
                this.SET_USER(user);

                // Автоматически входим после регистрации (если это ваша логика)
                await this.login({ email: this.email, password: this.password });

                // Перенаправляем пользователя на домашнюю страницу
                this.$router.push({ name: 'home' });
            } catch (error) {
                console.error('Error registering:', error.message);
            }
        },
    }
}
</script>

<style scoped>

</style>
