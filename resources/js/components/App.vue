<template>
        <Header></Header>
    <div class="container">
        <div class="text-center" style="margin: 20px 0px 20px 0px;">
            <meta name="csrf-token" content="{{ csrf_token() }}">
            <span class="text-secondary">Book Catalog</span>
        </div>


        <br/>
        <scroll-to-top-button></scroll-to-top-button>
        <router-view></router-view>
    </div>
</template>

<script>
export default {}
</script>
