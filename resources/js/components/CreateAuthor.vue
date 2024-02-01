<script>
import axios from 'axios';

export default {
    data() {
        return {
            full_name: null,
            birth_country: null,
            comment: null,
            pictureUrl: null,
        };
    },
    methods: {
        async addAuthor() {
            try {
                const response = await axios.post('/admin/author/create', {
                    full_name: this.full_name,
                    birth_country: this.birth_country,
                    comment: this.comment,
                    pictureUrl: this.pictureUrl,
                });

                console.log(response.data.message);
                console.log(response.data.author);



            } catch (error) {
                console.error('Error adding author:', error.message);
            }
        }


}};
</script>

<template>
    <div>

        <div>
            <label for="name">ФИО</label>
            <input type="text" name="full_name" v-model="full_name" id="full_name" placeholder="Enter name">
        </div>
        <div>
            <label for="name">Страна рождения</label>
            <input type="text" name="birth_country" v-model="birth_country" id="birth_country"
                   placeholder="Enter birth country">
        </div>
        <div>
            <label for="name">comment</label>
            <textarea type="text" name="comment" v-model="comment" id="comment" placeholder="Enter comment"></textarea>
        </div>
        <div>
            <label for="name">picture Url</label>
            <input type="text" name="pictureUrl" v-model="pictureUrl" id="pictureUrl"  placeholder="Enter picture Url">
        </div>
        <div>
            <button type="submit" @click.prevent="addAuthor">
                Add
            </button>
        </div>


    </div>
</template>

<style scoped>

</style>
