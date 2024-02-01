<template>
    <div >
        <div >
            <div >
                <div >
                    <div >
                        <h1 >Log In</h1>
                        <hr/>
                        <form action="javascript:void(0)"  method="post">
                            <div  v-if="Object.keys(validationErrors).length > 0">
                                <div >
                                    <ul >
                                        <li v-for="(value, key) in validationErrors" :key="key">{{ value[0] }}</li>
                                    </ul>
                                </div>
                            </div>
                            <div >
                                <label for="email" >Email</label>
                                <input type="text" v-model="email" name="email" id="email" >
                            </div>
                            <div >
                                <label for="password" >Password</label>
                                <input type="password" v-model="password" name="password" id="password" >
                            </div>
                            <div >
                                <button type="submit"  @click.prevent="login" >
                                    Login
                                </button>
                            </div>
                            <div >
                                <label>Don't have an account? <router-link :to="{name:'register'}">Register Now!</router-link></label>
                            </div>
                        </form>
                    </div>
                </div>
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
        async login(){
            axios.get('/sanctum/csrf-cookie')
                .then(response => {

                    axios.post('/login', {email: this.email, password: this.password})
                        .then(r => {
                            localStorage.setItem('x_xsrf_token', r.config.headers['X-XSRF-TOKEN'])
                            this.$router.push({name: 'home'})

                        })
                        .catch(err => {
                            console.log(err.response)
                        })
            });
        },
    }
}
</script>

<style scoped>

</style>
