<script>
export default {
    data() {
        return {
            author: {},
            books: [],
        };
    },
    created() {
        // Получаем id автора из параметров маршрута
        const authorId = this.$route.params.id;
        this.fetchAuthorAndBooks(authorId);
    },
    methods: {
        async fetchAuthorAndBooks(authorId) {
            try {
                // Получаем информацию об авторе
                const authorResponse = await fetch(`/api/authors/${authorId}`);
                const authorData = await authorResponse.json();
                this.author = authorData;
                console.log(this.author)

                // Получаем все книги автора
                const booksResponse = await fetch(`/api/authors/${authorId}/books`);
                const booksData = await booksResponse.json();
                this.books = booksData;
                console.log(this.books)
            } catch (error) {
                console.error('Ошибка при получении информации об авторе и книгах:', error.message);
            }
        },
    },
};
</script>

<template>
    <div>
        <h2>{{this.author.full_name}} - книги</h2>

        <div>
            <div class="card-container">
                <div v-for="book in books" :key="book.id" class="form" >
                    <div class="card">
                        <img :src="book.cover_image" class="card-img-top" alt="...">
                        <div class="card-body">


                            <router-link :to="{ name: 'book-details', params: { id: book.id }}" class="btn btn-primary">Читать</router-link>
                        </div>
                    </div>
                    <div class="card-info">
                        <h3 class="card-title"><b>{{ book.title }}</b></h3>
                        <h4><i>{{  this.author.full_name  }} - {{  book.publication_year  }}</i></h4>
                        <hr>
                        <p>{{  book.description  }}</p>
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
    height: 28.4rem ;
    padding-left: 5px;
    padding-right: 5px;
    word-wrap: break-word;
}
</style>
