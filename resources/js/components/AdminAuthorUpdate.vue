<script>
import axios from 'axios';

export default {
    data() {
        return {
            author: {},
            full_name: null,
            birth_country: null,
            comment: null,
            pictureUrl: null,
        };
    },
    mounted() {
        const authorId = this.$route.params.id;
        this.fetchAuthor(authorId)
    },
    methods: {
        async fetchAuthor(authorId) {
            try {
                const response = await fetch(`/api/authors/${authorId}`);
                if (!response.ok) {
                    throw new Error('Не удалось получить автора');
                }
                const data = await response.json();
                this.author = data;
            } catch (error) {
                console.error('Ошибка при получении автора:', error.message);
            }
        },

        async editAuthor(authorId) {
            try {
                const response = await axios.patch(`/admin/authors/${authorId}`, {
                    full_name: this.full_name,
                    birth_country: this.birth_country,
                    comment: this.comment,
                    pictureUrl: this.pictureUrl,
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
    <div class="container mt-4">
        <div class="mb-3">
            <label for="full_name" class="form-label">Full Name</label>
            <input type="text" name="full_name" v-model="full_name" id="full_name" class="form-control" placeholder="Enter name">
        </div>
        <div class="mb-3">
            <label for="birth_country" class="form-label">Birth Country</label>
            <input type="text" name="birth_country" v-model="birth_country" id="birth_country" class="form-control" placeholder="Enter birth country">
        </div>
        <div class="mb-3">
            <label for="comment" class="form-label">Comment</label>
            <textarea type="text" name="comment" v-model="comment" id="comment" class="form-control" placeholder="Enter comment">{{ author.comment }}</textarea>
        </div>
        <div class="mb-3">
            <label for="pictureUrl" class="form-label">Picture URL</label>
            <input type="text" name="pictureUrl" v-model="pictureUrl" id="pictureUrl" class="form-control" placeholder="Enter picture URL">
        </div>
        <div>
            <button type="submit" @click.prevent="editAuthor(author.id)" class="btn btn-primary">
                Edit
            </button>
        </div>
    </div>
</template>


<style scoped>

</style>
