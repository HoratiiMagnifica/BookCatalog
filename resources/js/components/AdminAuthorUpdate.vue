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
    <div>

        <div>
            <label for="name">ФИО</label>
            <input type="text" name="full_name" v-model="full_name" id="full_name" value="{{ author.full_name }}"  placeholder="Enter name">
        </div>
        <div>
            <label for="name">Страна рождения</label>
            <input type="text" name="birth_country" v-model="birth_country" id="birth_country"
                      content="{{ author.birth_country }}" placeholder="Enter birth country">
        </div>
        <div>
            <label for="name">comment</label>
            <textarea type="text" name="comment" v-model="comment" id="comment" placeholder="Enter comment">{{ author.comment }}</textarea>
        </div>
        <div>
            <label for="name">picture Url</label>
            <input type="text" name="pictureUrl" v-model="pictureUrl" id="pictureUrl" value="{{ author.pictureUrl }}"  placeholder="Enter picture Url">
        </div>
        <div>
            <button type="submit" @click.prevent="editAuthor(author.id)">
                Edit
            </button>
        </div>


    </div>
</template>

<style scoped>

</style>
