<template>
    <div v-if="!loading">
        <div class="card-container" >
            <div v-for="author in filteredAuthors" :key="author.id" class="form" >
                <div class="card">
                    <img :src="author.pictureUrl" class="card-img-top" alt="...">
                    <div class="card-body">



                        <router-link
                            :to="{ name: 'books-by-author', params: { id: author.id }}"
                            class="btn btn-primary"
                        >
                            Произведения
                        </router-link>
                    </div>
                </div>
                <div class="card-info">
                    <h3 class="card-title"><b>{{ author.full_name }}</b></h3>
                    <h4><i>{{  author.birth_country  }}</i></h4>
                    <hr>
                    <p>{{  author.comment  }}</p>
                    <hr style="margin-top: auto">
                </div>
                <button v-if="isAdmin && !isCheckingAdminStatus && this.isAuthenticated" @click="deleteAuthor(author.id)" class="btn btn-outline-danger">
                    Удалить автора
                </button>
                <button v-if="isAdmin && !isCheckingAdminStatus && this.isAuthenticated" @click="toggleVisibility(author.id)" class="btn btn-outline-secondary">
                    {{ (author && author.visible !== undefined) ? (author.visible ? 'Скрыть' : 'Отобразить') : '' }}
                </button>
                <router-link v-if="isAdmin && !isCheckingAdminStatus && this.isAuthenticated" :to="{ name: 'AdminAuthorUpdate', params: { id: author.id}}" class="btn btn-outline-primary">
                    Редактировать
                </router-link>

            </div>
            <router-link v-if="isAdmin && !isCheckingAdminStatus && this.isAuthenticated" :to="{ name: 'CreateAuthor'}" class="btn btn-outline-primary">
                Добавить автора
            </router-link>
        </div>
    </div>
    <p v-else>Loading...</p>
</template>

<script>
import axios from "axios";
import AdminAuthorUpdate from "./AdminAuthorUpdate.vue";

export default {
    data() {
        return {
            authors: [],
            isAdmin: false,
            isCheckingAdminStatus: true,
            loading: false,
            isAuthenticated: false,
        };
    },
    created() {
        this.fetchAuthors();
        this.isAdmin = this.checkAdminStatus();
    },
    computed: {
        AdminAuthorUpdate() {
            return AdminAuthorUpdate
        },
        filteredAuthors() {
            // Используем loading для отслеживания состояния загрузки
            return this.loading ? [] : (this.isAdmin && this.isAuthenticated ? this.authors : this.authors.filter(section => section.visible));
        }
    },
    methods: {
        async fetchAuthors() {
            this.loading = true;
            try {
                const response = await fetch('/api/authors');
                if (!response.ok) {
                    throw new Error('Не удалось получить список авторов');
                }
                const data = await response.json();
                this.authors = data;
            } catch (error) {
                console.error('Ошибка при получении списка авторов:', error.message);
            } finally {
                // Устанавливаем флаг loading в false после завершения запроса через короткую задержку
                setTimeout(() => {
                    this.loading = false;
                }, 200); // Измените значение задержки по необходимости
            }
        },
        async deleteAuthor(authorId) {
            try {
                const response = await fetch(`/api/authors/${authorId}`, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'), // Добавляем CSRF-токен
                    },
                });

                if (!response.ok) {
                    throw new Error(`Не удалось удалить автора. ${response.statusText}`);
                }

                await this.fetchAuthors();
                this.selectedSectionId = null;
                this.books = [];
                console.log('Автор успешно удален');
            } catch (error) {
                console.error('Ошибка при удалении автора:', error.message);
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

                // Предполагается, что в объекте userData есть поле is_admin
                this.isAdmin = userData.is_admin === 1;
                this.isAuthenticated = this.isAdmin;
            } catch (error) {
                console.error('Ошибка при проверке статуса администратора:', error.message);
            } finally {
                this.isCheckingAdminStatus = false; // Устанавливаем флаг в false, когда проверка завершена
            }
        },
        async toggleVisibility(authorId) {
            console.log(authorId)

            try {
                const authorIndex = this.authors.findIndex(a => a.id === authorId);
                console.log(authorIndex);

                if (authorIndex !== -1) {
                    const updatedAuthor = await axios.put(`/api/authors/${authorId}/toggle-visibility`, {
                        visible: !this.authors[authorIndex].visible, // инвертировать значение
                    });


                    // Обновите свойство visible локально без повторного запроса на сервер
                    this.authors[authorIndex] = updatedAuthor.data;
                }
            } catch (error) {
                console.error(error);
            }
        },
    },
};
</script>

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
