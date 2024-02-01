<template>
    <div>
        <div>
            <div>
                <div>
                    <div>
                        <h1>Register</h1>
                        <hr/>
                        <form action="javascript:void(0)" @submit="register" method="post">
                            <div v-if="Object.keys(validationErrors).length > 0">
                                <div>
                                    <ul>
                                        <li v-for="(value, key) in validationErrors" :key="key">{{ value[0] }}</li>
                                    </ul>
                                </div>
                            </div>
                            <div>
                                <label for="name">Name</label>
                                <input type="text" name="name" v-model="name" id="name" placeholder="Enter name">
                            </div>
                            <div>
                                <label for="email">Email</label>
                                <input type="text" name="email" v-model="email" id="email" placeholder="Enter Email">
                            </div>
                            <div>
                                <label for="password">Password</label>
                                <input type="password" name="password" v-model="password" id="password"
                                       placeholder="Enter Password">
                            </div>
                            <div>
                                <label for="password_confirmation">Confirm Password</label>
                                <input type="password_confirmation" name="password_confirmation"
                                       v-model="password_confirmation" id="password_confirmation"
                                       placeholder="Enter Password">
                            </div>
                            <div>
                                <button type="submit" @click.prevent="register">
                                    Register
                                </button>
                            </div>
                            <div>
                                <label>Already have an account?
                                    <router-link :to="{name:'login'}">Login Now!</router-link>
                                </label>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import {mapActions} from 'vuex'
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
        register() {
            axios.get('/sanctum/csrf-cookie')
                .then(response => {
                    axios.post('/register', {
                        email: this.email,
                        password: this.password,
                        name: this.name,
                        password_confirmation: this.password_confirmation
                    })
                        .then(r => {
                            localStorage.setItem('x_xsrf_token', r.config.headers['X-XSRF-TOKEN'])
                            this.$router.push({name: 'home'})
                        })
                })
        }
    }
}
</script>

<style scoped>

</style>
