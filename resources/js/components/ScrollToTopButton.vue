<template>
    <div v-if="showButton" @click="scrollToTop" class="scroll-to-top-button">
        &#8679; Наверх
    </div>
</template>

<script>
export default {
    data() {
        return {
            showButton: false,
        };
    },
    mounted() {
        window.addEventListener('scroll', this.handleScroll);
    },
    beforeDestroy() {
        window.removeEventListener('scroll', this.handleScroll);
    },
    methods: {
        handleScroll() {
            this.showButton = window.scrollY > 500; // Показать кнопку, если прокрутка больше 200px
        },
        scrollToTop() {

            window.scrollTo({
                top: 0,
                behavior: 'smooth',
            });
        },
    },
};
</script>

<style scoped>
.scroll-to-top-button {
    position: fixed;
    bottom: 20px;
    right: 20px;
    background-color: #007bff;
    color: #fff;
    padding: 10px;
    cursor: pointer;
    border-radius: 5px;
    display: none;
}

.scroll-to-top-button {
    display: block;
}
</style>
