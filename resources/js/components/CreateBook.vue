<script>
import axios from 'axios';

export default {
    data() {
        return {
            authors: [],
            sections: [],
            title: null,
            publication_year: null,
            description: null,
            content: null,
            cover_image: null,
            section_id: null,
            author_id: null,
            userId: null,

        };
    },
    mounted() {
        this.fetchSections();
        this.fetchAuthors();
        this.getUserId();

    },
    methods: {
        async getUserId() {
            try {
                const response = await fetch('/api/user');

                if (!response.ok) {
                    throw new Error('Не удалось получить информацию о пользователе');
                }
                const userData = await response.json();
                console.log(userData);
                this.userId = userData.id;
            } catch (error) {
                console.error('Ошибка при получении user_id:', error.message);
            }
        },
        async fetchSections() {
            try {
                const response = await fetch('/api/sections');
                if (!response.ok) {
                    throw new Error('Не удалось получить разделы');
                }
                const data = await response.json();
                this.sections = data;
                console.log(this.sections);

            } catch (error) {
                console.error('Ошибка при получении разделов:', error.message);
            }
        },
        async fetchAuthors() {
            try {
                const response = await fetch('/api/authors');
                if (!response.ok) {
                    throw new Error('Не удалось получить список авторов');
                }
                const data = await response.json();
                this.authors = data;
                console.log(this.authors);
            } catch (error) {
                console.error('Ошибка при получении списка авторов:', error.message);
            }
        },

        async addBook() {
            try {
                const newBook = {
                    title: this.title,
                    publication_year: this.publication_year,
                    description: this.description,
                    content: this.comment,
                    cover_image: this.cover_image,
                    section_id: this.section_id,
                    author_id: this.author_id,
                    user_id: this.userId,
                }
                console.log(newBook);
                const response = await axios.post(`/book/create`, {
                    title: this.title,
                    publication_year: this.publication_year,
                    description: this.description,
                    content: this.content,
                    cover_image: this.cover_image,
                    section_id: this.section_id,
                    author_id: this.author_id,
                    user_id: this.userId,

                });

                console.log(response.data.message); // Выводим сообщение об успехе
                console.log(response.data.author); // Выводим информацию о созданной секции

                // Очищаем поля формы после успешного создания секции
            } catch (error) {
                console.error('Error adding book:', error.response.data);
            }
        }
    },

};
</script>

<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div>
                    <label for="title">Title</label>
                    <input type="text" name="title" v-model="title" class="form-control" id="title" placeholder="Enter title">
                </div>
                <div class="mb-3">
                    <label for="publication_year">Publication Year</label>
                    <input type="text" name="publication_year" v-model="publication_year" class="form-control" id="publication_year" placeholder="Enter publication year">
                </div>
                <div class="mb-3">
                    <label for="description">Description</label>
                    <textarea type="text" name="description" v-model="description" class="form-control" id="description" placeholder="Enter description"></textarea>
                </div>
                <div class="mb-3">
                    <label for="content">Content</label>
                    <textarea type="text" name="content" v-model="content" class="form-control" id="content" placeholder="Enter content"></textarea>
                </div>
                <div class="mb-3">
                    <label for="cover_image">Picture URL</label>
                    <input type="text" name="cover_image" v-model="cover_image" class="form-control" id="cover_image" placeholder="Enter picture URL">
                </div>
                <div class="mb-3">
                    <label for="section_id">Section</label>
                    <select class="form-select" aria-label="Select Section" v-model="section_id">
                        <option v-for="section in sections" :key="section.id" :value="section.id">{{section.title}}</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="author_id">Author</label>
                    <select class="form-select" aria-label="Select Author" v-model="author_id">
                        <option v-for="author in authors" :key="author.id" :value="author.id">{{author.full_name}}</option>
                    </select>
                </div>
                <div>
                    <button type="submit" class="btn btn-primary" @click.prevent="addBook">
                        Edit
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>


<style scoped>

</style>
