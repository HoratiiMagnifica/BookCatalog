<script>
import axios from 'axios';

export default {
    data() {
        return {
            section: {},
            title: null,
            description: null,
        };
    },
    mounted() {
        const sectionId = this.$route.params.id;
        this.fetchSection(sectionId)
    },
    methods: {
        async fetchSection(sectionId) {
            try {
                const response = await fetch(`/api/sections/${sectionId}`);
                if (!response.ok) {
                    throw new Error('Не удалось получить разделы');
                }
                const data = await response.json();
                this.section = data;
            } catch (error) {
                console.error('Ошибка при получении разделов:', error.message);
            }
        },

        async editSection(sectionId) {
            try {
                const response = await axios.patch(`/admin/sections/${sectionId}`, {
                    title: this.title,
                    description: this.description,
                });

                console.log(response.data.message); // Выводим сообщение об успехе
                console.log(response.data.section); // Выводим информацию о созданной секции

                // Очищаем поля формы после успешного создания секции
            } catch (error) {
                console.error('Error adding section:', error.message);
            }
        }
    },

};
</script>

<template>
    <div class="container mt-4">
        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" name="title" v-model="title" id="title" class="form-control" placeholder="Enter title">
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea type="text" name="description" v-model="description" id="description" class="form-control" placeholder="Enter description"></textarea>
        </div>
        <div>
            <button type="submit" @click.prevent="editSection(section.id)" class="btn btn-primary">
                Edit
            </button>
        </div>
    </div>
</template>


<style scoped>

</style>
