<script>
import axios from 'axios';


export default {
    data() {
        return {
            sections: [],        // Список разделов
            selectedSectionId: null, // Идентификатор выбранной секции
            books: [],           // Список книг
            isAdmin: false,
            isCheckingAdminStatus: true,
            loading: false,
            isAuthenticated: false,// значение по умолчанию
        };
    },

    created() {
        this.fetchSections(); // Получаем разделы при загрузке компонента
        this.isAdmin = this.checkAdminStatus();

    },
    computed: {
        filteredSections() {
            // Используем loading для отслеживания состояния загрузки
            return this.loading ? [] : (this.isAdmin && this.isAuthenticated ? this.sections : this.sections.filter(section => section.visible));
        }
    },
    methods: {

        async fetchSections() {
            this.loading = true;
            try {
                const response = await fetch('/api/sections');
                if (!response.ok) {
                    throw new Error('Не удалось получить разделы');
                }
                const data = await response.json();
                this.sections = data;
            } catch (error) {
                console.error('Ошибка при получении разделов:', error.message);
            } finally {
                // Устанавливаем флаг loading в false после завершения запроса через короткую задержку
                setTimeout(() => {
                    this.loading = false;
                }, 200); // Измените значение задержки по необходимости
            }
        },
        async fetchBooksBySection(sectionId) {
            try {
                const response = await fetch(`/api/sections/${sectionId}/books`);
                if (!response.ok) {
                    throw new Error('Не удалось получить книги для секции. Код ошибки: ' + response.status);
                }
                const data = await response.json();

                // Модифицируем данные, добавляя информацию об авторе для каждой книги
                const booksWithAuthorInfo = await Promise.all(data.map(async book => {
                    const authorResponse = await fetch(`/api/authors/${book.author_id}`);
                    if (!authorResponse.ok) {
                        throw new Error('Не удалось получить информацию об авторе. Код ошибки: ' + authorResponse.status);
                    }
                    const authorData = await authorResponse.json();
                    return {
                        ...book,
                        author: authorData,  // Добавляем информацию об авторе
                    };
                }));

                this.books = booksWithAuthorInfo;
                this.selectedSectionId = sectionId;
                console.log(this.books)
            } catch (error) {
                console.error('Ошибка при получении книг для секции:', error.message);
            }
        },
        async fetchLatest() {
            try {
                const response = await fetch('/api/latest_books');
                if (!response.ok) {
                    throw new Error('Не удалось получить последние книги');
                }
                const data = await response.json();

                // Преобразуем данные, добавляя поле 'coverUrl' для каждой книги
                this.books = data.map(book => ({
                    ...book,
                    coverUrl: book.cover_image,
                    // Предполагается, что в API есть поле 'cover_image'
                }));

            } catch (error) {
                console.error('Ошибка при получении последних книг:', error.message);
            }
        },


        async checkAdminStatus() {
            try {
                const response = await fetch('/api/user');
                if (!response.ok) {
                    throw new Error('Не удалось получить информацию о пользователе');
                }
                const userData = await response.json();
                console.log(userData)
                // Предполагается, что в объекте userData есть поле is_admin
                this.isAdmin = userData.is_admin === 1;
                this.isAuthenticated = this.isAdmin
                console.log(this.isAuthenticated)
            } catch (error) {
                console.error('Ошибка при проверке статуса администратора:', error.message);
            } finally {
                this.isCheckingAdminStatus = false; // Устанавливаем флаг в false, когда проверка завершена
            }
        }, // Верните true, если пользователь администратор, иначе false
        async deleteSection(sectionId) {
            try {
                const response = await fetch(`/api/sections/${sectionId}`, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'), // Добавляем CSRF-токен
                    },
                });

                if (!response.ok) {
                    throw new Error(`Не удалось удалить раздел. ${response.statusText}`);
                }

                await this.fetchSections();
                this.selectedSectionId = null;
                this.books = [];
                console.log('Раздел успешно удален');
            } catch (error) {
                console.error('Ошибка при удалении раздела:', error.message);
            }
        },
        async toggleVisibility(sectionId) {
            console.log(sectionId)
            try {
                const sectionIndex = this.sections.findIndex(s => s.id === sectionId);

                if (sectionIndex !== -1) {
                    const updatedSection = await axios.put(`/api/sections/${sectionId}/toggle-visibility`, {
                        visible: !this.sections[sectionIndex].visible, // инвертировать значение
                    });

                    // Обновите свойство visible локально без повторного запроса на сервер
                    this.sections[sectionIndex] = updatedSection.data;
                }
            } catch (error) {
                console.error(error);
            }
        },


    },


};
</script>

<template>
    <div>
        <h2>Список разделов</h2>
        <ul v-if="!loading">
            <li v-for="section in filteredSections" :key="section.id" @click="fetchBooksBySection(section.id)">
                <div>
                    {{ section.title }} - {{ section.description }}
                </div>
                <button v-if="isAdmin && !isCheckingAdminStatus && isAuthenticated" @click="deleteSection(section.id)" class="btn btn-outline-danger">
                    Удалить секцию
                </button>
                <button v-if="isAdmin && !isCheckingAdminStatus && isAuthenticated" @click="toggleVisibility(section.id)" class="btn btn-outline-secondary">
                    {{ (section && section.visible !== undefined) ? (section.visible ? 'Скрыть' : 'Отобразить') : '' }}
                </button>
                <router-link v-if="isAdmin && !isCheckingAdminStatus && isAuthenticated" :to="{ name: 'adminSectionUpdate', params: { id: section.id}}" class="btn btn-outline-primary">
                    Редактировать
                </router-link>
            </li>
        </ul>
        <p v-else>Loading...</p>
        <div>
            <router-link v-if="isAdmin && !isCheckingAdminStatus && isAuthenticated" :to="{ name: 'adminSections' }">
                <button class="btn btn-outline-primary">Add Section</button>
            </router-link>
        </div>
        <div>
            <div class="card-container">
                <div v-for="book in books" :key="book.id" class="form">
                    <div class="card">
                        <img :src="book.cover_image" class="card-img-top" alt="...">
                        <div class="card-body">


                            <router-link :to="{ name: 'book-details', params: { id: book.id }}" class="btn btn-primary">
                                Читать
                            </router-link>
                        </div>
                    </div>
                    <div class="card-info">
                        <h3 class="card-title"><b>{{ book.title }}</b></h3>
                        <h4><i>{{ book.author.full_name }} - {{ book.publication_year }}</i></h4>
                        <hr>
                        <p>{{ book.description }}</p>
                        <hr style="margin-top: auto">
                    </div>


                </div>

            </div>
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
