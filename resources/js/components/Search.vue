<template>
    <div>
        <input v-model="searchQuery" placeholder="Введите название книги">
        <button @click="searchBooks">Поиск</button>

<!--        <ul>-->
<!--            <li v-for="book in filteredBooks" :key="book.id">-->
<!--                {{ book.title }}-->
<!--            </li>-->
<!--        </ul>-->
    </div>
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            books: [],
            searchQuery: '',
            filteredBooks: [], // изменено с computed на data
        };
    },
    methods: {
        getAllBooks() {
            axios.get('/api/books')
                .then(response => {
                    this.books = response.data;
                    this.filteredBooks = this.books; // инициализация при получении всех книг
                })
                .catch(error => {
                    console.error('Ошибка при получении книг', error);
                });
        },
        navigateToBookDetails(bookId) {
            this.$router.push({ name: 'book-details', params: { id: bookId } });
        },

        searchBooks() {
            if (this.searchQuery === '') {
                this.filteredBooks = this.books;
            } else {
                this.filteredBooks = this.books.filter(book => {
                    return book.title.toLowerCase().includes(this.searchQuery.toLowerCase());
                });

                // Если найдена только одна книга, переходим на ее страницу
                if (this.filteredBooks.length === 1) {
                    this.navigateToBookDetails(this.filteredBooks[0].id);
                }
            }
        },
    },
    mounted() {
        this.getAllBooks();
    },
};
</script>

<style scoped>
/* ваш стиль здесь */
</style>
