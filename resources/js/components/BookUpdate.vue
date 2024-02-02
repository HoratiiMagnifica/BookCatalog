<script>
import axios from 'axios';

export default {
    data() {
        return {
            authors: [],
            sections: [],
            book: {},
            title: null,
            publication_year: null,
            description: null,
            comment: null,
            cover_image: null,
            section_id: null,
            author_id: null,
        };
    },
    mounted() {
        const bookId = this.$route.params.id;
        this.fetchSections();
        this.fetchAuthors();
        this.fetchBook(bookId);

    },
    methods: {
        async fetchSections() {
            try {
                const response = await fetch('/api/sections');
                if (!response.ok) {
                    throw new Error('Не удалось получить разделы');
                }
                const data = await response.json();
                this.sections = data;
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
            } catch (error) {
                console.error('Ошибка при получении списка авторов:', error.message);
            }
        },
        async fetchBook(bookId) {
            try {
                const response = await fetch(`/api/books/${bookId}`);
                if (!response.ok) {
                    throw new Error('Не удалось получить автора');
                }
                const data = await response.json();
                this.book = data;
                this.title = data.title;
                this.cover_image = data.cover_image;
                this.comment = data.comment;
                this.description = data.description;
                this.publication_year = data.publication_year;
                this.section_id = data.section_id;
                this.author_id = data.author_id;
                console.log(this.book)
            } catch (error) {
                console.error('Ошибка при получении автора:', error.message);
            }
        },

        async editBook(bookId) {
            try {
                const response = await axios.patch(`/book/${bookId}/edit`, {
                    title: this.title,
                    publication_year: this.publication_year,
                    description: this.description,
                    comment: this.comment,
                    cover_image: this.cover_image,
                    section_id: this.section_id,
                    author_id: this.author_id

                });

                console.log(response.data.message); // Выводим сообщение об успехе
                console.log(response.data.author); // Выводим информацию о созданной секции

                // Очищаем поля формы после успешного создания секции
            } catch (error) {
                console.error('Error adding author:', error.message);
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
                    <label for="comment">Comment</label>
                    <textarea type="text" name="comment" v-model="comment" class="form-control" id="comment" placeholder="Enter comment"></textarea>
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
                    <button type="submit" class="btn btn-primary" @click.prevent="editBook(book.id)">
                        Edit
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>

</style>
