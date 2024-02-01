<template>
    <div>
        <nav >
            <div >
                <a  href="https://onlinecode.org/spa-authentication-laravel-10-sanctum-vue3-vite" target="_blank">onlinecode</a>
                <button  type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                    <span ></span>
                </button>
                <div  id="navbarNavDropdown">
                    <ul >
                        <li >
                            <router-link :to="{name:'dashboard'}" >Home <span >(current)</span></router-link>
                        </li>
                    </ul>
                    <div >
                        <ul >
                            <li >
                                <a  href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    {{ user.name }}
                                </a>
                                <div  aria-labelledby="navbarDropdownMenuLink">
                                    <a  href="javascript:void(0)" @click="logout">Logout</a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>
        <main >
            <router-view></router-view>
        </main>
    </div>
</template>

<script>
import {mapActions} from 'vuex'
export default {
    name:"default-layout",
    data(){
        return {
            user:this.$store.state.auth.user
        }
    },
    methods:{
        ...mapActions({
            signOut:"auth/logout"
        }),
        async logout(){
            await axios.post('/logout').then(({data})=>{
                this.signOut()
                this.$router.push({name:"login"})
            })
        }
    }
}
</script>

<style scoped>

</style>
