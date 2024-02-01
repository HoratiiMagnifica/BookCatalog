<script>
export default {
    name: 'book-details',
    data() {
        return {
            books: [],
        };
    },
    created() {
        // Получаем id из URL
        const id = parseInt(this.$route.params.id)


        if (!id) {
            console.error('ID не найден в параметрах маршрута');
            return;
        }

        this.fetchLatest();
    },
    methods: {
        async fetchLatest() {
            try {
                const id = parseInt(this.$route.params.id)
                console.log(id)
                const response = await fetch(`/api/books/${id}`);
                if (!response.ok) {
                    throw new Error('Не удалось получить детали книги');
                }
                this.books = await response.json();
                console.log(this.books);
            } catch (error) {
                console.error('Ошибка при получении деталей книги:', error.message);
            }
        },

    },
};
</script>

<template>
<div>
    <h3 class="text-center">{{  books.author.full_name  }}  -  {{books.title}}</h3>
    <p>{{books.content}}</p>
</div>
</template>

<style scoped>

</style>
