<script>
import axios from 'axios';

export default {
    data() {
        return {
            books: [],
            pagination: {},// Список разделов
        };
    },
    mounted() {
        this.fetchBooks('/api/latest_books'); // Получаем разделы при загрузке компонента
    },
    watch: {
        keywords(after, before) {
            this.fetch();
        }
    },
    methods: {
        async fetchBooks(url) {
            try {
                const response = await fetch(url);
                if (!response.ok) {
                    throw new Error('Не удалось получить данные');
                }

                const data = await response.json();

                // Преобразуем данные, добавляя поле 'coverUrl' для каждой книги
                this.books = Array.isArray(data.data)
                    ? data.data.map(book => ({ ...book, coverUrl: book.cover_image }))
                    : [];

                this.pagination = {
                    current_page: data.current_page,
                    last_page: data.last_page,
                    prev_page_url: data.prev_page_url,
                    next_page_url: data.next_page_url,
                    path: data.path,
                    pages: Array.from({ length: data.last_page }, (_, i) => i + 1),
                };
            } catch (error) {
                console.error('Ошибка при получении данных:', error.message);
            }
        },
        async searchBooks() {
            try {
                const response = await fetch(`/api/search?query=${this.searchQuery}`);
                if (!response.ok) {
                    throw new Error('Не удалось выполнить поиск книг');
                }
                const data = await response.json();

                this.books = data.map(book => ({
                    ...book,
                    coverUrl: book.cover_image,
                }));
            } catch (error) {
                console.error('Ошибка при выполнении поиска книг:', error.message);
            }
        },
    },
}
</script>

<template>

<div>
    <div class="card-container">
        <div v-for="book in books" :key="book.id" class="form" >
            <div class="card">
                <img :src="book.coverUrl" class="card-img-top" alt="...">
                <div class="card-body">


                    <router-link :to="{ name: 'book-details', params: { id: book.id }}" class="btn btn-primary">Читать</router-link>
                </div>
            </div>
            <div class="card-info">
                <h3 class="card-title"><b>{{ book.title }}</b></h3>
                <h4><i>{{  book.author.full_name  }} - {{  book.publication_year  }}</i></h4>
                <hr>
                <p>{{  book.description  }}</p>
                <hr style="margin-top: auto">
            </div>


        </div>
    </div>
</div>
<div>
    <nav>
        <ul class="pagination justify-content-center">
            <li v-if="pagination.prev_page_url" class="page-item">
                <a @click="fetchBooks(pagination.prev_page_url)" aria-label="Previous" class="page-link">
                    <span aria-hidden="true">&laquo;</span>
                </a>
            </li>
            <li v-for="page in pagination.pages" :key="page" :class="{ active: pagination.current_page === page }" class="page-item">
                <a @click="fetchBooks(pagination.path + '?page=' + page) " class="page-link">{{ page }}</a>
            </li>
            <li v-if="pagination.next_page_url" class="page-item">
                <a @click="fetchBooks(pagination.next_page_url)" aria-label="Next" class="page-link">
                    <span aria-hidden="true">&raquo;</span>
                </a>
            </li>
        </ul>
    </nav>
</div>
</template>

<style scoped>

.card-container {
    display: block;
    flex-wrap: wrap;
    justify-content: space-between; /* Распределение карточек по ширине контейнера */
    list-style: none;
    padding: 0;
    margin-left: 2rem;
}

.card {
    width: 18rem;
    height: 100%;
    margin-bottom: 10px;
}

.card-img-top {
    width: 100%;
    height: 24rem; /* Выберите подходящую высоту для ваших изображений */
    object-fit: cover; /* Сохраняет соотношение сторон и обрезает изображение при необходимости */
}

.card-body {
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    height: 100%;
}

.card-title {
    margin-bottom: 10px;
    text-align: left;
}

.form {
    display: flex;
}
.card-info {

    border: 1px solid;
    border-color: silver;
    border-radius: 5px;
    width: 100vh;
    height: 28.4rem ;
    padding-left: 5px;
    padding-right: 5px;
    word-wrap: break-word;
}
</style>
