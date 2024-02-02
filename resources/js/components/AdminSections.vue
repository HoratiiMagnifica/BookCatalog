<script>
import axios from 'axios';

export default {
    data() {
        return {
            title: null,
            description: null,
        };
    },
    methods: {
        async addSection() {
            try {
                const response = await axios.post('/admin/sections', {
                    title: this.title,
                    description: this.description,
                });

                console.log(response.data.message); // Выводим сообщение об успехе
                console.log(response.data.section); // Выводим информацию о созданной секции

                // Очищаем поля формы после успешного создания секции
                this.title = null;
                this.description = null;
            } catch (error) {
                console.error('Error adding section:', error.message);
            }
        }


}};
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
            <button type="submit" @click.prevent="addSection" class="btn btn-primary">
                Add Section
            </button>
        </div>
    </div>
</template>


<style scoped>

</style>
