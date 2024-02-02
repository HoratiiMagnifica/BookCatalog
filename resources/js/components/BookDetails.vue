<script>
import BookContent from "./BookContent.vue";
import axios from "axios";
import {router} from "../router.js";


export default {
    name: 'book-details',
    computed: {
        BookContent() {
            return BookContent
        }
    },
    data() {
        return {
            books: [],
            isAdmin: false,
            isCheckingAdminStatus: true,
            userId: null,
            uploaderId: null,
            isAuthenticated: false,
        };
    },
    created() {
        // Получаем id из URL
        const id = parseInt(this.$route.params.id)
        this.isAdmin = this.checkAdminStatus();


        if (!id) {
            console.error('ID не найден в параметрах маршрута');
            return;
        }

        this.fetchLatest();

    },
    methods: {
        async toggleVisibility(bookId) {
            console.log(bookId)
            try {

                const updatedBook = await axios.put(`/api/books/${bookId}/toggle-visibility`, {
                    visible: !this.books.visible, // инвертировать значение
                });

                // Обновите свойство visible локально без повторного запроса на сервер
                this.books = updatedBook.data;
                console.log(this.books);
                this.fetchLatest()
            } catch (error) {
                console.error(error);
            }
        },
        async fetchLatest() {
            try {
                const id = this.$route.params.id
                console.log(id)
                const response = await fetch(`/api/books/${id}`);
                if (!response.ok) {
                    throw new Error('Не удалось получить детали книги');
                }
                this.books = await response.json();
                console.log(this.books);
                this.uploaderId = this.books.user_id;
            } catch (error) {
                console.error('Ошибка при получении деталей книги:', error.message);
            }
        },
        async checkAdminStatus() {
            try {
                const response = await fetch('/api/user');

                if (!response.ok) {
                    throw new Error('Не удалось получить информацию о пользователе');
                }
                const userData = await response.json();
                console.log(userData);
                this.userId = userData.id;
                // Предполагается, что в объекте userData есть поле is_admin
                this.isAdmin = userData.is_admin === 1;
                this.isAuthenticated = this.isAdmin;

            } catch (error) {
                console.error('Ошибка при проверке статуса администратора:', error.message);
            } finally {
                this.isCheckingAdminStatus = false; // Устанавливаем флаг в false, когда проверка завершена
            }
        },
        async deleteBook(bookId) {
            try {
                const response = await fetch(`/api/books/${bookId}`, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'), // Добавляем CSRF-токен
                    },
                });

                if (!response.ok) {
                    throw new Error(`Не удалось удалить книгу. ${response.statusText}`);
                }

                await this.fetchLatest();
                router.push('/')
                console.log('Книга успешно удалена');
            } catch (error) {
                console.error('Ошибка при удалении книги:', error.message);
            }
        },
    },
};
</script>

<template>
    <div class="card-container">
        <div class="form">
            <div class="card">
                <img :src="books.cover_image" class="card-img-top" alt="...">
                <div class="card-body">

                    <router-link :to="{ name: 'BookContent', params: { id: books.id}}" class="btn btn-primary">
                        Читать
                    </router-link>
                </div>
            </div>
            <div class="card-info">
                <h3 class="card-title"><b>{{ books.title }}</b></h3>
                <h4><i>{{ books.author.full_name }} - {{ books.publication_year }}</i></h4>
                <hr>
                <p>{{ books.description }}</p>
                <hr style="margin-top: auto">
            </div>
            <router-link v-if="(isAdmin && !isCheckingAdminStatus && this.isAuthenticated) || (userId === uploaderId)"
                         :to="{ name: 'BookUpdate', params: { id: books.id}}"
                         class="btn btn-outline-primary">
                Редактировать
            </router-link>
            <button v-if="isAdmin && !isCheckingAdminStatus && this.isAuthenticated" @click="deleteBook(books.id)"
                    class="btn btn-outline-danger">
                Удалить
            </button>
            <button v-if="isAdmin && !isCheckingAdminStatus && this.isAuthenticated" @click="toggleVisibility(books.id)"
                    class="btn btn-outline-secondary">
                {{ (books && books.visible !== undefined) ? (books.visible ? 'Скрыть' : 'Отобразить') : '' }}
            </button>
        </div>
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
    height: 28.4rem;
    padding-left: 5px;
    padding-right: 5px;
    word-wrap: break-word;
}
</style>
