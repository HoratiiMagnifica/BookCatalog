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
    <div>

        <div>
            <label for="name">title</label>
            <input type="text" name="title" v-model="title" id="title"   placeholder="Enter title">
        </div>
        <div>
            <label for="name">publication year</label>
            <input type="text" name="publication_year" v-model="publication_year" id="publication_year"
                   placeholder="Enter publication year">
        </div>
        <div>
            <label for="name">description</label>
            <textarea type="text" name="description" v-model="description" id="description" placeholder="Enter description"></textarea>
        </div>
        <div>
            <label for="name">comment</label>
            <textarea type="text" name="content" v-model="content" id="content" placeholder="Enter content"></textarea>
        </div>
        <div>
            <label for="name">picture Url</label>
            <input type="text" name="cover_image" v-model="cover_image" id="cover_image"  placeholder="Enter picture Url">
        </div>
        <select class="form-select" aria-label="Выбор секции"  v-model="section_id">
            <option v-for="section in this.sections" :key="section.id" :value="section.id">{{section.title}}</option>
        </select>
        <select class="form-select" aria-label="Выбор автора" v-model="author_id" >
            <option v-for="author in this.authors" :key="author.id"  :value="author.id">{{author.full_name}}</option>
        </select>
        <div>
            <button type="submit" @click.prevent="addBook">
                Edit
            </button>
        </div>


    </div>
</template>

<style scoped>

</style>
