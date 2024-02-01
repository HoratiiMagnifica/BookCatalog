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
    <div>

        <div>
            <label for="name">title</label>
            <input type="text" name="title" v-model="title" id="title" placeholder="Enter title">
        </div>
        <div>
            <label for="name">description</label>
            <textarea type="text" name="description" v-model="description" id="description"
                   placeholder="Enter description"></textarea>
        </div>
        <div>
            <button type="submit" @click.prevent="addSection">
                Add section
            </button>
        </div>


    </div>
</template>

<style scoped>

</style>
