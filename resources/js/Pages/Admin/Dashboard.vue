<template>
    <Layout>
        <div class="dashboard-container">
            <h1>Админ-панель</h1>

            <button class="btn add-btn" @click="showAddUserModal = true">Добавить пользователя</button>

            <div v-if="showAddUserModal" class="modal-overlay" @click="closeModal">
                <div class="modal-content" @click.stop>
                    <h2>Добавить пользователя</h2>
                    <form @submit.prevent="createUser">
                        <input v-model="newUser.name" type="text" placeholder="Имя" required />
                        <input v-model="newUser.email" type="email" placeholder="Почта" required />
                        <input v-model="newUser.password" type="password" placeholder="Пароль" required />
                        <select v-model="newUser.role_id">
                            <option v-for="role in roles" :value="role.id" :key="role.id">
                                {{ role.name }}
                            </option>
                        </select>
                        <button type="submit" class="btn submit-btn">Сохранить</button>
                        <button type="button" class="btn cancel-btn" @click="closeModal">Отмена</button>
                    </form>
                </div>
            </div>

            <table class="user-table">
                <thead>
                <tr>
                    <th>Имя</th>
                    <th>Почта</th>
                    <th>Роль</th>
                    <th>Действия</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="user in users" :key="user.id">
                    <td>{{ user.name }}</td>
                    <td>{{ user.email }}</td>
                    <td>{{ user.role.name }}</td>
                    <td class="action-buttons">
                        <button class="btn edit-btn" @click="editUser(user)">Изменить</button>
                        <button class="btn delete-btn" @click="deleteUser(user.id)">Удалить</button>
                    </td>
                </tr>
                </tbody>
            </table>
            <button @click="logout" class="btn logout-btn">Выйти</button>

            <div v-if="showEditUserModal" class="modal-overlay" @click="closeModal">
                <div class="modal-content" @click.stop>
                    <h2>Edit User</h2>
                    <form @submit.prevent="updateUser">
                        <input v-model="editingUser.name" type="text" placeholder="Имя" required />
                        <input v-model="editingUser.email" type="email" placeholder="Почта" required />
                        <input v-model="editingUser.password" type="password" placeholder="Новый пароль (оставить пустым без имзенений)" />
                        <select v-model="editingUser.role_id">
                            <option v-for="role in roles" :value="role.id" :key="role.id">
                                {{ role.name }}
                            </option>
                        </select>
                        <button type="submit" class="btn submit-btn">Обновить</button>
                        <button type="button" class="btn cancel-btn" @click="closeModal">Отменить</button>
                    </form>
                </div>
            </div>
        </div>
    </Layout>
</template>

<script setup>
import Layout from '../../Components/Layout.vue';
import { usePage, useForm } from '@inertiajs/vue3';
import { Inertia } from '@inertiajs/inertia';
import { ref } from 'vue';

const { props } = usePage();
const users = props.users;
const roles = props.roles;

const logout = () => {
    Inertia.post('/logout');
};

const showAddUserModal = ref(false);
const showEditUserModal = ref(false);

const newUser = useForm({
    name: '',
    email: '',
    password: '',
    role_id: ''
});

const editingUser = useForm({
    name: '',
    email: '',
    password: '',
    role_id: ''
});

const createUser = () => {
    newUser.post('/users', {
        onSuccess: () => {
            newUser.reset();
            showAddUserModal.value = false;
            Inertia.reload({ only: ['users'] });
        },
        onError: (errors) => {
            console.error('Error creating user:', errors);
        }
    });
};

const editUser = (user) => {
    editingUser.name = user.name;
    editingUser.email = user.email;
    editingUser.password = '';
    editingUser.role_id = user.role_id;
    editingUser.id = user.id;
    showEditUserModal.value = true;
};


const updateUser = () => {
    editingUser.put(`/users/${editingUser.id}`, {
        onSuccess: () => {
            editingUser.reset();
            showEditUserModal.value = false;
            Inertia.reload({ only: ['users'] });
        },
        onError: (errors) => {
            console.error('Error updating user:', errors);
        }
    });
};

const deleteUser = (userId) => {
    if (confirm('Are you sure you want to delete this user?')) {
        Inertia.delete(`/users/${userId}`, {
            onSuccess: () => {
                Inertia.reload({ only: ['users'] });
            },
            onError: (errors) => {
                console.error('Error deleting user:', errors);
            }
        });
    }
};

const closeModal = () => {
    showAddUserModal.value = false;
    showEditUserModal.value = false;
    editingUser.reset();
};
</script>

<style scoped>
.dashboard-container {
    display: flex;
    flex-direction: column;
    align-items: center;
    max-width: 800px;
    margin: 0 auto;
    padding: 20px;
    background-color: #fff;
    border-radius: 8px;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
}

.btn {
    padding: 10px 20px;
    border-radius: 5px;
    cursor: pointer;
    font-size: 14px;
    transition: all 0.3s ease;
}

.add-btn {
    background-color: #4CAF50;
    color: white;
    margin-bottom: 15px;
}

.user-table {
    width: 100%;
    margin-bottom: 15px;
    border-collapse: collapse;
}

.user-table th, .user-table td {
    padding: 12px;
    text-align: left;
    border-bottom: 1px solid #ddd;
}

.user-table th {
    background-color: #4CAF50;
    color: white;
    text-align: left;
}

.action-buttons .btn {
    margin: 0 5px;
}

.edit-btn {
    background-color: #ffc107;
    color: white;
}

.delete-btn {
    background-color: #f44336;
    color: white;
}

.logout-btn {
    background-color: #f44336;
    color: white;
    width: 100%;
    padding: 10px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 14px;
    text-align: center;
    transition: background-color 0.3s ease;
}
.logout-btn:hover {
    background-color: #e53935;
}

.modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.6);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 1000;
    transition: background 0.3s ease;
}

.modal-content {
    background-color: #fff;
    padding: 30px;
    border-radius: 10px;
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.25);
    width: 100%;
    max-width: 500px;
    position: relative;
    animation: scaleIn 0.3s ease-out;
    transition: all 0.3s ease;
}

@keyframes scaleIn {
    from {
        transform: scale(0.95);
        opacity: 0;
    }
    to {
        transform: scale(1);
        opacity: 1;
    }
}

.submit-btn {
    background-color: #28a745;
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-weight: bold;
    font-size: 14px;
    transition: background-color 0.3s ease;
}

.submit-btn:hover {
    background-color: #218838;
}

.cancel-btn {
    background-color: #6c757d;
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-weight: bold;
    font-size: 14px;
    margin-left: 10px;
    transition: background-color 0.3s ease;
}

.cancel-btn:hover {
    background-color: #5a6268;
}

input[type="text"],
input[type="email"],
input[type="password"],
select {
    width: 100%;
    padding: 12px;
    margin: 8px 0;
    border-radius: 5px;
    border: 1px solid #ccc;
    font-size: 14px;
    transition: border-color 0.3s ease;
}

input[type="text"]:focus,
input[type="email"]:focus,
input[type="password"]:focus,
select:focus {
    border-color: #4CAF50;
    outline: none;
}

@keyframes slideIn {
    from {
        transform: translateY(-20px);
        opacity: 0;
    }
    to {
        transform: translateY(0);
        opacity: 1;
    }
}

</style>
