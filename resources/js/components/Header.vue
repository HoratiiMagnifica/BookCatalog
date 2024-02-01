<script>
import axios from 'axios';

export default {
    data() {
        return {
            isLoggedIn: false,
            books: [],
            searchQuery: '',
            filteredBooks: [], // изменено с computed на data
        };
    },
    created() {
        // Проверка наличия токена при создании компонента
        this.checkAuth();
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

        async logout() {
            axios.post('/logout')
                .then( response => {
                    localStorage.removeItem('x_xsrf_token')

                    this.$router.push({name: 'login'})
                })
        },
        checkAuth() {
            const token = localStorage.getItem('x_xsrf_token');
            this.isLoggedIn = !!token;
        },

    },
    watch: {
        $route: 'checkAuth' // Вызывает checkAuth при изменении маршрута
    },
    mounted() {
        this.getAllBooks();
    },

}
</script>

<template>
    <header class="p-3 mb-3 border-bottom">
        <div class="container">
            <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
                <a href="/" class="d-flex align-items-center mb-2 mb-lg-0 text-dark text-decoration-none">
                    <svg class="bi me-2" width="40" height="32" role="img" aria-label="Bootstrap"><use xlink:href="#bootstrap"></use></svg>
                </a>

                <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
                    <router-link to="/" class="nav-link px-2 link-dark">Home</router-link>
                    <router-link to="/sections" class="nav-link px-2 link-dark">Sections</router-link>
                    <router-link to="/authors" class="nav-link px-2 link-dark">Authors</router-link>
                    <router-link to="/book/create" class="nav-link px-2 link-dark">Add Book</router-link>


                </ul>

                <form class="col-12 col-lg-auto mb-3 mb-lg-0 me-lg-0">
                    <input type="search" v-model="searchQuery" class="form-control" placeholder="Search..." aria-label="Search">

                </form>
                <button @click="searchBooks" class="btn btn-outline-primary col-12 col-lg-auto mb-3 mb-lg-0 me-lg-3 mr-auto" >Search</button>

                <div class="dropdown text-end">
                    <button class="btn btn-outline-primary" @click.prevent="logout">Logout</button>
                    <router-link v-if="!isLoggedIn" :to="{ name: 'login' }">
                        <button class="btn btn-outline-primary">Login</button>
                    </router-link>
                </div>
            </div>
        </div>
    </header>
</template>

<style scoped>

</style>
