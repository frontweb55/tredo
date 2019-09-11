<template>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <router-link :to="'/'" class="navbar-brand m-auto nav-link">Главная</router-link>
        <router-link :to="'/employee'" class="navbar-brand m-auto nav-link">Сотрудники</router-link>
        <router-link :to="'/department'" class="navbar-brand m-auto nav-link">Отделы</router-link>
    </nav>
</template>
<script>
    export default {}
</script>

<style>
    .navbar {
        margin-bottom: 30px;
    }
</style>
