<template>
    <div >
        <div >
            <div >
                <div >
                    <div >
                        <h3>SPA Authentication using Laravel 10 Sanctum Vue 3 and Vite - Dashboard</h3>
                    </div>
                    <div >
                        <p >You are logged in as <b>{{user.email}}</b></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name:"dashboard",
    data(){
        return {
            user:this.$store.state.auth.user
        }
    }
}
</script>

<style scoped>

</style>
