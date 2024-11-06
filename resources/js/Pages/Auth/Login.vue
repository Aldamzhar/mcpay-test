<template>
    <div class="auth-container">
        <h1>Войти</h1>
        <form @submit.prevent="login">
            <div class="form-group">
                <label>Почта</label>
                <input v-model="form.email" type="email" placeholder="Введите эл.почту" required />
            </div>
            <div class="form-group">
                <label>Пароль</label>
                <input v-model="form.password" type="password" placeholder="Введите пароль" required />
            </div>
            <button type="submit" class="btn">Login</button>
        </form>
    </div>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3';

const form = useForm({
    email: '',
    password: '',
});

const login = () => {
    form.post(route('login'), {
        onSuccess: () => {
            console.log('Logged in successfully');
        },
        onError: (errors) => {
            console.error('Login failed:', errors);
        }
    });
};
</script>

<style scoped>
.auth-container {
    max-width: 400px;
    margin: 100px auto;
    padding: 30px;
    background-color: #fff;
    border-radius: 10px;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
}
h1 {
    text-align: center;
    color: #333;
}
.form-group {
    margin-bottom: 15px;
}
.form-group label {
    font-weight: bold;
}
input {
    width: 100%;
    padding: 10px;
    margin-top: 5px;
    border-radius: 5px;
    border: 1px solid #ccc;
}
.btn {
    width: 100%;
    padding: 10px;
    background-color: #4CAF50;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-weight: bold;
}
.btn:hover {
    background-color: #45a049;
}
</style>
