<script>
export default {
    data() {
        return {
            sections: [], // Список разделов
        };
    },
    created() {
        this.fetchSections(); // Получаем разделы при загрузке компонента
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
    },
};
</script>

<template>

    <div>
        <h2>Список разделов</h2>
        <ul>
            <li v-for="section in sections" :key="section.id">
                {{ section.title }} - {{ section.description }}
            </li>
        </ul>
    </div>

</template>

<style scoped>

</style>
