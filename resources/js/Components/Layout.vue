<template>
    <div>
        <main class="main-content">
            <slot />
        </main>
    </div>
</template>

<script setup>
import { usePage } from '@inertiajs/vue3';

const { props } = usePage();
const user = props.auth?.user;
</script>

<style scoped>
.header {
    background-color: white;
    padding: 15px 0;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}
.nav-container {
    display: flex;
    justify-content: center;
}
.nav-links {
    display: flex;
    gap: 20px;
    list-style: none;
}
.nav-links li {
    display: inline;
}
.nav-links a {
    color: #fff;
    font-weight: bold;
    text-decoration: none;
    transition: color 0.3s;
}
.nav-links a:hover {
    color: #C8E6C9;
}
.main-content {
    padding: 40px;
    min-height: 70vh;
    background-color: white;
}
.footer {
    background-color: white;
    color: #fff;
    text-align: center;
    padding: 15px 0;
    font-size: 0.9em;
}
</style>
