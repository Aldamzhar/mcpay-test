<template>
    <Layout>
        <div class="profile">
            <h1>Профиль</h1>
            <div class="user-info">
                <p><strong>Имя:</strong> {{ user.name }}</p>
                <p><strong>Почта:</strong> {{ user.email }}</p>
                <p><strong>Роль:</strong> {{ user.role.name }}</p>
            </div>
            <button @click="logout" class="btn logout-btn">Выйти</button>
        </div>
    </Layout>
</template>

<script setup>
import { usePage } from '@inertiajs/vue3';
import { Inertia } from '@inertiajs/inertia';
import Layout from '../../Components/Layout.vue'

const { props } = usePage();
const user = props.user;

const logout = () => {
    Inertia.post('/logout');
};
</script>

<style scoped>
.profile {
    max-width: 600px;
    margin: 60px auto;
    padding: 25px;
    background-color: #fff;
    border-radius: 8px;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
}
h1 {
    text-align: center;
    color: #333;
}
.user-info {
    background-color: #f1f1f1;
    padding: 15px;
    border-radius: 8px;
    margin-bottom: 20px;
}
.logout-btn {
    background-color: #f44336;
    color: white;
    width: 100%;
    padding: 10px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}
.logout-btn:hover {
    background-color: #e53935;
}
</style>
